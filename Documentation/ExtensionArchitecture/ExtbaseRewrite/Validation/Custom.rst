:navigation-title: Custom validators

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Custom validators
..  _extbase-validation-custom:

==================================
Writing a custom Extbase validator
==================================

When the :ref:`built-in validators <extbase-validation-builtin>` cannot
express a domain rule — for example "a conference end date must be after its
start date" or "registration is only open while seats remain" — write a
custom validator class and attach it with :php:`#[Validate]` just like any
built-in validator.

**Model property vs. action parameter** — where you place the validator
determines what it can see and when it runs.

A validator on a *model property* receives only that property's value. It
runs on every action that takes the model as an argument. Use it for
self-contained rules that must always hold: ``$title`` must not be empty,
``$contactEmail`` must be a valid address.

A validator on an *action parameter* receives the whole object and runs only
for that specific action. This makes it the right choice for two distinct
situations: rules that only apply in a particular context (a seat count check
that matters for ``registerAction()`` but not for ``showAction()``), and
rules that span multiple properties. For example: if a conference starts more
than four weeks from now, a speaker assignment is optional — but if it starts
sooner, a speaker is required. That rule cannot be expressed on any single
property; it needs both ``$startDate`` and ``$speaker`` at the same time:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Validation/Validator/ConferenceSpeakerValidator.php

    use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

    class ConferenceSpeakerValidator extends AbstractValidator
    {
        protected function isValid(mixed $value): void
        {
            $weeksUntilStart = (int)(($value->getStartDate()->getTimestamp() - time()) / 604800);
            if ($weeksUntilStart < 4 && $value->getSpeaker() === null) {
                $this->addErrorForProperty(
                    'speaker',
                    $this->translateErrorMessage('my_extension.messages:validator.conference.speakerRequired'),
                    1716300100,
                );
            }
        }
    }

Both approaches can be combined on the same type — property validators run
first, and action-parameter validators run afterwards.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-validation-custom-structure:

Structure of a custom validator
===============================

Custom validators extend
:php:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator` and
implement a single method :php:`isValid(mixed $value): void`. If a value
fails validation, call :php:`$this->addError()` or
:php:`$this->addErrorForProperty()` — do not throw an exception and do not
return anything. The framework reads :php:`$this->result` after
:php:`isValid()` returns.

Place validators in :file:`Classes/Validation/Validator/` inside your
extension, following the naming convention :php:`<Subject>Validator`:

..  literalinclude:: _snippets/_ConferenceDateValidator.php
    :caption: EXT:my_extension/Classes/Validation/Validator/ConferenceDateValidator.php

Key points:

*   Do not declare the class as :php:`final` — the same convention that applies
    to controllers applies here. Third parties can extend the validator.
*   :php:`$acceptsEmptyValues = true` (the default) means :php:`isValid()` is
    skipped when a value is :php:`null` or an empty string. Set it to
    :php:`false` only if a validator should explicitly reject empty values
    (as :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator`
    does).
*   The error code is an arbitrary integer that must be unique across your
    extension. Using the Unix timestamp at the time of writing is a convenient
    way to generate a unique number.
*   Translation keys use the domain syntax introduced in TYPO3 v14:
    ``my_extension.messages:some.key`` resolves to
    :file:`EXT:my_extension/Resources/Private/Language/locallang.xlf`. See
    :ref:`extbase-upgrading-translation-domain-syntax` for the full syntax
    including non-default language files.


..  _extbase-validation-custom-property-errors:

Reporting errors on a specific property
=======================================

:php:`$this->addErrorForProperty()` attaches the error to a named property of
the validated object rather than to the object itself. The
:ref:`t3viewhelper:typo3-fluid-form-validationresults` view helper can then
display the message adjacent to the right form field:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/New.fluid.html

    <f:form.validationResults for="conference.endDate">
        <f:for each="{validationResults.errors}" as="error">
            <p class="error">{error.message}</p>
        </f:for>
    </f:form.validationResults>

Use :php:`$this->addError()` instead when the error applies to the whole
object and does not belong to any single field.


..  _extbase-validation-custom-options:

Supporting options and substitution values in messages
======================================================

If your validator needs to be configured, for example, there needs to be a
minimum seat count, declare the options in :php:`$supportedOptions`. Each option contains
an array with values ``[default, description, type]``. Access resolved values using
:php:`$this->options`:

..  literalinclude:: _snippets/_SeatCountValidator.php
    :caption: EXT:my_extension/Classes/Validation/Validator/SeatCountValidator.php

The error message in :file:`locallang.xlf` uses a ``%s`` placeholder:

..  code-block:: xml
    :caption: EXT:my_extension/Resources/Private/Language/locallang.xlf (excerpt)

    <trans-unit id="validator.conference.notEnoughSeats">
        <source>At least %s seat(s) must be available for registration.</source>
    </trans-unit>

:php:`translateErrorMessage()` accepts the values to be substituted as its third
argument and passes them through :php:`vsprintf()`. The same values are passed
as the third argument to :php:`addError()`. They are stored in the
:php-short:`\TYPO3\CMS\Extbase\Validation\Error` object for programmatic
access:

..  code-block:: php
    :caption: Substitution values in translateErrorMessage() and addError()

    $this->addError(
        $this->translateErrorMessage($this->message, '', [$minimum]),
        1716300001, // An arbitrary unique number, for example the timestamp when writing the code
        [$minimum],
    );

Attach the validator with its option on the action parameter:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Validation\Validator\SeatCountValidator;
    use TYPO3\CMS\Extbase\Attribute\Validate;

    public function registerAction(
        #[Validate(SeatCountValidator::class, options: ['minimum' => 1])]
        Conference $conference,
    ): ResponseInterface {
        // Only reached when SeatCountValidator passes
    }


..  _extbase-validation-custom-translated-messages:

Making the error message overridable
====================================

To allow callers to override the message text via the ``options`` array
without having to subclass (the same mechanism used by built-in validators) declare
a :php:`protected string $message` property, add it to
:php:`$translationOptions`, and list it in :php:`$supportedOptions`. The
:php:`SeatCountValidator` above follows this pattern. A caller can
then replace the message at the call site:

..  code-block:: php
    :caption: Overriding the message at the call site

    #[Validate(SeatCountValidator::class, options: [
        'minimum' => 1,
        'message' => 'my_extension.messages:validator.conference.notEnoughSeats.short',
    ])]


..  _extbase-validation-custom-next:

What to read next
=================

*   :ref:`extbase-validation-builtin` — check whether a built-in validator
    already covers a constraint before writing a custom one.
*   :ref:`extbase-validation-overview` — how the framework triggers
    :php:`errorAction()` and how to display errors in Fluid templates.
