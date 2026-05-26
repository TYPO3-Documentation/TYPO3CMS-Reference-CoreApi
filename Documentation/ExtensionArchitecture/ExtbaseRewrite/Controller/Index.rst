:navigation-title: Controller

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Controller
..  _extbase-controller-overview:

===========================
Controller layer in Extbase
===========================

The controller layer sits between the request and the view. It handles the
request, coordinates repository and service calls, assigns variables for the
view, and returns a response. Business logic can live in the controller
directly — for anything complex or reused, a dedicated service class keeps the
controller focused. Direct database queries belong in repositories, not in
controllers.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-controller-overview-responses:

Responses are not tied to Fluid
===============================

Fluid is the recommended way to render output but this is not a
hard requirement. Every action must return a
:php:`\Psr\Http\Message\ResponseInterface` — what goes into that response is
entirely up to the action.

Calling :php:`$this->htmlResponse()` without arguments renders the Fluid
template and wraps it in a response. Passing a string to
:php:`$this->htmlResponse()` skips Fluid and uses that string as the body
directly:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    // Render the Fluid template for the current action
    return $this->htmlResponse();

    // Return a hand-built HTML string without Fluid
    return $this->htmlResponse('<p>Hello world</p>');

    // Return JSON
    return $this->jsonResponse(json_encode(['count' => 42]));

    // Redirect to another action (returns a redirect response, not a body)
    return $this->redirect('list');

All of these satisfy the :abbr:`PSR-7 (PHP Standards Recommendation 7 — HTTP
message interfaces)` :php:`\Psr\Http\Message\ResponseInterface` contract.
Returning anything other than a :php:`\Psr\Http\Message\ResponseInterface`
from an action throws a :php:`\RuntimeException` at dispatch time.


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
:php:`inject` with the dependency name will receive the dependency instead.

A typical case is a child controller that extends a base controller from your
own extension or a third-party package. The base controller already owns the
constructor, so the child uses inject methods for its own dependencies:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use MyVendor\MyExtension\Service\ConferenceService;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}
    }

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/SpecialConferenceController.php

    use MyVendor\MyExtension\Controller\ConferenceController;
    use MyVendor\MyExtension\Service\ConferenceService;

    class SpecialConferenceController extends ConferenceController
    {
        protected ConferenceService $conferenceService;

        public function injectConferenceService(
            ConferenceService $conferenceService,
        ): void {
            $this->conferenceService = $conferenceService;
        }
    }

Inject methods are a fully supported DI pattern, not a fallback. Constructor
injection is the recommended best practice — dependencies are declared in one
place and immediately visible to anyone reading the class. Inject methods are
the cleaner solution when a constructor is already owned by a parent class and
cannot be extended without repeating its full parameter list.

Both mechanisms can be combined in the same class. Injected properties should
be :php:`protected`, not :php:`private`, so subclasses can access them.


..  _extbase-controller-overview-pages:

In this chapter
===============

:ref:`extbase-controller-action`
    Actions, action arguments and automatic object resolution, response
    helpers, redirect and forward, flash messages, per-action initializers,
    :php:`#[Authorize]`, :php:`#[RateLimit]`, and :php:`errorAction`.

:ref:`extbase-controller-propertymapping`
    How raw request data is converted to typed PHP objects; the
    ``__trustedProperties`` mechanism; when manual allowlisting in
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
