.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/TypoScript
   Path; EXT:{extkey}/Configuration/TypoScript
.. _extension-configuration-typoscript:

==================
:file:`TypoScript`
==================

..  versionchanged:: 13.1
    Until TYPO3 v13 frontend TypoScript files where kept in folder
    :path:`EXT:my_extension/Configuration/TypoScript/` by convention.

    Extensions that need to be backward compatible should
    `Support both site sets and TypoScript records <https://docs.typo3.org/permalink/t3tsref:extdev-add-typoscript-sets-v12>`_.

    Newly created extensions or site packages should use the
    `Site set as a TypoScript provider <https://docs.typo3.org/permalink/t3tsref:typoscript-site-sets-set>`_

TypoScript constants should be stored in a file called :file:`constants.typoscript`
and TypoScript setup in a file called :file:`setup.typoscript`.


..  directory-tree::
    :level: 2
    :show-file-icons: true

    *   packages/my_extension/Configuration/TypoScript/

        *   constants.typoscript
        *   setup.typoscript

These two files are made available for inclusion in TypoScript records with
:php:`ExtensionManagementUtility::addStaticFile` in the file
:file:`Configuration/TCA/Overrides/sys_template.php`:

.. literalinclude:: _snippets/_sys_template.php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_template.php

..  warning::
    In Sites that use no Site set it is possible, though not recommended,
    to provide TypoScript that is always included.
    See :ref:`ext_typoscript_constants_typoscript` and
    :ref:`ext_typoscript_setup_typoscript`. These files are not included when
    site uses a set.
