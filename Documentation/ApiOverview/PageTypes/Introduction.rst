.. include:: /Includes.rst.txt
.. _page-types-intro:

============
Introduction
============


.. index::
   Page types; Configuration
   $GLOBALS; PAGE_TYPES

The $GLOBALS['PAGE_TYPES'] array
================================

Global array :php:`$GLOBALS['PAGES_TYPES']` defines the various types of pages (field: :code:`doktype`) the
system can handle and what restrictions may apply to them. Here you can define which tables are
allowed on a certain page type.

.. note::
   The "default" entry in the :php:`$GLOBALS['PAGES_TYPES']` array is the "base"
   for all types, and for every type the entries simply overrides the
   entries in the "default" type!!

This is the default array as set in :file:`EXT:core/ext_tables.php`::

   $GLOBALS['PAGES_TYPES'] = [
      (string)\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_BE_USER_SECTION => [
         'allowedTables' => '*'
      ],
      (string)\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_SYSFOLDER => [
         //  Doktype 254 is a 'Folder' - a general purpose storage folder for whatever you like.
         // In CMS context it's NOT a viewable page. Can contain any element.
         'allowedTables' => '*'
      ],
      (string)\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_RECYCLER => [
         // Doktype 255 is a recycle-bin.
         'allowedTables' => '*'
      ],
      'default' => [
         'allowedTables' => 'pages,sys_category,sys_file_reference,sys_file_collection',
         'onlyAllowedTables' => false
      ],
   ];


The key used in the array above is the value that will be stored in the
:code:`doktype` field of the "pages" table.

.. tip::
   As for other :php:`$GLOBALS` values, you can view current settings in the
   backend in :guilabel:`System > Configuration` (with installed lowlevel
   system extension).

.. note::

   In TYPO3 versions below 10.4, the :code:`doktype` was restricted to numbers
   smaller than 200 if the custom page type should be displayed in the
   frontend, and larger than 200 when it is just some storage. This limitation
   no longer exists, so you can choose a number at will.

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
   The options :code:`allowedTables` and :code:`onlyAllowedTables` must be set
   for the default type while the rest can choose as they like.
