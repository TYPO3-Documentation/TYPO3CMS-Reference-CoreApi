.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/TypoScript
   Path; EXT:{extkey}/Configuration/TypoScript
.. _extension-configuration-typoscript:

==================
:file:`TypoScript`
==================

By convention all TypoScript, that can be included manually, should
be stored in the folder :file:`EXT:my_extension/Configuration/TypoScript/`.

.. note::
   It is possible, though usually not recommended, to provide TypoScript
   that is always included. See :ref:`ext_typoscript_constants_typoscript` and
   :ref:`ext_typoscript_setup_typoscript`.

TypoScript constants should be stored in a file called :file:`constants.typoscript`
and TypoScript setup in a file called :file:`setup.typoscript`.

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

These two files are made available for inclusion in TypoScript records with
:php:`ExtensionManagementUtility::addStaticFile` in the file
:file:`Configuration/TCA/Overrides/sys_template.php`:

.. literalinclude:: _snippets/_sys_template.php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_template.php

It is also possible to use subfolders or a differently named folder. The file
names have to stay exactly the same including case.

..  warning::
    In Sites that use no Site set it is possible, though not recommended,
    to provide TypoScript that is always included.
    See :ref:`ext_typoscript_constants_typoscript` and
    :ref:`ext_typoscript_setup_typoscript`. These files are not included when
    site uses a set.
