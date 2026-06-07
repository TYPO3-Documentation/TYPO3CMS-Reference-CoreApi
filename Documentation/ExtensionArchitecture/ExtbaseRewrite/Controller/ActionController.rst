:navigation-title: ActionController

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; ActionController
..  _extbase-controller-action:

==================================================
ActionController: actions, arguments and responses
==================================================

A controller handles the request, coordinates repository and service calls,
and returns a response. Business logic can live in the controller directly —
for anything complex or reused, a dedicated service class keeps the controller
focused. In Extbase every controller extends
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-controller-action-structure:

Structure of an Extbase ActionController
========================================

Controllers live in :file:`Classes/Controller/`. Public methods with a name
ending in :php:`Action` are actions that can be mapped to plugin actions or
backend module actions.

..  literalinclude:: _snippets/_ConferenceController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

Key rules:

*   Extend :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.
*   Do not declare the class as :php:`final`. Third parties should be able to extend
    controllers to customise behaviour.
*   Inject repositories and services via the constructor using
    :ref:`dependency injection <Dependency-Injection>`. Injected dependencies
    must be :php:`protected readonly`, not :php:`private readonly`, so
    subclasses can access them. In a service class that does not extend anything
    and carries no mutable state, you can declare the whole class :php:`readonly`
    instead — but controllers extend :php:`ActionController` and cannot use
    :php:`readonly class`.
*   Every action method must return a
    :php:`\Psr\Http\Message\ResponseInterface`.
*   **Frontend plugins:** use :php:`$this->view->assign()` to pass variables
    to the Fluid template and return :php:`$this->htmlResponse()` to render it.
    Actions can also return JSON, a redirect, or any other
    :abbr:`PSR-7 (PHP Standards Recommendation 7 — HTTP message interfaces)`
    response.
*   **Backend modules:** inject
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplateFactory`, create a
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` instance per action,
    assign variables via :php:`$moduleTemplate->assignMultiple()`, and return
    :php:`$moduleTemplate->renderResponse('ActionName')`. Do not use
    :php:`$this->view` or :php:`$this->htmlResponse()` in a module controller.
    See :ref:`extbase-registration-backend-module`.


..  _extbase-controller-action-arguments:

Action arguments and automatic Extbase object resolution
========================================================

