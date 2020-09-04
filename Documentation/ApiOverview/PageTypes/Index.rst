.. include:: ../../Includes.txt


.. _page-types:

==========
Page Types
==========

The $GLOBALS['PAGE_TYPES'] Array
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

.. _list-of-page-types:

Types of Pages
==============

TYPO3 has predefined a number of pages types as constants in
:file:`typo3/sysext/core/Classes/Domain/Repository/PageRepository.php`.

What role each page type plays and when to use it is explained in more
detail in :ref:`t3editors:pages-types`. Some of the page types require
additional fields in pages to be filled out:

`DOKTYPE_DEFAULT`
   Standard

`DOKTYPE_LINK`
   Link to External URL

   This type of page creates a redirect to an URL in the frontend.
   The URL is specified in the field `pages.url`.

`DOKTYPE_SHORTCUT`
   Shortcut

   This type of page creates a redirect to another page in the frontend.
   The shortcut target is specified in the field `pages.shortcut`,
   shortcut mode is stored in `pages.shortcut_mode`.

`DOKTYPE_BE_USER_SECTION`
   Backend User Section

`DOKTYPE_MOUNTPOINT`
   Mount point

   The mounted page is specified in `pages.mount_pid`,
   while display options can be changed with `pages.mount_pid_ol`.

`DOKTYPE_SPACER`
   Menu separator

`DOKTYPE_SYSFOLDER`
   Folder

`DOKTYPE_RECYCLER`
   Recycler


.. _page-types-example:

Create new Page Type
====================

The following example adds a new page type called "Archive".

.. figure:: Images/NewPageType.png
   :alt: The new page type in action

   The new page type visible in the TYPO3 backend

The whole code to add a page type is shown below with the according file names above.

The first step is to add the new page type to the global array described above. Then you need to add
the icon chosen for the new page type and allow users to drag and drop the new page type to the page
tree.

.. note::

   You have to change :code:`example` in the argument of the anonymous function
   to your own extension key.

The new page type is added to :php:`$GLOBALS['PAGES_TYPES']` in :file:`ext_tables.php`::

   (function ($extKey='example') {
      $archiveDoktype = 116;

      // Add new page type:
      $GLOBALS['PAGES_TYPES'][$archiveDoktype] = [
          'type' => 'web',
          'allowedTables' => '*',
      ];

   })();

User TSconfig is added and an icon is registed in :file:`ext_localconf.php`::

   (function ($extKey='example') {
      // Provide icon for page tree, list view, ... :
      \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
          ->registerIcon(
              'apps-pagetree-archive',
              TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
              [
                  'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/Archive.svg',
              ]
          );

      // Allow backend users to drag and drop the new page type:
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
          'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $archiveDoktype . ')'
      );
   })();

Furthermore we need to modify the configuration of "pages" records. As one can modify the pages, we
need to add the new doktype as select item and associate it with the configured icon. That's done in
:file:`Configuration/TCA/Overrides/pages.php`::

   (function ($extKey='example', $table='pages') {
      $archiveDoktype = 116;

      // Add new page type as possible select item:
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
          $table,
          'doktype',
          [
              'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang.xlf:archive_page_type',
              $archiveDoktype,
              'EXT:' . $extKey . '/Resources/Public/Icons/Archive.svg'
          ],
          '1',
          'after'
      );

      \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
          $GLOBALS['TCA'][$table],
          [
              // add icon for new page type:
              'ctrl' => [
                  'typeicon_classes' => [
                      $archiveDoktype => 'apps-pagetree-archive',
                  ],
              ],
              // add all page standard fields and tabs to your new page type
              'types' => [
                  (string) $archiveDoktype => [
                      'showitem' => $GLOBALS['TCA'][$table]['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT]['showitem']
                  ]
              ]
          ]
      );
   })();

