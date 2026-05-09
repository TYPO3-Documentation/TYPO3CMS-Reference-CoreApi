:navigation-title: MVC and request flow

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; MVC pattern
..  _extbase-concepts-mvc:

=======================================
MVC pattern and request flow in Extbase
=======================================

Extbase structures extensions around the
`Model-View-Controller (MVC) <https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller>`__
pattern. MVC separates three concerns that have a tendency to become entangled
in less structured code:

*   **Model** — what your data looks like and how it is persisted
*   **View** — how the data is presented to the user
*   **Controller** — what happens when an HTTP request arrives and which data
    the response should contain

To make this concrete: a visitor clicks "Read more" on an event listing. The
browser sends an HTTP GET request to a URL like
:samp:`/events?tx_myextension_eventlist[action]=show&tx_myextension_eventlist[event]=42`.
The **controller** receives that request, asks the **model** layer (the
repository) for the :php:`Event` with UID 42, hands the object to the
**view**, and the view renders it as HTML. Each layer does one job and one
job only.

Keeping these three things separate means you can change how data is stored
without touching the templates, and change the output format without touching
the business logic. It also means that any TYPO3 developer who knows Extbase
can immediately orient themselves in an unfamiliar extension.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-concepts-mvc-layers:

The three Extbase layers
========================

**Model**
    Domain objects — PHP classes that represent the data your extension works
    with. An event, a product, a blog post. Models extend
    :php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity` and are stored in
    :file:`Classes/Domain/Model/`. Their properties map to database columns.
    Models know nothing about HTTP, templates, or how they are displayed.

    Repositories sit alongside models and are the only entry point to the
    database. A controller never queries the database directly — it asks a
    repository for objects.

**View**
    Fluid templates in :file:`Resources/Private/Templates/`. The view receives
    variables from the controller and renders them as HTML (or JSON, or any
    other format). The view knows nothing about where data came from or what
    triggered the request.

**Controller**
    The coordinator. It receives a request, asks repositories for the data it
    needs, hands that data to the view, and returns a response. Controllers live
    in :file:`Classes/Controller/` and extend
    :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.

The strict separation is intentional. When something goes wrong, you know
exactly which layer to look at.


..  _extbase-concepts-mvc-request-flow:

How a request flows through Extbase
=====================================

When TYPO3 renders a page containing an Extbase plugin, the following sequence
happens:

..  rst-class:: bignums

1.  **TYPO3 hands off to Extbase**

    The plugin content element is rendered by the TYPO3 content object renderer.
    Control passes to :php:`\TYPO3\CMS\Extbase\Core\Bootstrap`, which reads the
    plugin configuration to determine which extension and plugin is involved.

2.  **An Extbase request object is built**

    The PSR-7 server request is wrapped in an Extbase
    :php:`\TYPO3\CMS\Extbase\Mvc\Request` object. This object carries the
    controller name, action name, and any arguments extracted from the URL or
    POST data — for example, the UID of a record to display.

3.  **The dispatcher resolves the controller**

    :php:`\TYPO3\CMS\Extbase\Mvc\Dispatcher` looks up which controller class
    corresponds to the requested controller name and instantiates it via
    the DI container.

4.  **The controller action runs**

    The dispatcher calls :php:`processRequest()` on the controller. The
    controller resolves the action method name (for example :php:`listAction` or
    :php:`showAction`), maps incoming arguments to typed PHP parameters via
    property mapping, runs validation, and then calls the action method.

5.  **The action builds the response**

    Inside the action, the controller assigns variables to the view and returns
    a :php:`ResponseInterface`. For a standard HTML response this means calling
    :php:`$this->htmlResponse()`, which renders the matching Fluid template and
    wraps the output in a PSR-7 response.

6.  **TYPO3 renders the response into the page**

    The rendered HTML is returned to the content object renderer and inserted
    into the page at the position of the plugin content element.

..  note::

    If an action calls :php:`$this->redirect()` or returns a
    :php:`\TYPO3\CMS\Extbase\Http\ForwardResponse`, the dispatcher loops and
    processes the new target action before returning a final response. This is
    how multi-step flows (for example: form → validate → confirm) work within a
    single page request.


..  _extbase-concepts-mvc-actions:

Controller actions in Extbase
==============================

Each public method in a controller whose name ends in :php:`Action` is a
potential action. The action name in the URL is the method name without the
:php:`Action` suffix, lowercased: :php:`listAction()` is addressed as
:samp:`action=list`.

Actions can declare typed parameters. Extbase's property mapping resolves them
automatically from the request:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/EventController.php

    use MyVendor\MyExtension\Domain\Model\Event;
    use Psr\Http\Message\ResponseInterface;

    public function showAction(Event $event): ResponseInterface
    {
        $this->view->assign('event', $event);
        return $this->htmlResponse();
    }

When the URL contains :samp:`event=42`, Extbase loads the :php:`Event` object
with UID 42 from the repository and passes it directly to the action. You never
write a repository lookup for this — the framework handles it.

Primitive types work the same way: a parameter typed :php:`int` receives an
integer, :php:`string` a string. Validation runs before the action is called;
if it fails, :php:`errorAction()` handles the error rather than your action
running with invalid data.


..  _extbase-concepts-mvc-responses:

Extbase action responses
=========================

Actions must return a :php:`\Psr\Http\Message\ResponseInterface`. The two most
common helpers on :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` are:

*   :php:`$this->htmlResponse()` — renders the Fluid template matching the
    current action and returns a 200 HTML response
*   :php:`$this->jsonResponse()` — returns a 200 JSON response; use with
    :php:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` to control which properties
    are serialised

For redirects and forwards:

*   :php:`$this->redirect('list')` — sends a 303 redirect to another action
*   :php:`return new \TYPO3\CMS\Extbase\Http\ForwardResponse('list')` — passes
    control to another action within the same request, without a redirect

..  seealso::

    :ref:`extbase-controller-action` — the full controller reference,
    including argument handling, error actions, and backend controllers.

    :ref:`extbase-domain-model` — how models and repositories work.

    :ref:`extbase-view-overview` — Fluid templates and response types.
