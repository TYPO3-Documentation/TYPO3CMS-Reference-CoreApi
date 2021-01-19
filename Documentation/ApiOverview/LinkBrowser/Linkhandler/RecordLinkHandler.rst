.. include:: /Includes.rst.txt
.. highlight:: typoscript
.. index:: LinkHandlers; RecordLinkHandler
.. _recordlinkhandler:

=====================
The RecordLinkHandler
=====================

.. versionadded:: 8.6
    The RecordLinkHandler has been included in the Core with 8.6.
    Before, it had only been available as the third party extension "linkhandler".

The RecordLinkHandler enables editors to link to single records, for example a
single news record.

It is implemented in class :php:`\TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler`
of the system extension :file:`recordlist`. The class is marked as
:php:`@internal` and contains neither hooks nor events.

In order to use the RecordLinkHandler it can be configured as following:

.. rst-class:: bignums-xxl

#. Page TSconfig is used to create a new tab in the LinkBrowser to
   be able to select records.

   .. code-block:: typoscript

      TCEMAIN.linkHandler.anIdentifier {
          handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
          label = LLL:EXT:extension/Resources/Private/Language/locallang.xlf:link.customTab
          configuration {
              table = tx_example_domain_model_item
          }
          scanAfter = page
      }

   You can position your own handlers in order as defined in the :ref:`linkbrowser-api`.

   The links are now stored in the database with the syntax
   `<a href="t3://record?identifier=anIdentifier&amp;uid=456">A link</a>`.

#. TypoScript configures how the link will be displayed in the frontend.

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

   .. important::

      Do not change the identifier after links have been created using the
      RecordLinkHandler. The identifier will be stored as part of the link in the
      database.


.. index::
   pair: RecordLinkHandler; Page TSconfig
   TCEMAIN; RecordLinkHandler
.. _linkhandler-pagetsconfig:

RecordLinkHandler page TSconfig options
=======================================

The minimal page TSconfig configuration is::

   TCEMAIN.linkHandler.anIdentifier {
       handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
       label = LLL:EXT:extension/Resources/Private/Language/locallang.xlf:link.customTab
       configuration {
           table = tx_example_domain_model_item
       }
   }

The following optional configuration is available:

:ts:`configuration.hidePageTree = 1`
   Hide the page tree in the link browser

:ts:`configuration.storagePid = 84`
   The link browser starts with the given page

:ts:`configuration.pageTreeMountPoints = 123,456`
   Only records on these pages and their children will be displayed

Furthermore the following options are available from the LinkBrowser Api:

:ts:`configuration.scanAfter = page` or :ts:`configuration.scanBefore = page`
   define the order in which handlers are queried when determining the responsible tab for an existing link

:ts:`configuration.displayBefore = page` or :ts:`configuration.displayAfter = page`
   define the order how the various tabs are displayed in the link browser.


Example: news records from one storage pid
------------------------------------------

The following configuration hides the page tree and shows news records only
from the defined storage page::

   TCEMAIN.linkHandler.news {
       handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
       label = News
       configuration {
           table = tx_news_domain_model_news
           storagePid = 123
           hidePageTree = 1
       }
       displayAfter = mail
   }

It is possible to have another configuration using another storagePid which also
contains news records.

This configuration shows a reduced page tree starting at page with uid 42::

   TCEMAIN.linkHandler.bookreports {
       handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
       label = Book Reports
       configuration {
           table = tx_news_domain_model_news
           storagePid = 42
           pageTreeMountPoints = 42
           hidePageTree = 0
       }
   }


.. index::
   pair: LinkHandler; TypoScript
   TypoScript; config.recordLinks
.. _linkhandler-typoscript:

LinkHandler TypoScript options
==============================

A configuration could look like this::

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
====================================================

The following displays the link to the news on a detail page::

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
      }
   }

Once more if the book reports that are also saved as `tx_news_domain_model_news` record should be displayed on their own
detail page you can do it like this::

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
      }
   }
