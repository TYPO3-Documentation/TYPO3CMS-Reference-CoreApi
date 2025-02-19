.. include:: /Includes.rst.txt
.. index:: LinkBrowser
.. _linkbrowser-api:
.. _LinkBrowser:

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

In most use cases, you can use one of the link handlers provided by the Core.
For an example, see :ref:`Tutorial: Custom record link
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

The options `displayBefore` and `displayAfter` define the order how the various tabs are displayed in the LinkBrowser.

The options `scanBefore` and `scanAfter` define the order in which handlers are queried when determining the responsible
tab for an existing link.
Most likely your links will start with a specific prefix to identify them.
Therefore you should register your tab at least before the 'url' handler, so your handler can advertise itself as responsible for the given link.
The 'url' handler should be treated as last resort as it will work with any link.
