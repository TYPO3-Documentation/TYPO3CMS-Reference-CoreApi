:navigation-title: Validation

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Validation
..  _extbase-validation-overview:

=====================
Validation in Extbase
=====================

Extbase validates incoming request arguments automatically before your action
method is called. If validation fails, the framework calls
:php:`errorAction()` instead of the intended action, so malformed input never
reaches your domain logic.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-validation-lifecycle:

Where validation fits into the Extbase request lifecycle
========================================================

The sequence for every request that carries arguments is:

1.  **Property mapping** — raw strings from the request are converted to typed
    PHP objects (see :ref:`extbase-property-mapping`).
2.  **Validation** — the mapped values are checked against any
    :php:`#[Validate]` attributes declared on the action parameter or on
    the domain model property.
3.  **Action dispatch** — if validation passes, the action method is called
    with the resolved arguments.
4.  **Error handling** — if validation fails, :php:`errorAction()` is called
    instead. The default implementation redirects the user to the referring
    request (typically the action that rendered the form), carrying the
    validation errors so they can be displayed.

This means you declare *what* valid data looks like; Extbase decides *when*
to run the checks and *where* to route the request on failure.

..  note::

    Validation is not limited to form submissions. It runs on *every* action
    that receives typed arguments including detail, filter, and search
    actions that read their input from URL parameters. A record created in the
    TYPO3 backend may satisfy TCA validation but still fail Extbase model
    validation when the same record is loaded as an action argument in the
    frontend. See :ref:`extbase-appendix-pitfalls-validation-tca-gap` for a
    full explanation.


..  _extbase-validation-where-to-declare:

Where to declare validators
===========================

Validators can be declared on action parameters, on domain model properties,
or both.

**On an action parameter** — validates the value passed to an
action before the action runs:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Attribute\Validate;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function createAction(
            #[Validate('NotEmpty')]
            #[Validate('StringLength', options: ['maximum' => 255])]
            string $title,
        ): ResponseInterface {
            // $title is guaranteed non-empty and at most 255 characters
        }
    }

**On a domain model property** — validates the property every time the model
is used as an action argument:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\Validate;
    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {
        #[Validate('NotEmpty')]
        #[Validate('StringLength', options: ['maximum' => 255])]
        protected string $title = '';
    }

Placing validators on the model above means that every action that receives a
:php:`Conference` argument benefits from the same rules,
without having to repeat the attribute on every parameter.


..  _extbase-validation-ignore:

Skipping validation with :php:`#[IgnoreValidation]`
===================================================

Sometimes you need to receive an object without running its validators, for
example when displaying a "new" form that is pre-populated from a submitted but
invalid object, or when an action intentionally accepts a partially filled
model.

Place :php:`#[IgnoreValidation]` on the parameter to suppress all validators
for that argument:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function newAction(
            #[IgnoreValidation]
            Conference $conference = null,
        ): ResponseInterface {
            $this->view->assign('conference', $conference ?? new Conference());
            return $this->htmlResponse();
        }
    }

Without :php:`#[IgnoreValidation]`, the framework would validate the
still-invalid :php:`Conference` object on arrival in :php:`newAction()`,
fail again, and the user would be stuck in an infinite cycle between
:php:`newAction()` and :php:`errorAction()`.


..  _extbase-validation-error-action:

Customising :php:`errorAction()`
================================

The built-in :php:`errorAction()` adds a generic flash message and redirects
the user to the referring request. For most contact or registration forms this
is sufficient.

To show a custom error flash message, override :php:`getErrorFlashMessage()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    protected function getErrorFlashMessage(): bool|string
    {
        return 'Please correct the errors in the form before saving.';
    }

Return :php:`false` to suppress the flash message.

To completely change how validation errors are handled — for example to return
a :abbr:`JSON (JavaScript Object Notation)` response — override
:php:`errorAction()` itself:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Error\Result;

    protected function errorAction(): ResponseInterface
    {
        $errors = $this->arguments->validate();
        return $this->jsonResponse(json_encode([
            'errors' => $this->flattenErrors($errors),
        ]))->withStatus(422);
    }


..  _extbase-validation-fluid:

Displaying validation errors in Fluid templates
===============================================

Extbase makes validation errors available in Fluid via the
``f:form.validationResults`` view helper. Wrap form fields with it to show
per-field error messages:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/New.fluid.html

    <f:form action="create" name="conference" object="{conference}">
        <f:form.validationResults for="conference.title">
            <f:for each="{validationResults.errors}" as="error">
                <p class="error">{error.message}</p>
            </f:for>
        </f:form.validationResults>
        <f:form.textfield property="title" />
        <f:form.submit value="Save" />
    </f:form>

The ``for`` attribute is the dot-notation path to the validated object or
property. Leave it empty to access all errors in the current request.


..  _extbase-validation-next:

What to read next
=================

*   :ref:`extbase-validation-builtin` — the full list of validators that ship
    with Extbase and their configuration options.
*   :ref:`extbase-validation-custom` — how to write a validator for domain
    rules that the built-in validators cannot express.
*   :ref:`extbase-property-mapping` — how request data is mapped to objects
    before validation runs.

..  toctree::
    :titlesonly:
    :hidden:

    BuiltIn
    Custom

