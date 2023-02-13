.. include:: /Includes.rst.txt

.. _fal-using-fal-tca:

==============
TCA Definition
==============

This chapter explains how to create a field that makes it possible to
create relations to files.

..  versionchanged:: 12.0
    For TYPO3 v11 and below the API function
    :php:`ExtensionManagementUtility::getFileFieldTCAConfig()` was used to
    create a TCA configuration suitable to handle files. This function has been
    deprecated with the introduction of the new field type :ref:`t3tca:columns-file`.

The TCA field type :ref:`t3tca:columns-file` can be used to provide a field
in which files can be referenced and or uploaded:

..  code-block:: php
    :caption: EXT:some_extension/Configuration/TCA/my_table.php

    return [
        'columns' => [
            'my_media_file' => [
                'label' => 'My image',
                'config' => [
                    'type' => 'file',
                    'allowed' => 'common-media-types'
                ],
            ],
        ],
        // ...
    ];

On the database side, the corresponding field needs just store an integer,
as is usual for relations field:

.. code-block:: sql
   :caption: EXT:some_extension/ext_tables.sql

   CREATE TABLE my_table (
      my_media_file int(11) unsigned DEFAULT '0' NOT NULL,
   );

The property :php:`appearance` can be used to specify if a file upload button
and file by URL button (Vimeo, Youtube) should be displayed.

Example:

..  code-block:: php
    :caption: EXT:some_extension/Configuration/TCA/Overrides/my_table.php

    $GLOBALS['TCA']['my_table']['columns']['my_media_file']['config']['appearance'] = [
        'fileUploadAllowed' => false,
        'fileByUrlAllowed' => false,
    ];

This will suppress two buttons for upload and external URL and only leave
the button :guilabel:`Create new relation`.

Migration from :php:`ExtensionManagementUtility::getFileFieldTCAConfig`
=======================================================================

..  code-block:: php

    // Before
    'columns' => [
        'image' => [
            'label' => 'My image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'maxitems' => 6,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
    ],

    // After
    'columns' => [
        'image' => [
            'label' => 'My image',
            'config' => [
                'type' => 'file',
                'maxitems' => 6,
                'allowed' => 'common-image-types'
            ],
        ],
    ],
