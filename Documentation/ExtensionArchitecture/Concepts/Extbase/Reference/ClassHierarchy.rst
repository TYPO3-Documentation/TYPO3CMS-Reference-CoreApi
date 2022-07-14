.. include:: /Includes.rst.txt

.. index:: Extbase; Class hierarchy
.. _class_hierarchy:

Class hierarchy
===============

The MVC Framework is the heart of Extbase. Below we will give you an overview of
the class hierarchy for the controllers and the API of the `ActionControllers`.

Normally you will let your controllers inherit from `ActionController`. If you
have special requirements that can not be realized with the `ActionController`,
you should have a look at the controllers below.

:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface`
   The basic interface that must be implemented by all controllers.

.. todo: This interface is useless because implementing it does not guarantee a controller
   is dispatchable. It's been wishful thinking from the beginning on. The interface will
   be removed.

:php:`TYPO3\CMS\Extbase\Mvc\Controller\ActionController`
    The most widely used controller in Extbase with the basic functionality of the ControllerInterface.
    An overview of its API is given in the following section.

:php:`TYPO3\CMS\Extbase\Mvc\Controller\CommandController`
    Extend this controller if you want to provide commands to the scheduler or command line
    interface.

.. todo: CommandControllers are already removed. Remove this section.

.. index:: Extbase; ActionController API
.. _class_hierarchy-action_controller_api:

ActionController API
--------------------

The action controller is usually the base class for your own controller. Below
you see the most important properties of the action controller:

`$argumentMappingResults`
    Results of the argument mapping. Those are especially used in the `errorAction`.

`$defaultViewObjectName`
    Name of the default view, if no Fluid view or an action-specific view was found.

`$errorMethodName`
    The name of the action that is performed when generating the arguments of actions
    fail. The default is errorAction. In general, it is not sensible to change this.

`$request`
    Request object of type :php:`\TYPO3\CMS\Extbase\Mvc\RequestInterface`.

`$settings`
    Domain-specific extension settings from TypoScript (as array), see :ref:`typoscript_configuration-settings`.

`$view`
    The view used of type :php:`\TYPO3\CMS\Extbase\Mvc\View\ViewInterface`.

.. todo: We need to keep an eye on these. They are more or less internal and
   will be removed at some point.

.. _class_hierarchy-most_important_api_methods_of_action_controller:

Most important API methods of action controller
-----------------------------------------------

.. deprecated:: 11.5
   The method :php:`initializeView` has been deprecated and will be removed along with the
   :php:`\TYPO3\CMS\Extbase\Mvc\View\ViewInterface` in v12.

`Action()`
    Defines an action.

`errorAction()`
    Standard error action. It needs to be adjusted only in sporadic cases. The property
    `$errorMethodName` defines the name of this method.

`initializeAction()`
    Initialization method for all actions. Can be used to e.g. register arguments.

`initialize[actionName]Action()`
    Action-specific initialization, which is called only before the specific action.
    It can be used to, e.g., register arguments.

`redirect($actionName, $controllerName = NULL, $extensionName = NULL, array $arguments = NULL, $pageUid = NULL, $delay = 0, $statusCode = 303)`
    External HTTP redirect to another controller (immediately)

.. todo: Will soon be deprecated

`redirectToURI($uri, $delay = 0, $statusCode = 303)`
    Redirect to full URI (immediately)

.. todo: Will soon be deprecated

`resolveView()`
    By overriding this method, you can build and configure a completely individual
    view object. This method should return a complete view object. In general,
    however, it is sufficient to overwrite resolveViewObjectName().

.. todo: This MUST NOT be overridden. Users can add a custom \TYPO3\CMS\Extbase\Mvc\View\ViewResolverInterface
   implementation if needed.

`resolveViewObjectName()`
    Resolves the name of the view object, if no suitable Fluid template could be
    found.

.. todo: This is already deleted.

`throwStatus($statusCode, $statusMessage = NULL, $content = NULL)`
    The specified HTTP status code is sent immediately.

.. todo: This will be deprecated soon

.. _class_hierarchy-actions:

Actions
-------

All public and protected methods that end in *action* (for example `indexAction` or `showAction`),
are automatically registered as actions of the controller.

Many of these actions have parameters. These appear as annotations in the Doc-Comment-Block
of the specified method, as shown in Example B-3:

*Example B-3: Actions with parameters*


.. code-block:: php
   :caption: EXT:blog_example/Classes/Controller/BlogController.php

   <?php
   declare(strict_types = 1);

   namespace Ex\BlogExample\Controller;

   use TYPO3\CMS\Extbase\Annotation as Extbase;
   use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
   use Ex\BlogExample\Domain\Model\Blog

   class BlogController extends ActionController
   {
       /**
        * Displays a form for creating a new blog, optionally pre-filled with partial information.
        *
        * @param Blog $newBlog A fresh blog object which should be taken
        *        as a basis for the form if it is set.
        *
        * @return ResponseInterface
        *
        * @Extbase\IgnoreValidation("newBlog")
        */
       public function newAction(Blog $newBlog = NULL) : ResponseInterface
       {
           $this->view->assign('newBlog', $newBlog);
           return $this->htmlResponse();
       }
   }

.. note::
   Not only simple data types such as String, Integer, or Float can be validated,
   but also complex object types (see also the section
   ":ref:`validating-domain-objects`" in Chapter 9).

The validation of domain object can be explicitly disabled by the annotation
:php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation`. This might be necessary
in actions that show forms or create domain objects.

