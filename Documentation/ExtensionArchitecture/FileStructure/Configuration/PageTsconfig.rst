.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/page.tsconfig
   Path; EXT:{extkey}/Configuration/page.tsconfig
.. _extension-configuration-page_tsconfig:

================================
:file:`page.tsconfig`
================================

.. versionadded:: 12.0
   Starting with TYPO3 version 12.0 page TSconfig from
   :file:`Configuration/page.tsconfig` is automatically included for all
   pages.

In this file global page TSconfig can be stored. It will be automatically
included for all pages.

For details see
:ref:`Setting the page TSconfig globally <t3tsref:pagesettingdefaultpagetsconfig>`.


.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.page.configuration.pageIdSelector.enabled = 1
