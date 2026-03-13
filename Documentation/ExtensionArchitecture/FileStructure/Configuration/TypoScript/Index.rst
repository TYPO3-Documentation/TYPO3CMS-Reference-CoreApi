.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/TypoScript
   Path; EXT:{extkey}/Configuration/TypoScript
.. _extension-configuration-typoscript:

==================
:file:`TypoScript`
==================

..  versionchanged:: 13.1
    Until TYPO3 v13 frontend TypoScript files were kept in
    :path:`EXT:my_extension/Configuration/TypoScript/` by convention.

    Extensions that need to be backwardly compatible should
    `Support both site sets and TypoScript records <https://docs.typo3.org/permalink/t3tsref:extdev-add-typoscript-sets-v12>`_.

    Newly created extensions and site packages should use a
    `Site set as a TypoScript provider <https://docs.typo3.org/permalink/t3tsref:typoscript-site-sets-set>`_

TypoScript constants should be stored in the file :file:`constants.typoscript`
and TypoScript setup in :file:`setup.typoscript`.

..  typo3:file:: constants.typoscript
    :scope: extension
    :path: /Configuration/TypoScript
    :regex: /^.*Configuration\/TypoScript\/.*constants\.typoscript/
    :shortDescription: Contains the TypoScript constants of the extension. The path is convention, the file name mandatory.

..  typo3:file:: setup.typoscript
    :scope: extension
    :path: /Configuration/TypoScript
    :regex: /^.*Configuration\/TypoScript\/.*setup\.typoscript/
    :shortDescription: Contains the TypoScript setup of the extension. The path is convention, the file name mandatory.

These two files are made available for inclusion in TypoScript records by
:php:`ExtensionManagementUtility::addStaticFile` in
:file:`Configuration/TCA/Overrides/sys_template.php`:

.. literalinclude:: _snippets/_sys_template.php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_template.php

It is possible to use subfolders or a differently named folder instead, however, the file
names have to stay the same.

..  warning::
    In Sites that don't use Site sets it is possible, though not recommended,
    to have TypoScript that is always included.
    See :ref:`ext_typoscript_constants_typoscript` and
    :ref:`ext_typoscript_setup_typoscript`. These files are not included when
    a site uses a set.
