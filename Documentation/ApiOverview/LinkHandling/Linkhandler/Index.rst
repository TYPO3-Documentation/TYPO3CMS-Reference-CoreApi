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

   .. code-block:: typoscript

      config.recordLinks.anIdentifier {
          // Do not force link generation when the record is hidden
          forceLink = 0
          typolink {
              parameter = 123
              additionalParams.data = field:uid
              additionalParams.wrap = &tx_example_pi1[item]=|&tx_example_pi1[controller]=Item&tx_example_pi1[action]=show
          }
      }

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

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.anIdentifier {
       handler = TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler
       label = LLL:EXT:extension/Resources/Private/Language/locallang.xlf:link.customTab
       configuration {
           table = tx_example_domain_model_item
       }
   }

See :ref:`link-handler-configuration` for all available options.

Example: news records from one storage pid
------------------------------------------

The following configuration hides the page tree and shows news records only
from the defined storage page:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.news {
       handler = TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler
       label = News
       configuration {
           table = tx_news_domain_model_news
           storagePid = 123
           hidePageTree = 1
       }
       displayAfter = email
   }

It is possible to have another configuration using another storagePid which
also contains news records.

This configuration shows a reduced page tree starting at page with uid 42:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.bookreports {
       handler = TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler
       label = Book Reports
       configuration {
           table = tx_news_domain_model_news
           storagePid = 42
           pageTreeMountPoints = 42
           hidePageTree = 0
       }
   }

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

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

   config.recordLinks.anIdentifier {
       forceLink = 0

       typolink {
           parameter = 123
           additionalParams.data = field:uid
           additionalParams.wrap = &tx_example_pi1[item]=|
       }
   }

The TypoScript Configuration of the LinkHandler is being used in sysext `frontend`
in class :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`.

Example: news records displayed on fixed detail page
----------------------------------------------------

The following displays the link to the news on a detail page:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
      }
   }

Once more if the book reports that are also saved as `tx_news_domain_model_news` record should be displayed on their own
detail page you can do it like this:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

   config.recordLinks.bookreports  {
      typolink {
         parameter = 987
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
      }
   }


..  toctree::
    :titlesonly:
    :hidden:

    PageLinkHandler
    RecordLinkHandler
    CustomLinkHandlers
    Events
