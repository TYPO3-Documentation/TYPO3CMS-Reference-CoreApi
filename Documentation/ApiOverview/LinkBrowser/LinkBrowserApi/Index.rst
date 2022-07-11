.. include:: /Includes.rst.txt
.. highlight:: php
.. index:: LinkBrowser
.. _linkbrowser-api:

===============
LinkBrowser API
===============

.. _linkbrowser-api-description:

Description
===========

This API allows to extend the LinkBrowser with new tabs,
which allow to implement custom link functionality in a generic way in a so called LinkHandler.
Since the LinkBrowser is used by FormEngine and RTE,
the new API ensures that your custom LinkHandler works with those two,
and possible future, usages flawlessly.

Each tab rendered in the LinkBrowser has an associated LinkHandler,
responsible for rendering the tab and for creating and editing of links belonging to this tab.


.. index:: LinkBrowser; Tab registration
.. _linkbrowser-api-tab-registration:

Tab registration
----------------

LinkBrowser tabs are registered in page TSconfig like this:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.<tabIdentifier> {
       handler = TYPO3\CMS\Recordlist\LinkHandler\FileLinkHandler
       label = LLL:EXT:recordlist/Resources/Private/Language/locallang_browse_links.xlf:file
       displayAfter = page
       scanAfter = page
       configuration {
           customConfig = passed to the handler
       }
   }

The options `displayBefore` and `displayAfter` define the order how the various tabs are displayed in the LinkBrowser.

The options `scanBefore` and `scanAfter` define the order in which handlers are queried when determining the responsible
tab for an existing link.
Most likely your links will start with a specific prefix to identify them.
Therefore you should register your tab at least before the 'url' handler, so your handler can advertise itself as responsible for the given link.
The 'url' handler should be treated as last resort as it will work with any link.


.. index:: LinkBrowser; LinkHandler implementation
.. _linkbrowser-api-handler-implementation:

Handler implementation
----------------------

.. todo: We also describe a custom Link Handler in Documentation/ApiOverview/LinkBrowser/Linkhandler/CustomLinkHandlers.rst
   unify them?

A LinkHandler has to implement the :php:`\TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface` interface,
which defines all necessary methods for communication with the LinkBrowser.
The function actually doing the output of the link is function :php:`formatCurrentUrl()`:


.. code-block:: php
   :caption: EXT:some_extension/Classes/LinkHandler/TelephoneLinkHandler.php

   class TelephoneLinkHandler implements LinkHandlerInterface
   {
       // …

       public function formatCurrentUrl(): string
       {
           return $this->linkParts['url']['telephone'];
       }

       // …
   }

The function :php:`render()` renders the backend display inside the tab of the LinkBrowser.
It can utilize a Fluid template:

.. code-block:: php
   :caption: EXT:some_extension/Classes/LinkHandler/TelephoneLinkHandler.php

   public function render(ServerRequestInterface $request): string
   {
       GeneralUtility::makeInstance(PageRenderer::class)->loadRequireJsModule('TYPO3/CMS/Recordlist/TelephoneLinkHandler');

       $this->view->assign('telephone', !empty($this->linkParts) ? $this->linkParts['url']['telephone'] : '');

       return $this->view->render('Telephone');
   }

Additionally, each LinkHandler should also provide a JavaScript module (requireJS),
which takes care of passing a link to the LinkBrowser.

A minimal implementation of such a module looks like this:

.. code-block:: javascript
   :caption: EXT:some_extension/Resources/Public/JavaScript/LinkBrowser.js

   define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
       var myModule = {};

       myModule.createMyLink = function() {
           var val = $('.myElmeent').val();

           // optional: If your link points to some external resource you should set this attribute
           LinkBrowser.setAdditionalLinkAttribute('data-htmlarea-external', '1');

           LinkBrowser.finalizeFunction('mylink:' + val);
       };

       myModule.initialize = function() {
           // todo add necessary event handlers, which will propably call myModule.createMyLink
       };

       $(myModule.initialize);

       return myModule;
   }

Notice the call to `LinkBrowser.finalizeFunction()`,
which is the point where the link is handed over to the LinkBrowser for further processing and storage.

As an example for a working LinkHandler implementations you can have a look at the LinkHandlers being defined in the
sysext.

.. index:: pair: LinkBrowser; Events

.. _modifyLinkHandlers:

Events to modify the available LinkHandlers
--------------------------------------------

You may have the need to modify the list of available LinkHandlers based on
some dynamic value.

Starting with TYPO3 version 12.0 you can use the following PSR-14 events:

*  :ref:`ModifyAllowedItemsEvent`
*  :ref:`ModifyLinkHandlersEvent`

Supporting both TYPO3 12 and 11 to modify the available LinkHandlers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want to be compatible to both TYPO3 12 and 11, you can keep your
implementation of the hooks
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']` as
described in :ref:`t3coreapi11:modifyLinkHandlers` and implement the
event listeners at the same time. Remove the hook implementation upon dropping
TYPO3 11 support.
