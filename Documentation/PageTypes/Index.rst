.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _page-types:

Page types
==========


Global array :code:`$PAGES_TYPES` defines the various types of pages
(field: :code:`doktype`) the system can handle and what restrictions may apply to them.
Here you can set the icon and especially you can define which tables are
allowed on a certain page type.

.. note::
   The "default" entry in the :code:`$PAGES_TYPES` array is the "base"
   for all types, and for every type the entries simply overrides the
   entries in the "default" type!!

This is the default array as set in :file:`EXT:core/ext_tables.php`::

   $GLOBALS['PAGES_TYPES'] = array(
   	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_LINK => array(
   	),
   	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SHORTCUT => array(
   	),
   	...
   	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SYSFOLDER => array( //  Doktype 254 is a 'Folder' - a general purpose storage folder for whatever you like. In CMS context it's NOT a viewable page. Can contain any element.
   		'type' => 'sys',
   		'allowedTables' => '*'
   	),
   	...
   	'default' => array(
   		'type' => 'web',
   		'allowedTables' => 'pages',
   		'onlyAllowedTables' => '0'
   	)
   );


The key used in the array above is the value that will be stored in the
:code:`doktype` field of the "pages" table.

.. important::

   The choice of value for the :code:`doktype` is critical.
   If you want your custom page type to be displayed in the frontend,
   you must make sure to choose a :code:`doktype` smaller than 200.
   If it's supposed to be just some storage, choose a :code:`doktype`
   larger than 200.


Each array has the following options available:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,30: Key
   :Description,70: Description


 - :Key:
         type
   :Description:
         Can be "sys" or "web". This is purely informative, as TYPO3 CMS does
         nothing with that piece of data.


 - :Key:
         icon
   :Description:
         Alternative icon.

         The file reference is in the same format as "iconfile" in
         the :ref:`[ctrl] section <t3tca:ctrl>` of the TCA.


 - :Key:
         allowedTables
   :Description:
         The tables that may reside on pages with that "doktype".

         Comma-separated list of tables allowed on this page doktype. "\*" =
         all.


 - :Key:
         onlyAllowedTables
   :Description:
         Boolean. If set to true, changing the page type will be blocked if
         the chosen page type contains records that it would not allow.


.. note::
   **All four options** must be set for the default type while
   the rest can choose as they like.


.. _page-types-example:

Example
-------

The following example adds a new page type called "Archive" (taken from the
"examples" extensions). The first step is to add the new page type to the
global array described above::

	// Define a new doktype
	$customPageDoktype = 116;
	$customPageIcon = $relativeExtensionPath . 'Resources/Public/Images/Archive.png';
	// Add the new doktype to the list of page types
	$GLOBALS['PAGES_TYPES'][$customPageDoktype] = array(
		'type' => 'sys',
		'icon' => $customPageIcon,
		'allowedTables' => '*'
	);


To enable users to select that page type, it must also be added to the page type
selector of the "pages" table::


	// Add the new doktype to the page type selector
	$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = array(
		'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:archive_page_type',
		$customPageDoktype,
		$customPageIcon
	);


The same must be done with the "pages_language_overlay", so that the new page type
can also be translated::


	// Also add the new doktype to the page language overlays type selector (so that translations can inherit the same type)
	$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'][] = array(
		'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:archive_page_type',
		$customPageDoktype,
		$customPageIcon
	);


The icon chosen for the new page type must be added to the backend sprite::


	// Add the icon for the new doktype
	\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', $customPageDoktype, $customPageIcon);


You may want to perform some other finishing touches. For example, it might make sense
to add the new page type to the list of pages that can be selected from the
drag and drop menu at the top of the page tree::


	// Add the new doktype to the list of types available from the new page menu at the top of the page tree
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
		'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $customPageDoktype . ')'
	);


.. figure:: ../Images/NewPageType.png
   :alt: The new page type in action

   The new page type visible in the TYPO3 backend

