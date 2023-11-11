.. include:: /Includes.rst.txt

.. _fal-using-fal-tca:

==============
TCA definition
==============

This chapter explains how to create a field that makes it possible to
create relations to files.

..  versionchanged:: 12.0
    For TYPO3 v11 and below the API function
    :php:`ExtensionManagementUtility::getFileFieldTCAConfig()` was used to
    create a TCA configuration suitable to handle files. This function has been
    deprecated with the introduction of the new field type :ref:`t3tca:columns-file`.
    See the :ref:`Migration <t3tca:columns-file-migration>` section on how to
    adjust the configuration.

The TCA field type :ref:`t3tca:columns-file` can be used to provide a field
in which files can be referenced and/or uploaded:

..  literalinclude:: _Tca/_my_table.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/my_table.php

On the database side, the corresponding field needs to store an integer,
as is usual for relations field:

..  literalinclude:: _Tca/_ext_tables.sql
    :language: sql
    :caption: EXT:my_extension/ext_tables.sql

The property :ref:`appearance <t3tca:columns-file-properties-appearance>` can be
used to specify, if a file upload button and file by URL button (Vimeo, Youtube)
should be displayed.

Example:

..  literalinclude:: _Tca/_overrides_my_table.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/my_table.php

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