Default values can, as usual in PHP, just be indicated in the method signature. In the above case,
the default value of the parameter `$newBlog` is set to NULL. If an action returns `NULL` or nothing,
then automatically `$this->view->render()` is called, and thus the view is rendered.

.. todo: We need to adjust this example to reflect the PSR-7 response changes.

.. _class_hierarchy-define_initialization_code:

Define initialization code
--------------------------

Sometimes it is necessary to execute code before calling an action. For example, if complex
arguments must be registered, or required classes must be instantiated.

There is a generic initialization method called `initializeAction()`, which is called after
the registration of arguments, but before calling the appropriate action method itself. After the
generic `initializeAction()`, if it exists, a method named *initialize[ActionName]()* is called.
Here you can perform action specific initializations (e.g. `initializeShowAction()`).

.. _class_hierarchy-catching_validation_errors_with_error_action:

Catching validation errors with errorAction
-------------------------------------------

If an argument validation error has occurred, the method `errorAction()` is called. There,
in `$this->argumentsMappingResults`, you have a list of occurred warnings and errors of the argument
mappings available. This default `errorAction` refers back to the referrer if the referrer
was sent with it.


.. index:: Extbase; Annotations
.. _available-annotations:

Available annotations
^^^^^^^^^^^^^^^^^^^^^

All available annotations for Extbase are placed within the namespace :php:`TYPO3\CMS\Extbase\Annotation`.
They can be imported into the current namespace, e.g.:

.. code-block:: php
   :caption: EXT:blog_example/Classes/Controller/BlogController.php


   use TYPO3\CMS\Extbase\Annotation\ORM\Transient;

   /**
    * @Transient
    * @var Foo
    */
   public $property;

It is completely valid and will be parsed. It is considered to be best practice to
use the following instead, in order to make the source of annotation more
transparent:

.. code-block:: php
   :caption: EXT:blog_example/Classes/Controller/BlogController.php

   use TYPO3\CMS\Extbase\Annotation as Extbase;

   /**
    * @Extbase\Transient
    * @var Foo
    */
   public $property;

The following annotations are available out of the box within Extbase:

:php:`@TYPO3\CMS\Extbase\Annotation\Validate`
   Allows to configure validators for properties and method arguments:


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * Existing TYPO3 validator.
       *
       * @Extbase\Validate("EmailAddress")
       */
      protected $email = '';

      /**
       * Existing TYPO3 validator with options.
       *
       * @Extbase\Validate("StringLength", options={"minimum": 1, "maximum": 80})
       */
      protected $title = '';

      /**
       * Custom validator identified by FQCN.
       *
       * @Extbase\Validate("\Vendor\ExtensionName\Validation\Validator\CustomValidator")
       */
      protected $bar;

      /**
       * Custom Validator identified by dot syntax, with additional parameters.
       *
       * @Extbase\Validate("Vendor.ExtensionName:CustomValidator", param="barParam")
       */
      public function barAction(string $barParam)
      {
          return '';
      }

   The above list provides all possible references to a validator. Available
   validators shipped with Extbase can be found within
   :file:`EXT:extbase/Classes/Validation/Validator/`.

:php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation()`
   Allows to ignore Extbase default validation for a given argument, in context
   of an controller.

   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php


      /**
       * @Extbase\IgnoreValidation("param")
       */
      public function method($param)
      {
      }

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")`
   Allows to remove child entities during deletion of aggregate root.


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Cascade("remove")
       */
      public $property;

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Transient`
   Marks property as transient (not persisted).


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Transient
       */
      public $property;

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy`
   Marks property to be lazily loaded on first access.


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Lazy
       */
      public $property;
