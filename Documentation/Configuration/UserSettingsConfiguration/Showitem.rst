.. include:: /Includes.rst.txt
.. index:: User settings; Showitem section
.. _user-settings-showitem:

====================
['showitem'] section
====================

This string is used for rendering the form in the user setup module.
It contains a comma-separated list of fields, which will be rendered
in that order.

To use a tab insert a :code:`--div--;LLL:EXT:foo/...` item in the list.

Example (taken from :file:`typo3/sysext/setup/ext_tables.php`):

.. code-block:: php

   'showitem' => '--div--;LLL:EXT:setup/Resources/Private/Language/locallang.xlf:personal_data,realName,email,emailMeAtLogin,avatar,lang,
               --div--;LLL:EXT:setup/Resources/Private/Language/locallang.xlf:passwordHeader,passwordCurrent,password,password2,
               --div--;LLL:EXT:setup/Resources/Private/Language/locallang.xlf:opening,startModule,
               --div--;LLL:EXT:setup/Resources/Private/Language/locallang.xlf:editFunctionsTab,edit_RTE,resizeTextareas_MaxHeight,titleLen,edit_docModuleUpload,showHiddenFilesAndFolders,copyLevels,resetConfiguration'
