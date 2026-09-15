.. include:: /Includes.rst.txt
.. index:: LinkHandlers; RecordLinkHandler
.. _recordlinkhandler:

=======================
The `RecordLinkHandler`
=======================

The :php:`RecordLinkHandler` enables editors to link to single records, for
example the detail page of a news record.

You can find examples here:

*   :ref:`Browse records of a table <TableRecordLinkBrowserTutorials>`
*   :ref:`Link browser example in tutorial in the news extension manual <georgringer/news:linkhandler>`

The handler is implemented in class :php:`\TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler`
of the system extension :file:`backend`. The class is marked as
:php:`@internal` and contains neither hooks nor events.

In order to use the :php:`RecordLinkHandler` it can be configured as following:

.. rst-class:: bignums-xxl

#. Page TSconfig is used to create a new tab in the LinkBrowser to
   be able to select records.

   ..  literalinclude:: _recordLinkHandler.tsconfig
       :caption: EXT:some_extension/Configuration/page.tsconfig (excerpt)

   You can position your own handlers in order as defined in the :ref:`linkbrowser-api`.

   The links are now stored in the database with the syntax
   `<a href="t3://record?identifier=anIdentifier&amp;uid=456">A link</a>`.

#. TypoScript configures how the link will be displayed in the frontend.

   ..  literalinclude:: _recordLinkFrontend.typoscript
       :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)

   .. attention::

      Do not change the identifier after links have been created using the
      RecordLinkHandler. The identifier will be stored as part of the link in the
      database.


.. index::
   pair: RecordLinkHandler; Page TSconfig
   TCEMAIN; RecordLinkHandler
.. _linkhandler-pagetsconfig_options:

`RecordLinkHandler` page TSconfig options
=========================================

The minimal page TSconfig configuration is:

..  literalinclude:: _recordLinkHandlerOptions.tsconfig
    :caption: EXT:some_extension/Configuration/page.tsconfig (excerpt)

The following optional configuration is available:

:typoscript:`configuration.hidePageTree = 1`
   Hide the page tree in the link browser

:typoscript:`configuration.storagePid = 84`
   The link browser starts with the given page

:typoscript:`configuration.pageTreeMountPoints = 123,456`
   Only records on these pages and their children will be displayed

Furthermore the following options are available from the LinkBrowser Api:

:typoscript:`configuration.scanAfter = page` or :typoscript:`configuration.scanBefore = page`
   Define the order in which handlers are queried when determining the responsible tab for an existing link

:typoscript:`configuration.displayBefore = page` or :typoscript:`configuration.displayAfter = page`
   Define the order of how the various tabs are displayed in the link browser.

.. index::
   pair: LinkHandler; TypoScript
   TypoScript; config.recordLinks
.. _linkhandler-typoscript_options:

LinkHandler TypoScript options
==============================

A configuration could look like this:

..  literalinclude:: _recordLinkOptions.typoscript
    :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)

The TypoScript Configuration of the LinkHandler is being used in sysext `frontend`
in class :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`.
