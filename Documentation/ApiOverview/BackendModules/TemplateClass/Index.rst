.. include:: /Includes.rst.txt


.. _backend-modules-template:

======================================
The Backend Template View with Extbase
======================================

.. warning::

   Templating in the backend has been redesigned since a couple of
   major releases ago. This chapter describes the current new way of doing
   things. It may yet change. Please refer to older versions of
   this manual if you need a reference to the old way of programming
   backend modules.

.. tip::

   If you don't want to do extensive data modelling templates can be written
   :ref:`without Extbase. <backend-modules-template-without-extbase>`


Modern backend modules can be written using the Extbase/Fluid combination.
The "backend" system extension provides a general view class 
:php:`TYPO3\CMS\Backend\View\BackendTemplateView`
which provides common features for all backend modules, like the management
of the action menu or the registration of docheader buttons.

This view class gives access to the :php:`\TYPO3\CMS\Backend\Template\ModuleTemplate`
class which is - more or less - the old backend module template,
cleaned up and refreshed. This class performs a number of basic
operations for backend modules, like loading base JS libraries,
loading stylesheets, managing a flash message queue and - in general -
performing all kind of necessary setups.

To access these resources, the trick is to force your backend
module controller to use the :php:`TYPO3\CMS\Backend\View\BackendTemplateView`
class by changing the value of the :php:`$defaultViewObjectName` member
variable in the controller. Here is an example taken from system extension "beuser":

.. code-block:: php

	/**
	 * Backend module user/group action controller
	 */
	class BackendUserActionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
	{
		/**
		 * Backend Template Container
		 *
		 * @var string
		 */
		protected $defaultViewObjectName = \TYPO3\CMS\Backend\View\BackendTemplateView::class;

		// ...
	}

After that, you can use the :php:`initializeView()` method to
build the general elements of your backend module. Again looking
at the "beuser" extension:

.. code-block:: php


    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        if ($this->actionMethodName == 'indexAction'
            || $this->actionMethodName == 'onlineAction'
            || $this->actionMethodName == 'compareAction') {
            $this->generateMenu();
            $this->registerDocheaderButtons();
            $view->getModuleTemplate()->setFlashMessageQueue($this->controllerContext->getFlashMessageQueue());
        }
        if ($view instanceof BackendTemplateView) {
            $view->getModuleTemplate()->getPageRenderer()->loadRequireJsModule('TYPO3/CMS/Backend/Modal');
        }
    }

The main actions performed here are the generation of the action menu,
the generation of buttons for the Docheader, the initialization
of the Flash message queue and the registration of a JS library
to be loaded using RequireJS.

Using this :php:`BackendTemplateView` class, the Fluid templates for
your module need only take care of the actual content of your module.
As such, the Layout may be as simple as (again from "beuser"):

.. code-block:: html

	<f:render section="headline" />
	<f:render section="content" />

and the actual Template needs to render the title and the content only.
For example, here is an extract of the "Index" action template of
the "beuser" extension:

.. code-block:: html

	{namespace be = TYPO3\CMS\Backend\ViewHelpers}
	{namespace bu = TYPO3\CMS\Beuser\ViewHelpers}
	{namespace core = TYPO3\CMS\Core\ViewHelpers}

	<f:layout name="Default" />

	<f:section name="headline">
		<h1><f:translate key="backendUserListing" /></h1>
	</f:section>

	<f:section name="content">
		...
	</f:section>

The best resources for learning is to look at existing modules
from TYPO3 CMS. With the information given here, you should be
able to find your way around the code.
