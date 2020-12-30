.. include:: /Includes.rst.txt
.. index:: LinkHandlers; CustomLinkHandlers
.. _customlinkhandler:

=================================
Implementing a custom LinkHandler
=================================

It is possible to implement a custom LinkHandler if links are to be created
and handled that cannot be handled by any of the Core LinkHandlers.

The example below is part of the TYPO3 Documentation Team extension `examples
<https://github.com/TYPO3-Documentation/TYPO3CMS-Code-Examples>`__.


Implementing the LinkHandler
============================

You can have a look at the existing LinkHandler in the system Extension
recordlist, found at :file:`typo3/sysext/recordlist/Classes/LinkHandler`.

However please not that all these extensions extend the :php:`AbstractLinkHandler`,
which is marked as :php:`@interenal` and subject to change without further notice.

You should therefore implement the :php:`interface LinkHandlerInterface` in your
own custom LinkHandlers::

   <?php
   namespace T3docs\Examples\LinkHandler;

   # use ...
   use TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface;

   class GitHubLinkHandler implements LinkHandlerInterface
   {
      protected $linkAttributes = ['target', 'title', 'class', 'params', 'rel'];
      protected $view;
      protected $configuration;

      /**
      * Initialize the handler
      *
      * @param AbstractLinkBrowserController $linkBrowser
      * @param string $identifier
      * @param array $configuration Page TSconfig
      */
      public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration)
      {
         $this->linkBrowser = $linkBrowser;
         $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
         $this->view = GeneralUtility::makeInstance(StandaloneView::class);
         $this->view->getRequest()->setControllerExtensionName('examples');
         $this->view->setTemplateRootPaths([GeneralUtility::getFileAbsFileName('EXT:examples/Resources/Private/Templates/LinkBrowser')]);
         $this->configuration = $configuration;
      }

      /**
      * Checks if this is the handler for the given link
      *
      * Also stores information locally about currently linked issue
      *
      * @param array $linkParts Link parts as returned from TypoLinkCodecService
      *
      * @return bool
      */
      public function canHandleLink(array $linkParts)
      {
         if (isset($linkParts['url']['github'])) {
            $this->linkParts = $linkParts;
            return true;
         }
         return false;
      }

      /**
      * Format the current link for HTML output
      *
      * @return string
      */
      public function formatCurrentUrl(): string
      {
         return $this->linkParts['url']['github'];
      }


      /**
      * Render the link handler
      *
      * @param ServerRequestInterface $request
      *
      * @return string
      */
      public function render(ServerRequestInterface $request): string
      {
         GeneralUtility::makeInstance(PageRenderer::class)
            ->loadRequireJsModule('TYPO3/CMS/Examples/GitHubLinkHandler');

         $this->view->assign('project', $this->configuration['project']);
         $this->view->assign('action', $this->configuration['action']);
         $this->view->assign('github', !empty($this->linkParts) ? $this->linkParts['url']['github'] : '');
         return $this->view->render('GitHub');
      }

      /**
      * @return string[] Array of body-tag attributes
      */
      public function getBodyTagAttributes(): array
      {
         return [];
      }

      /**
      * @return array
      */
      public function getLinkAttributes()
      {
         return $this->linkAttributes;
      }

      /**
      * @param string[] $fieldDefinitions Array of link attribute field definitions
      * @return string[]
      */
      public function modifyLinkAttributes(array $fieldDefinitions)
      {
         return $fieldDefinitions;
      }

      /**
      * We don't support updates since there is no difference to simply set the link again.
      *
      * @return bool
      */
      public function isUpdateSupported()
      {
         return FALSE;
      }
   }

The LinkHandler then has to be registered via page TSCONFIG:

.. code-block:: typoscript

   TCEMAIN.linkHandler {
      github {
         handler = T3docs\\Examples\\LinkHandler\\GitHubLinkHandler
         label = LLL:EXT:examples/Resources/Private/Language/locallang_browse_links.xlf:github
         displayAfter = url
         scanBefore = url
         configuration {
             project = TYPO3-Documentation/TYPO3CMS-Reference-CoreApi
             action = issues
         }
      }
   }


And the JavaScript, depending on :ref:`requirejs`, has to be added in a file
:file:`examples/Resources/Public/JavaScript/GitHubLinkHandler.js`:

.. code-block:: javascript

   /**
    * Module: TYPO3/CMS/Examples/GitHubLinkHandler
    * Github issue link interaction
    */
   define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
      'use strict';

      /**
       *
       * @type {{}}
       * @exports T3docs/Examples/GitHubLinkHandler
       */
      var GitHubLinkHandler = {};

      $(function() {
         $('#lgithubform').on('submit', function(event) {
            event.preventDefault();

            var value = $(this).find('[name="lgithub"]').val();
            if (value === 'github:') {
               return;
            }
            if (value.indexOf('github:') === 0) {
               value = value.substr(7);
            }
            LinkBrowser.finalizeFunction('github:' + value);
         });
      });

      return GitHubLinkHandler;
   });

This would create a link looking like this:

.. code-block:: html

   <a href="github:123">Example Link</a>

Which could for example be interpreted by a custom protocol handler on a
company computers operating system.
