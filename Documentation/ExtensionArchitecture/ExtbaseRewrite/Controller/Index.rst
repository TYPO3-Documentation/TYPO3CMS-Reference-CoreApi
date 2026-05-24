:navigation-title: Controller

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Controller
..  _extbase-controller-overview:

===========================
Controller layer in Extbase
===========================

The controller layer sits between the request and the view. It receives a
dispatched request, resolves action arguments, runs business logic, assigns
variables to the view, and returns a response. In straightforward extensions
this is the natural home for business logic. When logic grows complex or needs
to be reused across controllers, extracting it into a dedicated service class
keeps controllers focused. However, this is a design choice and not a requirement.
Database queries belong in repositories and not in controllers.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-controller-overview-responses:

Responses are not tied to Fluid
===============================

Fluid is the recommended way to render output but this is not a
hard requirement. Every action must return a
:php:`\Psr\Http\Message\ResponseInterface` but what goes into that response is
entirely up to the action. Calling :php:`$this->htmlResponse()` without
any arguments renders the Fluid template and wraps it in a response. Passing a
string skips Fluid entirely. Actions can return JSON, plain text, a
redirect, or any other valid
:abbr:`PSR-7 (PHP Standards Recommendation 7 — HTTP message interfaces)`
response without involving Fluid at all.


..  _extbase-controller-overview-di:

Injecting dependencies into Extbase controllers
===============================================

Dependencies are added to controllers via
:ref:`dependency injection <Dependency-Injection>`. Two mechanisms are
available:

**Constructor injection** is the standard approach. Declare dependencies as
:php:`protected readonly` constructor parameters and the
:abbr:`DI (Dependency Injection)` container will provide them automatically:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}
    }

**Inject methods** should be used when a controller extends a parent
class that already has a constructor. As PHP only allows one
constructor per class, additional dependencies cannot be added without
repeating the parent's parameter list. A public method named
:php:`inject` with the dependency name will receive the dependency instead:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use MyVendor\MyExtension\Service\ConferenceService;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        protected ConferenceRepository $conferenceRepository;
        protected ConferenceService $conferenceService;

        public function injectConferenceRepository(
            ConferenceRepository $conferenceRepository,
        ): void {
            $this->conferenceRepository = $conferenceRepository;
        }

        public function injectConferenceService(
            ConferenceService $conferenceService,
        ): void {
            $this->conferenceService = $conferenceService;
        }
    }

Both mechanisms can be combined in the same class. Injected properties must
be :php:`protected` (not :php:`private`) so that subclasses can access them.


..  _extbase-controller-overview-pages:

In this chapter
===============

:ref:`extbase-controller-action`
    Actions, action arguments and automatic object resolution, response
    helpers, redirect and forward, flash messages, per-action initializers,
    :php:`#[Authorize]`, :php:`#[RateLimit]`, and :php:`errorAction`.

:ref:`extbase-controller-propertymapping`
    How raw request data is converted to typed PHP objects; the
    :php:`__trustedProperties` mechanism; when manual allowlisting in
    :php:`initialize*Action()` is necessary.

..  seealso::

    *   `Extbase validation <https://docs.typo3.org/permalink/extbase-validation>`_
        for validation rules on action arguments and model properties; how
        validation failure feeds into :php:`errorAction`.

    *   `Extbase view layer <https://docs.typo3.org/permalink/extbase-view-overview>`_
        for Fluid integration, template resolution, and response types.

..  toctree::
    :titlesonly:
    :hidden:

    ActionController
    PropertyMapping