Typed action parameters are resolved automatically from the request before the
action is called. Scalars (:php:`int`, :php:`string`, :php:`bool`) are read
directly from the request arguments. A parameter typed as a domain object (a
class extending
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`) triggers a repository
lookup. Extbase converts the incoming :abbr:`UID (unique identifier, the primary key of a TYPO3 database record)` to a fully
:abbr:`hydrated (an object populated with values loaded from the database)` object.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    public function showAction(Conference $conference): ResponseInterface
    {
        $this->view->assign('conference', $conference);
        return $this->htmlResponse();
    }

If, for example, a URL includes :php:`?tx_myextension_pi1[conference]=5`, Extbase
loads :php:`Conference` with UID 5 from the repository and passes the object
directly to :php:`showAction()`. A manual repository call is not necessary.

The lookup ignores the storagePid restriction but always respects enableFields
— hidden records, records outside their starttime/endtime window, deleted
records, and records from other workspaces will not be resolved. If the record
cannot be found, Extbase calls :php:`errorAction()` instead of the action.

Optional parameters require a default value. A nullable type alone
(:php:`?Conference $conference`) is not sufficient — without :php:`= null`,
PHP requires the caller to pass explicitly :php:`null`, which Extbase will not
do for a missing argument. Always combine the nullable type with a default:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    public function listAction(int $page = 1): ResponseInterface { ... }

    public function showAction(?Conference $conference = null): ResponseInterface { ... }

If an argument is missing from the request and there is no default value, Extbase
calls :php:`errorAction()` instead. See
:ref:`extbase-controller-action-error`.

..  seealso::

    `Property mapping: request arguments to objects <https://docs.typo3.org/permalink/extbase-controller-propertymapping>`_
    for how type conversion turns raw strings and arrays into PHP objects.


..  _extbase-controller-action-settings:

Accessing TypoScript settings in an Extbase controller
======================================================

The merged TypoScript settings for the current plugin are available in every
action via :php:`$this->settings`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    public function listAction(): ResponseInterface
    {
        $limit = (int)($this->settings['itemsPerPage'] ?? 10);
        $this->view->assign(
            'conferences',
            $this->conferenceRepository->findLatest($limit),
        );
        return $this->htmlResponse();
    }

:php:`$this->settings` contains the merged result of
:typoscript:`plugin.tx_myextension.settings.*`,
:typoscript:`plugin.tx_myextension_myplugin.settings.*`, and any FlexForm
overrides. It has nothing to do with
:ref:`site settings <sitehandling-settings>` — those are a separate
configuration layer defined in :file:`settings.yaml`. Site settings can feed
into TypoScript constants via the :typoscript:`{$...}` syntax, but that is an
explicit mapping, not an automatic merge. Only values that flow through
:typoscript:`plugin.tx_myextension.settings.*` end up in
:php:`$this->settings`. The full resolution order is covered in
`Extbase TypoScript configuration <https://docs.typo3.org/permalink/extbase-configuration-typoscript-scopes>`_.


..  _extbase-controller-action-responses:

Extbase action response helpers
===============================

:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` provides two
convenience methods for the most common response types:

:php:`htmlResponse(?string $html = null)`
    Returns a :html:`text/html`
    :abbr:`PSR-7 (PHP Standards Recommendation 7 — HTTP message interfaces)`
    response. Renders the current Fluid view without any arguments. Pass a string
    to use as the body.

:php:`jsonResponse(?string $json = null)`
    Returns an :html:`application/json` PSR-7 response. Renders the current view
    without any arguments (use with
    :php:`\TYPO3\CMS\Extbase\Mvc\View\JsonView`). Pass a JSON string for the response.

For any other status code or content types, build the response manually using
the injected :php:`$this->responseFactory` and :php:`$this->streamFactory`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    return $this->responseFactory
        ->createResponse(202)
        ->withHeader('Content-Type', 'text/plain; charset=utf-8')
        ->withBody($this->streamFactory->createStream('Accepted'));


..  _extbase-controller-action-redirect:

Redirecting and forwarding from an Extbase action
=================================================

After a write operation (create, update, delete), redirect the user to avoid
a double-submit on page reload. All three methods described here return a
:php:`\Psr\Http\Message\ResponseInterface` — you **must** :php:`return` them. They do not throw
an exception or stop execution on their own.

..  _extbase-controller-action-redirect-redirect:

redirect() — redirect to another Extbase action
-----------------------------------------------

:php:`redirect()` issues an
`HTTP 303 "See Other" <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/303>`_
response. The browser discards the POST body and issues a new GET request to
the target action URL.

Discarding the POST body is intentional. After a write action (create, update,
delete) you want the browser's address bar to show the result page URL, not
a form submission URL. If the user presses F5 or the back button, the browser
replays a GET — not the original POST — so that the write does not happen a second
time. This pattern is called
`Post/Redirect/Get <https://en.wikipedia.org/wiki/Post/Redirect/Get>`_.


..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Model\Conference;
    use Psr\Http\Message\ResponseInterface;

    public function updateAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->update($conference);

        // Redirect to listAction on the same page, same plugin
        return $this->redirect('list');
    }

The full signature is:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    // Go to showAction and pass a domain object as argument
    return $this->redirect('show', null, null, ['conference' => $conference]);

    // Go to listAction of ConferenceController on a different page
    return $this->redirect('list', 'Conference', null, [], $targetPageUid);

..  list-table:: :php:`redirect()` parameters
    :header-rows: 1
    :widths: 20 20 60

   * - Parameter
     - Default
     - Purpose
   * - :php:`$actionName`
     - (required)
     - Name of the target action without the ``Action`` suffix, for example ``'list'``.
   * - :php:`$controllerName`
     - :php:`null`
     - Short class name of the target controller. :php:`null` means the current controller.
   * - :php:`$extensionName`
     - :php:`null`
     - Extension name in UpperCamelCase. :php:`null` means the current extension.
   * - :php:`$arguments`
     - :php:`[]`
     - Array of arguments appended to the target URL as query parameters.
   * - :php:`$pageUid`
     - :php:`null`
     - UID of the target page. :php:`null` keeps the current page.
   * - :php:`$statusCode`
     - :php:`303`
     - HTTP status code. Change only when you have a specific reason.

