.. include:: /Includes.rst.txt

.. index:: Extbase; ActionController
.. _extbase-action-controller:

================
ActionController
================

Most Extbase controllers are based on the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. It is theoretically
possible to base a controller directly on the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface`, however there are
rarely use cases for that. Implementing the :php:`ControllerInterface` does not
guarantee a controller to be dispatchable. It is not recommended to base
your controller directly on the :php:`ControllerInterface`.

.. contents::
   :local:

.. _extbase_class_hierarchy-actions:

Actions
=======

Most public and protected methods that end in "Action" (for example
:php:`indexAction()` or :php:`showAction()`),
are automatically registered as actions of the controller.

.. versionchanged:: 11.0
   To comply with PSR standards, controller actions **should** return an
   instance of the :php:`Psr\Http\Message\ResponseInterface`. This becomes
   mandatory with TYPO3 v12.0.

Many of these actions have parameters. You should use strong types for the
parameters as this is necessary for the validation.

.. include:: /CodeSnippets/Extbase/Controllers/BlogControllerNew.rst.txt

The validation of domain object can be explicitly disabled by the annotation
:php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation`. This might be necessary
in actions that show forms or create domain objects.

Default values can, as usual in PHP, just be indicated in the method signature.
In the above case, the default value of the parameter :php:`$newBlog` is set to
:php:`NULL`.

If the action should render the view you can return :php:`$this->htmlResponse()`
as a shortcut for taking care of creating the response yourself.

In order to redirect to another action, return :php:`$this->redirect('another')`:

.. include:: /CodeSnippets/Extbase/Controllers/BlogControllerUpdate.rst.txt

If an exception is thrown while an action is executed you will receive the
"Oops an error occurred" screen on a production system or a stack trace on a
development system with activated debugging.

.. note::
   The methods
   :php:`initializeAction()`, :php:`initializeDoSomethingAction()` and
   :php:`errorAction()` have special meanings in initialization and error handling
   and are no Extbase actions.

.. _extbase_class_hierarchy-define_initialization_code:

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

.. include:: /CodeSnippets/Extbase/Controllers/BackendControllerInitialize.rst.txt

.. _extbase_class_hierarchy-catching_validation_errors_with_error_action:

Catching validation errors with errorAction
============================================

If an argument validation error has occurred, the method :php:`errorAction()`
is called.

The default implementation sets a flash message, error response with HTTP
status 400 and forwards back to the originating action.

This is suitable for most actions dealing with form input.

If you need a to handle errors differently this method can be overridden.

.. hint::
   If a domain object should not be validated, for example in the middle of an
   editing process, the validation of that object can be disabled by the
   annotation :php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation`.

..  _extbase-action-controller-forward:

Forward to a different controller
=================================

It is possible to forward from one controller action to an action of the same or a different
controller. This is even possible if the controller is in another extension.

This can be done by returning a :php:`\TYPO3\CMS\Extbase\Http\ForwardResponse`.

In the following example, if the current blog is not found in the
index action of the :php:`PostController`, we follow to the list of blogs
displayed by the :php:`indexAction` of the :php:`BlogController`.

.. include:: /CodeSnippets/Extbase/Controllers/ForwardAction.rst.txt

Forwards only work when the target controller and action is properly registered
as an allowed pair. This can be done via an extension's :file:`ext_localconf.php` file
in the relevant :php:`ExtensionUtility::configurePlugin()` section, or by
filling the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']`
array and :typoscript:`tt_content.list.20.(pluginSignature)` TypoScript.
Otherwise, the object class name of your target controller cannot be resolved properly,
and container instantiation will fail.

The corresponding example is:

.. include:: /CodeSnippets/Extbase/FrontendPlugins/ConfigurePlugin.rst.txt

Here, the plugin `BlogExample` would allow jumping between the controllers
:php:`PostController` and :php:`CommentController`. To also allow
:php:`BlogController` in the example above, it would need to get added
like this:

.. code-block:: php
   :caption: EXT:blog_example/ext_localconf.php

   <?php
   // ...
   use FriendsOfTYPO3\BlogExample\Controller\CommentController;
   use FriendsOfTYPO3\BlogExample\Controller\PostController;
   use FriendsOfTYPO3\BlogExample\Controller\CommentController;
   use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

   ExtensionUtility::configurePlugin(
      'BlogExample',
      'PostSingle',
      [
         PostController::class => 'show',
         CommentController::class => 'create',
         BlogController::class => 'index'
      ],
      [CommentController::class => 'create']
   );


Events
======

Two :ref:`PSR-14 events <EventDispatcher>` are available:

*   :ref:`AfterRequestDispatchedEvent`
*   :ref:`BeforeActionCallEvent`
