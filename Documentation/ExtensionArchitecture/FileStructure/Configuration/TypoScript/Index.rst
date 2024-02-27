.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/TypoScript
   Path; EXT:{extkey}/Configuration/TypoScript
.. _extension-configuration-typoscript:

================================
:file:`TypoScript`
================================

By convention all TypoScript, that can be included manually, should
be stored in the folder :file:`EXT:my_extension/Configuration/TypoScript/`.

.. note::
   It is possible, though usually not recommended, to provide TypoScript
   that is always included. See :ref:`ext_typoscript_constants_typoscript` and
   :ref:`ext_typoscript_setup_typoscript`.

TypoScript constants should be stored in a file called :file:`constants.typoscript`
and TypoScript setup in a file called :file:`setup.typoscript`.

.. code-block:: none
   :caption: TypoScript folder

   $ tree packages/my_extension/Configuration/TypoScript/
   ├── constants.typoscript
   └── setup.typoscript

These two files will be included via
:php:`ExtensionManagementUtility::addStaticFile` in the file
:file:`Configuration/TCA/Overrides/sys_template.php`:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_template.php

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
       'my_extension',
       'Configuration/TypoScript/',
       'Examples TypoScript'
   );

If there should be more then one set of TypoScript templates that may be
included, you can use store them in sub folders.

If your TypoScript is complex and you need to break it up into several files
you should use the ending :file:`.typoscript` for these files.

.. code-block:: none
   :caption: TypoScript folder, extended

   $ tree packages/my_extension/Configuration/TypoScript/
   ├── Example1
   │    ├── constants.typoscript
   │    └── setup.typoscript
   ├── SpecialFeature2
   │    ├── Setup
   │    │    ├── SomeIncludes.typoscript
   │    │    └── OtherIncludes.typoscript
   │    ├── constants.typoscript
   │    └── setup.typoscript
   ├── constants.typoscript
   └── setup.typoscript

In this case :php:`ExtensionManagementUtility::addStaticFile` needs to be called
for each folder that should be available in the TypoScript template record:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_template.php

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
       'my_extension',
       'Configuration/TypoScript/',
       'My Extension - Main TypoScript'
   );

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
       'my_extension',
       'Configuration/TypoScript/Example1/',
       'My Extension - Additional example 1'
   );

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
       'my_extension',
       'Configuration/TypoScript/SpecialFeature2/',
       'My Extension - Some special feature'
   );

.. note::
   For historic reasons you might still see filenames like :file:`setup.ts` and
   :file:`setup.txt`. For backward compatibility reasons these are still
   included by :php:`ExtensionManagementUtility::addStaticFile`. However all
   new TypoScript files should have the file ending :file:`.typoscript`.
