:navigation-title: ActionController

..  include:: /Includes.rst.txt
..  index:: Extbase; ActionController
..  _extbase-action-controller:

==============================
Extending the ActionController
==============================

Most Extbase controllers are based on the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. It is theoretically
possible to base a controller directly on the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface`, however there are
rarely use cases for that. Implementing the :php:`ControllerInterface` does not
guarantee a controller to be dispatchable. It is not recommended to base
your controller directly on the :php:`ControllerInterface`.

..  contents::
    :local:

..  _extbase_class_hierarchy-actions:

Actions
=======

Most public and protected methods that end in "Action" (for example
:php:`indexAction()` or :php:`showAction()`),
are automatically registered as actions of the controller.

Controller actions **must** return an instance of the
:php:`Psr\Http\Message\ResponseInterface`.

Many of these actions have parameters. You should use strong types for the
parameters as this is necessary for the validation.

..  include:: /CodeSnippets/Extbase/Controllers/BlogControllerNew.rst.txt

If the action should render the view you can return :php:`$this->htmlResponse()`
as a shortcut for taking care of creating the response yourself.

In order to redirect to another action, return :php:`$this->redirect('another')`:

..  include:: /CodeSnippets/Extbase/Controllers/BlogControllerUpdate.rst.txt

If an exception is thrown while an action is executed you will receive the
"Oops an error occurred" screen on a production system or a stack trace on a
development system with activated debugging.

..  note::
    The methods
    :php:`initializeAction()`, :php:`initializeDoSomethingAction()` and
    :php:`errorAction()` have special meanings in initialization and error handling
    and are no Extbase actions.

..  danger::
    An action where a new object is constructed (e.g. `newAction`) does usually
    not need the argument as action property.

    `public function newAction(?Blog $blog = null)` may be a security
    vulnerability, if no access checks are performed, since an attacker can
    provide any blog UID and view the data of the record in the form.

    It is also not required to use the `IgnoreValidation` attribute in order
    for validation to work properly. Extbase takes care of assigning data
    to the form in case of validation failures.

..  _extbase_class_hierarchy-define_initialization_code:

Define initialization code
===========================

Sometimes it is necessary to execute code before calling an action. For example,
if complex arguments must be registered, or required classes must be instantiated.

There is a generic initialization method called :php:`initializeAction()`, which
is called after the registration of arguments, but before calling the
appropriate action method itself. After the generic `initializeAction()`, if
it exists, a method named *initialize[ActionName]()*, for example
:php:`initializeShowAction` is called.

In this method you can perform action specific initializations.

In the backend controller of the blog example the method
:php:`initializeAction()` is used to discover the page that is currently
activated in the page tree and save it in a variable:

..  include:: /CodeSnippets/Extbase/Controllers/BackendControllerInitialize.rst.txt

..  _extbase_class_hierarchy-catching_validation_errors_with_error_action:

Catching validation errors with errorAction
============================================

If an argument validation error has occurred, the method :php:`errorAction()`
is called.

The default implementation sets a flash message, error response with HTTP
status 400 and forwards back to the originating action.

This is suitable for most actions dealing with form input.

If you need a to handle errors differently this method can be overridden.

..  hint::
    If a domain object should not be validated, for example in the middle of an
    editing process, the validation of that object can be disabled by the
    attribute :php:`TYPO3\CMS\Extbase\Annotation\IgnoreValidation`.

..  _extbase-action-controller-forward:

Forward to a different controller
=================================

It is possible to forward from one controller action to an action of the same or a different
controller. This is even possible if the controller is in another extension.

This can be done by returning a :php:`\TYPO3\CMS\Extbase\Http\ForwardResponse`.

In the following example, if the current blog is not found in the
index action of the :php:`PostController`, we follow to the list of blogs
displayed by the :php:`indexAction` of the :php:`BlogController`.

..  include:: /CodeSnippets/Extbase/Controllers/ForwardAction.rst.txt

Forwards only work when the target controller and action is properly registered
as an allowed pair. This can be done via an extension's :file:`ext_localconf.php` file
in the relevant :php:`ExtensionUtility::configurePlugin()` section, or by
filling the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']`
array and :typoscript:`tt_content.(pluginSignature)` TypoScript.
Otherwise, the object class name of your target controller cannot be resolved properly,
and container instantiation will fail.

The corresponding example is:

..  include:: /CodeSnippets/Extbase/FrontendPlugins/ConfigurePlugin.rst.txt

Here, the plugin `BlogExample` would allow jumping between the controllers
:php:`PostController` and :php:`CommentController`. To also allow
:php:`BlogController` in the example above, it would need to get added
like this:

..  literalinclude:: _Snippets/_ActionController/_ext_localconf.php
    :caption: EXT:blog_example/ext_localconf.php (Excerpt)

..  _extbase-action-controller-stop:

Stop further processing in a controller's action
================================================

Sometimes you may want to use an Extbase controller action to
return a specific output, and then stop the whole request flow.

For example, a :php:`downloadAction()` might provide some binary data,
and should then stop.

By default, Extbase actions need to return an object of type
:php:`\Psr\Http\Message\ResponseInterface` as described above. The actions
are chained into the TYPO3 request flow (via the page renderer), so the
returned object will be enriched by further processing of TYPO3. Most
importantly, the usual layout of your website will be surrounded
by your Extbase action's returned contents, and other plugin outputs may
come before and after that.

In a download action, this would be unwanted content. To prevent that
from happening, you have multiple options. While you might think placing
a :php:`die()` or :php:`exit()` after your download action processing
is a good way, it is not very clean.

The recommended way to deal with this, is to use a
:ref:`PSR-15 middleware <request-handling>` implementation. This is more performant,
because all other request workflows do not even need to be executed, because no other
plugin on the same page needs to be rendered. You would refactor your code so that
:php:`downloadAction()` is not executed (e.g. via :html:`<f:form.action>`), but instead
point to your middleware routing URI, let the middleware properly
create output, and finally stop its processing by a concrete
:php:`\Psr\Http\Message\ResponseFactoryInterface` result object,
as described in the Middleware chapters.

If there are still reasons for you to utilize Extbase for this, you can use
a special method to stop the request workflow. In such a case a
:php:`\TYPO3\CMS\Core\Http\PropagateResponseException` can be thrown. This is automatically
caught by a PSR-15 middleware and the given PSR-7 response is then returned directly.

Example:

..  literalinclude::  ../_FrontendPlugin/_PropagateResponseExceptionController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php
    :emphasize-lines: 21

Also, if your controller needs to perform a redirect to a defined URI (internal or external),
you can return a specific object through the :php:`responseFactory`:

..  literalinclude::  ../_FrontendPlugin/_ExternalRedirectController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php
    :emphasize-lines: 17-18

..  hint::
    If you want to return a JSON response, see :ref:`extbase_responses` to achieve this
    with a special :php:`$this->jsonResponse()` method.

..  _extbase-action-controller-events:

Events
======

Two :ref:`PSR-14 events <EventDispatcher>` are available:

*   :ref:`AfterRequestDispatchedEvent`
*   :ref:`BeforeActionCallEvent`
