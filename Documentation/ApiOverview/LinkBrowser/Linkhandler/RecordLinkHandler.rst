.. include:: /Includes.rst.txt
.. highlight:: typoscript
.. index:: LinkHandlers; RecordLinkHandler
.. _recordlinkhandler:

=====================
The RecordLinkHandler
=====================

The RecordLinkHandler enables editors to link to single records, for example a
single news record.

It is implemented in class :php:`\TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler`
of the system extension :file:`backend`. The class is marked as
:php:`@internal` and contains neither hooks nor events.

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    LinkHandlers has changed from
    :php:`TYPO3\CMS\Recordlist\LinkHandler`
    to
    :php:`TYPO3\CMS\Backend\LinkHandler`.
    For TYPO3 v12 the moved classes are available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

In order to use the RecordLinkHandler it can be configured as following:

.. rst-class:: bignums-xxl

#. Page TSconfig is used to create a new tab in the LinkBrowser to
   be able to select records.

   .. code-block:: typoscript

      TCEMAIN.linkHandler.anIdentifier {
          handler = TYPO3\CMS\Backend\LinkHandler\RecordLinkHandler
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
.. _linkhandler-pagetsconfig_options:

RecordLinkHandler page TSconfig options
=======================================

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
       displayAfter = mail
   }

It is possible to have another configuration using another storagePid which also
contains news records.

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


.. index::
   pair: LinkHandler; TypoScript
   TypoScript; config.recordLinks
.. _linkhandler-typoscript_options:

LinkHandler TypoScript options
==============================

A configuration could look like this:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

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

The following displays the link to the news on a detail page:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

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
   :caption: EXT:some_extension/Configuration/page.tsconfig

   config.recordLinks.news {
      typolink {
         parameter = 123
         additionalParams.data = field:uid
         additionalParams.wrap = &tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=|
      }
   }
