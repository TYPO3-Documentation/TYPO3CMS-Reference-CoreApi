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

Each tab rendered in the link browser has an associated link handler,
responsible for rendering the tab and for creating and editing of
links belonging to this tab.

Here is an example for a custom link handler in the link browser:

..  include:: /Images/ManualScreenshots/Backend/CustomLinkBrowser.rst.txt

In most use cases you can use one of the link handlers provided by the Core.
For an example see :ref:`Tutorial: Custom record link
browser <TableRecordLinkBrowserTutorials>`.

If no link handler is available to deal with your link type, you can create
a custom link handler. See :ref:`Tutorial: Create a custom link
browser <tutorial-github-link-handler>`.

.. index:: LinkBrowser; Tab registration
.. _linkbrowser-api-tab-registration:

Tab registration
----------------

LinkBrowser tabs are registered in page TSconfig like this:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.<tabIdentifier> {
       handler = TYPO3\CMS\Backend\LinkHandler\FileLinkHandler
       label = LLL:EXT:backend/Resources/Private/Language/locallang_browse_links.xlf:file
       displayAfter = page
       scanAfter = page
       configuration {
           customConfig = passed to the handler
       }
   }

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    LinkHandlers has changed from
    :php:`TYPO3\CMS\Recordlist\LinkHandler`
    to
    :php:`TYPO3\CMS\Backend\LinkHandler`.
    For TYPO3 v12 the moved classes are available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

The options `displayBefore` and `displayAfter` define the order how the various tabs are displayed in the LinkBrowser.

The options `scanBefore` and `scanAfter` define the order in which handlers are queried when determining the responsible
tab for an existing link.
Most likely your links will start with a specific prefix to identify them.
Therefore you should register your tab at least before the 'url' handler, so your handler can advertise itself as responsible for the given link.
The 'url' handler should be treated as last resort as it will work with any link.

.. index:: pair: LinkBrowser; Events

.. _modifyLinkHandlers:

Events to modify the available LinkHandlers
--------------------------------------------

You may have to modify the list of available LinkHandlers based on
some dynamic value.

Starting with TYPO3 version 12.0 you can use the following PSR-14 events:

*  :ref:`ModifyAllowedItemsEvent`
*  :ref:`ModifyLinkHandlersEvent`

Supporting both TYPO3 v12 and v11 to modify the available LinkHandlers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want to be compatible to both TYPO3 v12 and v11, you can keep your
implementation of the hooks
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']` as
described in :ref:`t3coreapi11:modifyLinkHandlers` and implement the
event listeners at the same time. Remove the hook implementation upon dropping
TYPO3 v11 support.
