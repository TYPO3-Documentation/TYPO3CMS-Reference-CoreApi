.. include:: /Includes.rst.txt

.. _backend-modules-template-without-extbase:

================================
The Backend Template View (Core)
================================

This page covers the backend template view, using only Core functionality
without Extbase.

.. tip::

   If you want to do extensive data modeling you may want to
   use :ref:`Extbase templating <backend-modules-template>`.
   If you build a simple backend module it makes sense to work without Extbase.

Basic controller
================

When creating a controller without Extbase an instance of :php:`ModuleTemplate` is required
to return the rendered template:

.. code-block:: php

   use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
   use TYPO3\CMS\Core\Imaging\IconFactory;

   class AdminModuleController
   {
       public function __construct(
           protected readonly ModuleTemplateFactory $moduleTemplateFactory,
           protected readonly IconFactory $iconFactory,
           // ...
       ) {
       }
   }

The controller needs to be registered in the :file:`Configuration/Services.yaml`
with the tag `backend.controller` so that dependency injection works:

.. code-block:: yaml
   :caption: EXT:examples/Configuration/Services.yaml

   services:
      _defaults:
         autowire: true
         autoconfigure: true
         public: false

      T3docs\Examples\:
         resource: '../Classes/*'
         exclude: '../Classes/Domain/Model/*'

      T3docs\Examples\Controller\AdminModuleController:
         tags: ['backend.controller']


Main entry point
================

:php:`handleRequest()` method is the main entry point which triggers only the allowed actions.
This makes it possible to include e.g. Javascript for all actions in the controller.

.. code-block:: php
   :caption: T3docs\Examples\Controller\AdminModuleController

   public function handleRequest(ServerRequestInterface $request): ResponseInterface
   {
       $languageService = $this->getLanguageService();
       $languageService->includeLLFile('EXT:examples/Resources/Private/Language/AdminModule/locallang.xlf');

       $this->menuConfig($request);
       $moduleTemplate = $this->moduleTemplateFactory->create($request, 't3docs/examples');
       $this->setUpDocHeader($moduleTemplate);

       $title = $languageService->sL('LLL:EXT:examples/Resources/Private/Language/AdminModule/locallang_mod.xlf:mlang_tabs_tab');
       switch ($this->MOD_SETTINGS['function']) {
           case 'debug':
               $moduleTemplate->setTitle($title, $languageService->getLL('module.menu.debug'));
               return $this->debugAction($moduleTemplate);
           case 'password':
               $moduleTemplate->setTitle($title, $languageService->getLL('module.menu.password'));
               return $this->passwordAction($moduleTemplate);
           default:
               $moduleTemplate->setTitle($title, $languageService->getLL('module.menu.log'));
               return $this->logAction($moduleTemplate);
       }
   }

Actions
=======

Now create an example :php:`indexAction()` and assign variables to your view
as you would normally do.

.. code-block:: php
   :caption: T3docs\Examples\Controller\AdminModuleController

   public function debugAction(
       ModuleTemplate $view,
       string $cmd = 'cookies'
   ): ResponseInterface
   {
       $cmd = $_POST['tx_examples_admin_examples']['cmd'];
       switch ($cmd) {
           case 'cookies':
               $this->debugCookies();
               break;
       }

       $view->assignMultiple(
           [
               'cookies' => $_COOKIE,
               'lastcommand' => $cmd,
           ]
       );
       return $view->renderResponse('AdminModule/Debug');
   }

The DocHeader
=============

To add a DocHeader button use :php:`$this->moduleTeamplate->getDocHeaderComponent()->getButtonBar()`
and :php:`makeLinkButton()` to create the button. Finally use :php:`addButton()` to add it.

.. code-block:: php

   private function setDocHeader(string $active) {
      $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
      $list = $buttonBar->makeLinkButton()
         ->setHref('<uri-builder-path>')
         ->setTitle('A Title')
         ->setShowLabelText('Link')
         ->setIcon($this->moduleTemplate->getIconFactory()->getIcon('actions-extension-import', Icon::SIZE_SMALL));
      $buttonBar->addButton($list, ButtonBar::BUTTON_POSITION_LEFT, 1);
   }

Template example
================

.. code-block:: html
   :caption: EXT:examples/Resources/Private/Templates/AdminModule/Debug.html

   <html data-namespace-typo3-fluid="true" xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers">

   <f:layout name="Module" />

   <f:section name="Content">
      <h1><f:translate key="function_debug" extensionName="examples"/></h1>
      <p><f:translate key="function_debug_intro" extensionName="examples"/></p>
      <p><f:debug inline="1">{cookies}</f:debug></p>
   </f:section>
   </html>


.. note:: Some Fluid tags do not work in non-Extbase context such as
   :html:`<f:form>`.
