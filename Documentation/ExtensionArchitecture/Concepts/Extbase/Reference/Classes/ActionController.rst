.. include:: /Includes.rst.txt

.. index:: Extbase; ActionController
.. _extbase-action-controller:

================
ActionController
================

Most Extbase controllers are based on the
:php:`TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. It is theoretically
possible to base a controller directly on the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface`, however there are
rarely use cases for that. Implementing the :php:`ControllerInterface` does not
guarantee a controller to be dispatchable.

.. index:: Extbase; ActionController API
.. _extbase_class_hierarchy-action_controller_api:
.. _extbase_class_hierarchy-most_important_api_methods_of_action_controller:

ActionController API
====================

.. _extbase_class_hierarchy-actions:

Actions
=======

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


.. _extbase_class_hierarchy-define_initialization_code:

Define initialization code
--------------------------

Sometimes it is necessary to execute code before calling an action. For example, if complex
arguments must be registered, or required classes must be instantiated.

There is a generic initialization method called `initializeAction()`, which is called after
the registration of arguments, but before calling the appropriate action method itself. After the
generic `initializeAction()`, if it exists, a method named *initialize[ActionName]()* is called.
Here you can perform action specific initializations (e.g. `initializeShowAction()`).

.. _extbase_class_hierarchy-catching_validation_errors_with_error_action:

Catching validation errors with errorAction
-------------------------------------------

If an argument validation error has occurred, the method `errorAction()` is called. There,
in `$this->argumentsMappingResults`, you have a list of occurred warnings and errors of the argument
mappings available. This default `errorAction` refers back to the referrer if the referrer
was sent with it.