..  note::

    If you need the browser to resend the original POST to a different Extbase
    action, for example, to hand off to another controller, pass
    `HTTP 307 Temporary Redirect <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/307>`_
    as the sixth argument. The redirect response itself has no body; it
    only tells the browser where to go. The browser then re-sends the original
    POST, including its body, to the new action URL:

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

        return $this->redirect('create', 'Conference', null, [], null, 307);

    This situation does not arise in typical Extbase form handling, where
    :php:`ForwardResponse` is the right tool for re-processing within the same
    request without a browser round-trip.


..  _extbase-controller-action-redirect-uri:

redirectToUri() — redirect to an arbitrary URL
----------------------------------------------

:php:`redirectToUri(string|\Psr\Http\Message\UriInterface $uri)` issues the
same HTTP 303 redirect but accepts a URL rather than an Extbase action
name. Use it when the target URL is assembled outside the action, for example
with :php-short:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use Psr\Http\Message\ResponseInterface;

    public function deleteAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->remove($conference);

        $uri = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(42)
            ->uriFor('list', [], 'Conference');

        return $this->redirectToUri($uri);
    }

:php:`$this->uriBuilder` is available in every action. Call
:php:`->reset()` before building a new URI so settings from a previous call
do not leak into the next one.


..  _extbase-controller-action-redirect-forward:

ForwardResponse — transfer control within the same request
----------------------------------------------------------

:php-short:`\TYPO3\CMS\Extbase\Http\ForwardResponse` transfers control to
another action *within the same request*. There is no browser redirect or new HTTP
round-trip. Use it to re-display a form after a validation failure without
losing any submitted data:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Model\Conference;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Http\ForwardResponse;

    public function createAction(Conference $conference): ResponseInterface
    {
        if ($someConditionFails) {
            return (new ForwardResponse('new'))
                ->withArguments(['conference' => $conference]);
        }
        $this->conferenceRepository->add($conference);
        return $this->redirect('list');
    }

Unlike a redirect, :php-short:`\TYPO3\CMS\Extbase\Http\ForwardResponse`
preserves the current request's arguments and flash messages so that the forwarded
action can re-render the form with submitted values still in place. The
browser URL does not change.

:php-short:`\TYPO3\CMS\Extbase\Http\ForwardResponse` accepts action name,
:php:`withControllerName()`, :php:`withExtensionName()`, and
:php:`withArguments()` — but no explicit page UID. The dispatching always
continues within the current request context. If you need to send the user to a
specific page, use :php:`redirect()` instead.


..  _extbase-controller-action-flashmessages:

Flash messages in Extbase controllers
=====================================

Flash messages are one-time notifications that survive a redirect or a forward
and are rendered in a Fluid template via :html:`<f:flashMessages />`. They
are also useful for in-page feedback when no redirect is involved. The message
is rendered in the same response.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

    $this->addFlashMessage(
        'Conference was saved.',
        'Success',
        ContextualFeedbackSeverity::OK,
    );
    return $this->redirect('list');

The five severity levels are:

*   :php:`ContextualFeedbackSeverity::NOTICE`
*   :php:`ContextualFeedbackSeverity::INFO`
*   :php:`ContextualFeedbackSeverity::OK`
*   :php:`ContextualFeedbackSeverity::WARNING`
*   :php:`ContextualFeedbackSeverity::ERROR`

By default, flash messages are stored inside the session and survive the redirect.
To keep a message only for the current request, for example, when forwarding
rather than redirecting, pass :php:`false` as the fourth argument:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    $this->addFlashMessage('Could not process your request.', '', ContextualFeedbackSeverity::ERROR, false);

Render them in Fluid with the :html:`<f:flashMessages />` ViewHelper.


..  _extbase-controller-action-initialize:

initializeAction and per-action initialization in Extbase
=========================================================

:php:`initializeAction()` is called before every controller action. Use it
for setup that is common to all actions.

For setup that applies to a single action only, define a method named
:php:`initialize` + the capitalized action name + :php:`Action` (for example
:php:`initializeCreateAction()` before :php:`createAction()`). Extbase calls
it automatically before the corresponding action:

..  literalinclude:: _snippets/_ConferenceControllerInitialize.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The per-action initializer is the standard place to configure property
mapping, for example, to allow specific properties or to set custom date
formats for arguments. See :ref:`_extbase-controller-propertymapping-typeconverters`.


..  _extbase-controller-action-authorize:

Protecting Extbase actions with :php:`#[Authorize]`
===================================================

..  versionadded:: 14.0

The :php:`#[Authorize]` attribute restricts access to individual action methods
without having to write boilerplate login checks. It is repeatable so multiple
attributes can be stacked to combine conditions.

