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
    :language: php
    :caption: EXT:my_extension/Classes/Validation/Validator/ConferenceDateValidator.php

Key points:

*   Do not declare the class as :php:`final` — the same convention that applies
    to controllers applies here. Third parties can extend the validator.
*   :php:`$acceptsEmptyValues = true` (the default) means :php:`isValid()` is
    skipped when a value is :php:`null` or an empty string. Set it to
    :php:`false` only if a validator should explicitly reject empty values
    (as :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator`
    does).
*   Use a `Unix timestamp <https://www.php.net/manual/en/function.time.php>`_
    as the error code. It must be unique across your extension.
*   Translation keys use the domain syntax introduced in TYPO3 v14:
    ``my_extension:some.key`` resolves to
    :file:`EXT:my_extension/Resources/Private/Language/locallang.xlf`. See
    :ref:`extbase-upgrading-translation-domain-syntax` for the full syntax
    including non-default language files.


..  _extbase-validation-custom-property-errors:

Reporting errors on a specific property
=======================================

:php:`$this->addErrorForProperty()` attaches the error to a named property of
the validated object rather than to the object itself. Fluid's
``f:form.validationResults`` view helper can then display the message adjacent
to the right form field:

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
    :language: php
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
        1716300001,
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
        'message' => 'my_extension:validator.conference.notEnoughSeats.short',
    ])]


..  _extbase-validation-custom-next:

What to read next
=================

*   :ref:`extbase-validation-builtin` — check whether a built-in validator
    already covers a constraint before writing a custom one.
*   :ref:`extbase-validation-overview` — how the framework triggers
    :php:`errorAction()` and how to display errors in Fluid templates.
