.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/page.tsconfig
   Path; EXT:{extkey}/Configuration/page.tsconfig
.. _extension-configuration-page_tsconfig:

=====================
:file:`page.tsconfig`
=====================

..  typo3:file:: page.tsconfig
    :scope: extension
    :path: /Configuration/
    :regex: /^.*Configuration\/page\.tsconfig$/
    :shortDescription: Global page TSconfig

    In this file global page TSconfig can be stored. It will be automatically
    included in all pages.

    For details see
    :ref:`Setting the page TSconfig globally <t3tsref:pagesettingdefaultpagetsconfig>`.

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.page.configuration.pageIdSelector.enabled = 1
