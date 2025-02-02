..  include:: /Includes.rst.txt
..  index:: File; EXT:{extkey}/ext_typoscript_constants.typoscript
..  _ext_typoscript_constants_typoscript:

=====================================
`ext_typoscript_constants.typoscript`
=====================================

..  typo3:file:: ext_typoscript_constants.typoscript
    :scope: extension
    :regex: /^.*ext\_typoscript\_constants\.(typoscript|txt|ts)$/
    :shortDescription: Preset TypoScript constants for sites without site sets

    Preset TypoScript constants. Will be included in the setup section of all
    TypoScript templates.

.. attention::

   Use such a file if you absolutely need to load some TypoScript (because you
   would get serious errors without it). Otherwise static templates or
   usage of the *Extension Management API* of class
   :php:`TYPO3\CMS\Core\Utility\ExtensionManagementUtility` are preferred.
