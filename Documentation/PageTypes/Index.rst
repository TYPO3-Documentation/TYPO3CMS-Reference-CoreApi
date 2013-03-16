.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _page-types:

Page types
==========


Global array :code:`$PAGES_TYPES` defines the various types of pages
(field: doktype) the system can handle and what restrictions may apply to them.
Here you can set the icon and especially you can define which tables are
allowed on a certain page type.

.. note::
   The "default" entry in the :code:`$PAGES_TYPES` array is the "base"
   for all types, and for every type the entries simply overrides the
   entries in the "default" type!!

This is the default array as set in :file:`t3lib/stddb/tables.php`::

   $PAGES_TYPES = array(
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


Each array has the following options available:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,30: Key
   :Description,70: Description


 - :Key:
         type
   :Description:
         Can be "sys" or "web"


 - :Key:
         icon
   :Description:
         Alternative icon.

         The file reference is on the same format "iconfile" in
         the :ref:`[ctrl] section <t3tca:ctrl>` of the TCA.


 - :Key:
         allowedTables
   :Description:
         The tables that may reside on pages with that "doktype".

         Comma-separated list of tables allowed on this page doktype. "\*" =
         all


 - :Key:
         onlyAllowedTables
   :Description:
         Boolean. If set, the :code:`tce_main` class will not allow a shift of doktype
         if unallowed records are on the page.


.. note::
   **All four options** must be set for the default type while
   the rest can choose as they like.