..  literalinclude:: _snippets/_ConferenceControllerAuthorize.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The three options:

:php:`requireLogin: true`
    Denies access if no frontend user is logged in. Returns a `HTTP 403 Forbidden <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/403>`_ response
    via :php-short:`\TYPO3\CMS\Frontend\Controller\ErrorController`.

:php:`requireGroups: [42]` or :php:`requireGroups: ['editors']`
    Grants access only if the logged-in user belongs to at least one of the
    listed groups (by UID or title). Implies a login check.

:php:`callback: 'methodName'` or :php:`callback: [SomeClass::class, 'method']`
    Calls a method on the controller (string form) or on an arbitrary class
    (array form). The method receives the same arguments as the action and must
    return :php:`bool`. Use this for ownership or record-level checks.

    The callback method must be :php:`public`. Extbase verifies visibility via
    reflection and throws an exception if it is not.

    Inside a controller callback, read the current frontend user from the
    request attribute :php:`frontend.user`:

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

        public function isOwner(Conference $conference): bool
        {
            $currentUserId = $this->request->getAttribute('frontend.user')?->getUserId();
            return $currentUserId !== null
                && $conference->getOwnerUid() === $currentUserId;
        }

When access is denied, Extbase dispatches
:php-short:`\TYPO3\CMS\Extbase\Event\Mvc\BeforeActionAuthorizationDeniedEvent`
which lets event listeners return a custom response instead of the default 403.

..  seealso::

    `Extbase PHP attributes reference <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_
    for the full attribute reference including the event for custom denial responses.


..  _extbase-controller-action-ratelimit:

Rate-limiting Extbase actions with :php:`#[RateLimit]`
======================================================

..  versionadded:: 14.0

:php:`#[RateLimit]` limits how often a visitor (identified by IP address) may
call an action within a sliding time window. It is designed for write actions
like form submissions.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Attribute\RateLimit;

    #[RateLimit(limit: 3, interval: '1 hour')]
    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);
        return $this->redirect('list');
    }

Options:

:php:`limit`
    Maximum number of calls allowed within the interval. Default: :php:`5`.

:php:`interval`
    Time window as a string parseable by
    `\DateInterval <https://www.php.net/manual/en/class.dateinterval.php>`_ or
    `strtotime() <https://www.php.net/manual/en/function.strtotime.php>`_, for
    example :php:`'15 minutes'` or :php:`'1 hour'`.
    Default: :php:`'15 minutes'`.

:php:`policy`
    Throttling algorithm. Only :php:`'sliding_window'` is available.
    Default: :php:`'sliding_window'`.

:php:`message`
    :abbr:`LLL (Locallang label)` key for the message shown when the limit is
    exceeded. Resolved via :php:`LocalizationUtility` against the current
    extension. Leave empty to use the built-in Extbase default message.

When the limit is exceeded, Extbase returns an `HTTP 429 Too many requests <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/429>`_
response. Dispatch a
:php-short:`\TYPO3\CMS\Extbase\Event\Mvc\BeforeActionRateLimitResponseEvent`
listener to customize this response.


..  _extbase-controller-action-error:

errorAction: Extbase validation and argument-mapping errors
===========================================================

If argument mapping or validation fails, Extbase calls :php:`errorAction()`
instead of the original action. The default implementation either dispatches back
to the referring action (re-displaying the form with validation errors) or
returns a plain `HTTP 400 Bad Request <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/400>`_ text response.

Override :php:`getErrorFlashMessage()` to customize the flash message that
appears when validation fails:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    #[\Override]
    protected function getErrorFlashMessage(): bool|string
    {
        return match ($this->actionMethodName) {
            'createAction' => 'Please correct the errors in the form.',
            default => parent::getErrorFlashMessage(),
        };
    }

Return :php:`false` to suppress the flash message.

For full control over the error response, override :php:`errorAction()`.
Make sure you return a :php-short:`\Psr\Http\Message\ResponseInterface` — the contract
is the same as for normal actions.

..  seealso::

    *   `Extbase validation <https://docs.typo3.org/permalink/extbase-validation>`_
        for how validation rules are configured on model properties and action parameters via
        :php:`#[Validate]` attributes.

    *   `Property mapping: request arguments to objects <https://docs.typo3.org/permalink/extbase-controller-propertymapping>`_
        for how to allow properties on action arguments and configure type converters.
