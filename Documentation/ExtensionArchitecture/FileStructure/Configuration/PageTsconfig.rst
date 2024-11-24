.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/page.tsconfig
   Path; EXT:{extkey}/Configuration/page.tsconfig
.. _extension-configuration-page_tsconfig:

=====================
:file:`page.tsconfig`
=====================

..  versionadded:: 13.1
    Page TSconfig can be set using
    `the site et as Page TSconfig provider <https://docs.typo3.org/permalink/t3tsref:include-static-page-tsconfig-per-site>`_

    Only put page TSconfig in this file which absolutely has to be set globally.

In this file global page TSconfig can be stored. It will be automatically
included for all pages.

For details see
:ref:`Setting the page TSconfig globally <t3tsref:pagesettingdefaultpagetsconfig>`.

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.page.configuration.pageIdSelector.enabled = 1
