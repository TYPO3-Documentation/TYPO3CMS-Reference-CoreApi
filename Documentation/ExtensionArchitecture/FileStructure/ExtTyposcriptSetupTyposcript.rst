.. include:: /Includes.rst.txt
.. index:: File; EXT:{extkey}/ext_typoscript_setup.typoscript
.. _ext_typoscript_setup_typoscript:

=======================================
:file:`ext_typoscript_setup.typoscript`
=======================================

Preset TypoScript setup. Will be included in the setup section of all
TypoScript templates.

.. attention::

   Use such a file if you absolutely need to load some TypoScript (because you
   would get serious errors without it). Otherwise static templates or
   usage of the *Extension Management API* of class
   :php:`TYPO3\CMS\Core\Utility\ExtensionManagementUtility` are preferred.
