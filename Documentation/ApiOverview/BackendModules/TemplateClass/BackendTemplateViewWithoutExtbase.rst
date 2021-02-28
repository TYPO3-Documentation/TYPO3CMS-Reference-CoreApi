.. include:: /Includes.rst.txt

.. _backend-modules-template-without-extbase:

=========================================
The Backend Template View without Extbase
=========================================

.. tip::

   If you want to do extensive data modeling you may want to
   use :ref:`Extbase templating <backend-modules-template>`.
   If you build a simple backend module it makes sense to work without Extbase.

Basic controller
----------------

When creating a controller without Extbase an instance of :php:`ModuleTemplate` is required
to return the rendered template:

.. code-block:: php

   class ListController
   {
       protected ModuleTemplate $moduleTemplate;

       /**
        * Constructor Method
        *
        * @var ModuleTemplate $moduleTemplate
        */
       public function __construct(ModuleTemplate $moduleTemplate = null)
       {
           $this->moduleTemplate = $moduleTemplate ?? GeneralUtility::makeInstance(ModuleTemplate::class);
       }

      // ...
   }

Main entry point
----------------

:php:`handleRequest()` method is the main entry point which triggers only the allowed actions.
This makes it possible to include e.g. Javascript for all actions in the controller.

.. code-block:: php

   public function handleRequest(ServerRequestInterface $request): ResponseInterface
   {
      $action = (string)($request->getQueryParams()['action'] ?? $request->getParsedBody()['action'] ?? 'index');

      /**
       * Define allowed actions
       */
      if (!in_array($action, ['index'], true)) {
         return new HtmlResponse('Action not allowed', 400);
      }

      /**
       * Configure template paths for your backend module
       */
      $this->view = GeneralUtility::makeInstance(StandaloneView::class);
      $this->view->setTemplateRootPaths(['EXT:extension_key/Resources/Private/Templates/List']);
      $this->view->setPartialRootPaths(['EXT:extension_key/Resources/Private/Partials/']);
      $this->view->setLayoutRootPaths(['EXT:extension_key/Resources/Private/Layouts/']);
      $this->view->setTemplate($action);

      /**
       * Call the passed in action
       */
      $result = $this->{$action . 'Action'}($request);

      if ($result instanceof ResponseInterface) {
         return $result;
      }

      /**
       * Render template and return html content
       */
      $this->moduleTemplate->setContent($this->view->render());
      return new HtmlResponse($this->moduleTemplate->renderContent());
   }

Actions
-------

Now create an :php:`indexAction()` and assign variables to your view as you would normally do

.. code-block:: php

   public function indexAction()
   {
     $this->setDocHeader('index');

     $this->view->assignMultiple(
         [
             'some-variable' => 'some-value',
         ]
     );
   }

The DocHeader
-------------

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
---------------------------

Default layout

.. code-block:: html

   <html
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:be="http://typo3.org/ns/TYPO3/CMS/Backend/ViewHelpers"
      xmlns:core="http://typo3.org/ns/TYPO3/CMS/Core/ViewHelpers"
      data-namespace-typo3-fluid="true">

      <f:render section="content" />
   </html>

Index template

.. code-block:: html

   <f:layout name="Default" />

   <f:section name="content">
       ...
   </f:section>
