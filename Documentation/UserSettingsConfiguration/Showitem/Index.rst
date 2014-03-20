.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _user-settings-showitem:

['showitem'] section
^^^^^^^^^^^^^^^^^^^^

This string is used for rendering the form in the user setup module.
It contains a comma-separated list of fields, which will be rendered
in that order.

To use a tab insert a :code:`--div--;LLL:EXT:foo/...` item in the list.

Example (taken from :file:`typo3/sysext/setup/ext_tables.php`):

.. code-block:: php

	'showitem' => '--div--;LLL:EXT:setup/mod/locallang.xlf:personal_data,realName,email,emailMeAtLogin,password,password2,lang,
			--div--;LLL:EXT:setup/mod/locallang.xlf:opening,startModule,thumbnailsByDefault,titleLen,
			--div--;LLL:EXT:setup/mod/locallang.xlf:editFunctionsTab,edit_RTE,edit_wideDocument,edit_docModuleUpload,showHiddenFilesAndFolders,resizeTextareas,resizeTextareas_Flexible,resizeTextareas_MaxHeight,copyLevels,recursiveDelete,resetConfiguration,clearSessionVars,
			--div--;LLL:EXT:setup/mod/locallang.xlf:adminFunctions,simulate,debugInWindow'
