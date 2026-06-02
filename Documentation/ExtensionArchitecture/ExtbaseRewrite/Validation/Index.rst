:navigation-title: Validation

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Validation
..  _extbase-validation-overview:

=====================
Validation in Extbase
=====================

Extbase validates incoming request arguments automatically before your action
method is called. If validation fails, the framework calls
:php:`errorAction()` instead of the intended action. Use
:php:`#[IgnoreValidation]` on a parameter to let an action receive an object
even if it is invalid — for example to redisplay a form with its errors.

Validators can be Extbase built-ins, custom classes, or — since TYPO3 v14 —
`Symfony constraints <https://docs.typo3.org/permalink/changelog:feature-106945-1750757664>`_.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-validation-lifecycle:

Where validation fits into the Extbase request lifecycle
========================================================

The sequence for every request that carries arguments is:

1.  **Property mapping** — everything arriving from the request is a string or
    an array of strings. Property mapping converts these into typed PHP values
    and objects (see :ref:`extbase-property-mapping`).
2.  **Validation** — the mapped values are checked against any
    :php:`#[Validate]` attributes declared on the action parameter, on the
    domain model property, or both. Property validators run first; action
    parameter validators run afterwards. Either alone is sufficient — both
    can be combined on the same type.
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

..  tip::

    Validators do not have to live on the persisted domain model. A base model
    can carry no validators at all, while separate
    :abbr:`DTO (Data Transfer Object)` classes carry different validator sets
    for different use cases — for example a ``ConferenceRegistrationForm`` DTO
    with strict seat-count validation and a ``ConferenceDraftForm`` DTO with
    only a title requirement. Each DTO is mapped by property mapping just like
    a domain model and can have its own independent validation rules.

When a form submission fails validation, Extbase re-calls the originating
action (typically ``newAction()`` or ``editAction()``). If that action has the
model as a typed parameter and declares :php:`#[IgnoreValidation]` on it,
the :ref:`t3viewhelper:typo3-fluid-form` view helper can read the submitted
values from the object and :ref:`t3viewhelper:typo3-fluid-form-validationresults`
can display the errors inline — the object does not need to be valid for
this to work.


..  _extbase-validation-ignore:

Ignoring the validation result with :php:`#[IgnoreValidation]`
==============================================================

Sometimes you need to receive an object without running its validators, for
example when displaying a "new" form that is pre-populated from a submitted but
invalid object, or when an action intentionally accepts a partially filled
model.

Place :php:`#[IgnoreValidation]` on the parameter to tell Extbase to ignore
the validation result for that argument and dispatch the action regardless:

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

Validation still runs — :php:`#[IgnoreValidation]` does not skip it. It
instructs Extbase to call the action even when the argument is invalid.
This is what allows :php:`newAction()` to receive a partially filled
:php:`Conference` back from a failed :php:`createAction()` and hand it to
the template so ``f:form`` can redisplay the submitted values with inline
errors.

Without :php:`#[IgnoreValidation]`, the framework would see the invalid
:php:`Conference`, call :php:`errorAction()`, which redirects back to
:php:`newAction()`, which would validate again — an infinite cycle.


..  _extbase-validation-error-action:

Customising :php:`errorAction()`
================================

The built-in :php:`errorAction()` adds a generic :ref:`flash message
<flash-messages>` and redirects the user to the referring request. For most contact or registration forms this
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
        ]))->withStatus(422); // choose the status code appropriate for your API; 422 or 400 are common choices
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

..  versionadded:: 14.0

    Symfony validators can be used in Extbase directly — see
    `Feature #106945 <https://docs.typo3.org/permalink/changelog:feature-106945-1750757664>`_
    for details.

..  toctree::
    :titlesonly:
    :hidden:

    BuiltIn
    Custom
