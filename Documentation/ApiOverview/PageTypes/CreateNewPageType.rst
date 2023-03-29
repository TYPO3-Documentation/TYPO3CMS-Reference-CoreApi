.. include:: /Includes.rst.txt
.. index:: Page types; Custom
.. _page-types-example:

====================
Create new Page Type
====================

The following example adds a new page type called "Archive".

.. include:: /Images/AutomaticScreenshots/PageTypes/NewPageType.rst.txt

The whole code to add a page type is shown below with the according file names above.

.. versionchanged:: 12.0
   Starting with 12.0 a new PageDoktypeRegistry was introduced replacing the
   :php:`$GLOBALS['PAGES_TYPES']` array.

.. note::
    In versions below TYPO3 v12.0 the creation was done in the
    :file:`ext_tables.php` file, please use the version selector to look up
    the syntax in the corresponding documentation version.

The first step is to add the new page type to the PageDoktypeRegistry described above. Then you need to add
the icon chosen for the new page type and allow users to drag and drop the new page type to the page
tree.

.. note::

   You have to change :code:`example` in the argument of the anonymous function
   to your own extension key.

The new page type is added to the :php:`PageDoktypeRegistry::class` in
:file:`Configuration/TCA/Overrides/pages.php`:

.. code-block:: php
   :caption: EXT:example/Configuration/TCA/Overrides/pages.php

   (function ($extKey='example') {
      $archiveDoktype = 116;

      // Add new page type:
      $dokTypeRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry::class);
      $dokTypeRegistry->add(
          $archiveDoktype,
          [
              'type' => 'web',
              'allowedTables' => '*',
          ]
      );

   })();

User TSconfig is added in :file:`ext_localconf.php`:

.. code-block:: php
   :caption: EXT:example/ext_localconf.php

   (function ($extKey='example') {
      $archiveDoktype = 116;

      // Allow backend users to drag and drop the new page type:
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
          'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $archiveDoktype . ')'
      );
   })();


Icon is registered in :file:`Configuration/Icons.php`:

.. code-block:: php
   :caption: EXT:example/Configuration/Icons.php

   return [
       'apps-pagetree-archive' => [
           'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
           'source' => 'EXT:example/Resources/Public/Icons/Archive.svg',
       ]
       'apps-pagetree-archive-contentFromPid' => [
           'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
           'source' => 'EXT:example/Resources/Public/Icons/ArchiveContentFromPid.svg',
       ],
   ];
   // ... register other icons in the same way, see below.

Furthermore we need to modify the configuration of "pages" records. As one can modify the pages, we
need to add the new doktype as select item and associate it with the configured icon. That's done in
:file:`Configuration/TCA/Overrides/pages.php`:

.. code-block:: php
   :caption: EXT:example/Configuration/TCA/Overrides/pages.php

   (function ($extKey='example', $table='pages') {
      $archiveDoktype = 116;

      // Add new page type as possible select item:
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
          $table,
          'doktype',
          [
              'label' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang.xlf:archive_page_type',
              'value' => $archiveDoktype,
              'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/Archive.svg'
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
                      $archiveDoktype . '-contentFromPid' => "apps-pagetree-archive-contentFromPid",
                      $archiveDoktype . '-root' => "apps-pagetree-archive-root",
                      $archiveDoktype . '-hideinmenu' => "apps-pagetree-archive-hideinmenu",
                  ],
              ],
              // add all page standard fields and tabs to your new page type
              'types' => [
                  $archiveDoktype => [
                      'showitem' => $GLOBALS['TCA'][$table]['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT]['showitem']
                  ]
              ]
          ]
      );
   })();

As you can see from the example, to make sure you get the correct icons, you can utilize :php:`typeicon_classes`.

The complete code block with registered PageDoktype and configuration for pages in
:file:`Configuration/TCA/Overrides/pages.php`:

.. code-block:: php
   :caption: EXT:example/Configuration/TCA/Overrides/pages.php

   (function ($extKey='example', $table='pages') {
      $archiveDoktype = 116;

      // Add new page type:
      $dokTypeRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry::class);
      $dokTypeRegistry->add(
          $archiveDoktype,
          [
              'type' => 'web',
              'allowedTables' => '*',
          ]
      );

      // Add new page type as possible select item:
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
          $table,
          'doktype',
          [
              'label' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang.xlf:archive_page_type',
              'value' => $archiveDoktype,
              'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/Archive.svg'
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
                      $archiveDoktype . '-contentFromPid' => "apps-pagetree-archive-contentFromPid",
                      $archiveDoktype . '-root' => "apps-pagetree-archive-root",
                      $archiveDoktype . '-hideinmenu' => "apps-pagetree-archive-hideinmenu",
                  ],
              ],
              // add all page standard fields and tabs to your new page type
              'types' => [
                  $archiveDoktype => [
                      'showitem' => $GLOBALS['TCA'][$table]['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT]['showitem']
                  ]
              ]
          ]
      );
   })();

For the following cases you need to configure icons explicitly, otherwise they will automatically fall back to the
variant for regular page doktypes.

* Page contains content from another page (`<doktype>-contentFromPid`)
* Page is hidden in navigation (`<doktype>-hideinmenu`)
* Page is site-root (`<doktype>-root`)

.. note::

   Make sure to add the additional icons using the icon registry!


Further Information
-------------------

.. rst-class:: compact-list

* :doc:`ext_core:Changelog/11.4/Feature-94692-RegisteringIconsViaServiceContainer`

* :doc:`ext_core:Changelog/12.0/Breaking-98487-GLOBALSPAGES_TYPESRemoved`

* :doc:`ext_core:Changelog/12.3/Feature-99739-AssociativeArrayKeysForTCAItems`
