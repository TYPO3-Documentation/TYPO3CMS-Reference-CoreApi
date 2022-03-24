.. include:: /Includes.rst.txt
.. highlight:: typoscript

.. _linkhandler:

===============
LinkHandler Api
===============

In TYPO3 8.6 the LinkHandler Api has been included in the core, see Change `Feature: #79626 - Integrate record link handler
<https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/8.6/Feature-79626-IntegrateRecordLinkHandler.html>`__. It had only
been available as 3rd party extension therefore.

The LinkHandler enables editors to link to single records i.e. a single news record.

The configuration consists of the following parts:

.. rst-class:: bignums-xxl

#. PageTSconfig is used to create a new tab in the LinkBrowser to be able to select records.

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

#. TypoScript is used to generate the actual link in the frontend.

   .. code-block:: typoscript

      config.recordLinks.anIdentifier {
          // Do not force link generation when the record is hidden
          forceLink = 0
          typolink {
              parameter = 123
              additionalParams.data = field:uid
              additionalParams.wrap = &tx_example_pi1[item]=|&tx_example_pi1[controller]=Item&tx_example_pi1[action]=show
              useCacheHash = 1
          }
      }

   .. important::

      Do not change the identifier after links have been created  using the LinkHandler. The identifier will be
      stored as part of the link in the database.

.. _linkhandler-pagetsconfig:

LinkHandler PageTSconfig Options
================================

The minimal PageTSconfig Configuration is::

   TCEMAIN.linkHandler.anIdentifier {
       handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
       label = LLL:EXT:extension/Resources/Private/Language/locallang.xlf:link.customTab
       configuration {
           table = tx_example_domain_model_item
       }
   }

The following optional configuration is available:

:typoscript:`configuration.hidePageTree = 1`
   Hide the page tree in the link browser

:typoscript:`configuration.storagePid = 84`
   The link browser starts with the given page

:typoscript:`configuration.pageTreeMountPoints = 123,456`
   Only records on these pages and their children will be displayed

Furthermore the following options are available from the LinkBrowser Api:

:typoscript:`configuration.scanAfter = page` or :typoscript:`configuration.scanBefore = page`
   define the order in which handlers are queried when determining the responsible tab for an existing link

:typoscript:`configuration.displayBefore = page` or :typoscript:`configuration.displayAfter = page`
   define the order how the various tabs are displayed in the link browser.

Example: news records from one storage pid
------------------------------------------

The following configuration hides the page tree and shows news records only from the defined storage page::

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

It is possible to have another configuration using another storagePid which also contains news records.
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

The PageTSconfig of the LinkHandler is being used in sysext `recordlist`
in class :php:`\TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler`
which does not contain Hooks or Slots.

.. _linkhandler-typoscript:

LinkHandler TypoScript Options
================================

A configuration could look like this::

   config.recordLinks.anIdentifier {
       forceLink = 0

       typolink {
           parameter = 123
           additionalParams.data = field:uid
           additionalParams.wrap = &tx_example_pi1[item]=|
           useCacheHash = 1
       }
   }

The TypoScript Configuration of the LinkHandler is being used in sysext `frontend`
in class :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`.

Example: news records displayed on fixed detail page
----------------------------------------------------

The following displays the link to the news on a detail page::

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
         useCacheHash = 1
      }
   }

Once more if the book reports that are also saved as `tx_news_domain_model_news` record should be displayed on their own
detail page you can do it like this::

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
         useCacheHash = 1
      }
   }
