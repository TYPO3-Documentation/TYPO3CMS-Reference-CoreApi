.. include:: ../../../Includes.txt
.. highlight:: php

.. _linkbrowser-api:

===============
Linkbrowser API
===============

.. versionadded:: 7.6
    The LinkBrowser in the TYPO3 backend was made configurable and included hooks,
    see Change :doc:`t3core:Changelog/7.6/Feature-66369-AddedLinkBrowserAPIs`.
    This page has been updated to reflect the changes.


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

.. _linkbrowser-api-tab-registration:

Tab registration
----------------

LinkBrowser tabs are registered in page TSconfig like this:

.. code:: typoscript

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


.. _linkbrowser-api-handler-implementation:

Handler implementation
----------------------

A LinkHandler has to implement the :php:`\TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface` interface,
which defines all necessary methods for communication with the LinkBrowser.
The function actually doing the output of the link is function :php:`formatCurrentUrl()`::

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
It can utilize a Fluid template::

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

Hooks
-----

You may have the need to modify the list of available LinkHandlers based on some dynamic value.
For this purpose you can register hooks.

The registration of a LinkBrowser hook generally happens in your :file:`ext_tables.php` and looks like::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks'][1444048118] = [
       'handler' => \Vendor\Ext\MyClass::class,
       'before' => [], // optional
       'after' => [] // optional
   ];

The `before` and `after` elements allow to control the execution order of all registered hooks.

Currently the following list of hooks is implemented:

modifyLinkHandlers(linkHandlers, currentLinkParts)
   May modify the list of available LinkHandlers and has to return the final list.

modifyAllowedItems(allowedTabs, currentLinkParts)
   May modify the list of available tabs and has to return the final list.
