.. include:: /Includes.rst.txt
.. index:: LinkBrowser; record links
.. _TableRecordLinkBrowserTutorials:

=========================
Browse records of a table
=========================

This tutorial explains how to create a link browser to the records of a table.
It can be used to create links to a news detail page (See also the
:ref:`Link browser example in tutorial in the news manual <ext_news:linkhandler>`)
or to the record of another third-party extension.

In our example extension `t3docs/examples <https://github.com/TYPO3-Documentation/t3docs-examples>`__
we demonstrate creating a custom record link browser by linking to the single
view of a haiku poem.

Backend: Configure the link browser with page TSconfig
======================================================

The following configuration displays an additional tab in the link browser
window in the backend.

.. code-block:: typoscript
    :caption: EXT:examples/Configuration/TsConfig/Page/Extension/Linkhandler.tsconfig

    TCEMAIN.linkHandler {
       haiku {
          handler = TYPO3\CMS\Recordlist\LinkHandler\RecordLinkHandler
          label = LLL:EXT:examples/Resources/Private/Language/locallang_browse_links.xlf:haiku
          configuration {
             table = tx_examples_haiku
          }
          displayAfter = url
          scanBefore = page
       }
    }

You can find all available options here: :ref:`linkhandler-pagetsconfig_options`.

The link will then be saved as `t3://record?identifier=haiku&uid=1` in backend link
fields and as
:html:`<a href="t3://record?identifier=haiku&amp;uid=1">Look at this Haiku!</a>`
in the richt text editor (RTE).

The output of the link needs still needs to be configured or the
link will be removed upon rendering. See the next step:

Frontend: Configure the detail link to the record with TypoScript
=================================================================

For the frontend output of the haiku record links we have to configure the
page on which the plugin handling the detail view is displayed and the
parameters this plugin expects:

.. code-block:: typoscript
    :caption: EXT:examples/Configuration/TypoScript/RecordLinks/Haiku.typoscript

    config.recordLinks.haiku {
       // Do not force link generation when the record is hidden
       forceLink = 0

       typolink {
          parameter = {$plugin.tx_examples_haiku.settings.singlePid}
          additionalParams.data = field:uid
          additionalParams.wrap = &tx_examples_haiku[action]=show&tx_examples_haiku[haiku]=|
       }
    }

You can find the available options here: :ref:`linkhandler-typoscript_options`.
