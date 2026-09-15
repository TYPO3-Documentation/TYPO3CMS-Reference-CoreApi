.. include:: /Includes.rst.txt
.. index:: LinkHandlers
.. _linkhandler:

===================
The LinkHandler API
===================

The LinkHandler API currently consists of 7 LinkHandler classes and the
:php:`TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface`. The
LinkHandlerInterface can be implemented to create custom LinkHandlers.

Most LinkHandlers cannot receive additional configuration, they are marked as
:php:`@internal` and contain neither hooks nor events. They are therefore
of interest to Core developers only.

Current LinkHandlers:

*  :ref:`pagelinkhandler`: for linking pages and content
*  :ref:`recordlinkhandler`: for linking any kind of record
*  UrlLinkHandler: for linking external urls
*  FileLinkHandler: for linking files in the :ref:`fal`
*  FolderLinkHandler: for linking to directories
*  MailLinkHandler: for linking email addresses
*  TelephoneLinkHandler: for linking phone numbers

.. note::

   In the system extension :file:`core` there are also classes ending on
   "LinkHandler". However those implement the interface :php:`LinkHandlingInterface`
   and are part of the LinkHandling API, not the LinkHandler API.

The links are now stored in the database with the syntax
`<a href="t3://record?identifier=anIdentifier&amp;uid=456">A link</a>`.

#. TypoScript is used to generate the actual link in the frontend.

   ..  literalinclude:: _recordLinkFrontend.typoscript
       :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)

   .. attention::

      Do not change the identifier after links have been created  using the LinkHandler. The identifier will be
      stored as part of the link in the database.


.. index::
   pair: LinkHandler; Page TSconfig
   TCEMAIN; linkHandler
.. _linkhandler-pagetsconfig:

LinkHandler page TSconfig options
=================================

The minimal page TSconfig configuration is:

..  literalinclude:: _recordLinkHandlerOptions.tsconfig
    :caption: EXT:some_extension/Configuration/page.tsconfig (excerpt)

See :ref:`link-handler-configuration` for all available options.

..  _linkhandler-pagetsconfig-example-news-records:

Example: news records from one storage pid
------------------------------------------

The following configuration hides the page tree and shows news records only
from the defined storage page:

..  literalinclude:: _newsLinkHandler.tsconfig
    :caption: EXT:some_extension/Configuration/page.tsconfig (excerpt)

It is possible to have another configuration using another storagePid which
also contains news records.

This configuration shows a reduced page tree starting at page with uid 42:

..  literalinclude:: _bookReportsLinkHandler.tsconfig
    :caption: EXT:some_extension/Configuration/page.tsconfig (excerpt)

The page TSconfig of the LinkHandler is being used in sysext `backend`
in class :php:`\TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler`
which does not contain Hooks.

.. attention::

    It is important, that the `storagePid` is hard coded in TSConfig, because using
    constants, for example from the site configuration, will not work here.

.. index::
   pair: LinkHandler; TypoScript
   TypoScript; config.recordLinks
.. _linkhandler-typoscript:

LinkHandler TypoScript options
==============================

A configuration could look like this:

..  literalinclude:: _recordLinkOptions.typoscript
    :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)

The TypoScript Configuration of the LinkHandler is being used in sysext `frontend`
in class :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`.

..  _linkhandler-typoscript-example-news-records:

Example: news records displayed on fixed detail page
----------------------------------------------------

The following displays the link to the news on a detail page:

..  literalinclude:: _newsRecordLink.typoscript
    :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)

Once more if the book reports that are also saved as `tx_news_domain_model_news` record should be displayed on their own
detail page you can do it like this:

..  literalinclude:: _bookReportsRecordLink.typoscript
    :caption: EXT:some_extension/Configuration/Sets/SomeExtension/setup.typoscript (excerpt)


..  toctree::
    :titlesonly:
    :hidden:

    PageLinkHandler
    RecordLinkHandler
    CustomLinkHandlers
    Events
