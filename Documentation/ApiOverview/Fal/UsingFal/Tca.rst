..  include:: /Includes.rst.txt

..  _fal-using-fal-tca:

==============
TCA definition
==============

This chapter explains how to create a field that makes it possible to
create relations to files.

The TCA field type :ref:`File <t3tca:columns-file>` can be used to provide a
field in which files can be referenced and/or uploaded:

..  literalinclude:: _Tca/_my_table.php
    :caption: EXT:my_extension/Configuration/TCA/my_table.php

The property :ref:`appearance <t3tca:columns-file-properties-appearance>` can be
used to specify, if a file upload button and file by URL button (Vimeo, Youtube)
should be displayed.

Example:

..  literalinclude:: _Tca/_overrides_my_table.php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/my_table.php

This will suppress two buttons for upload and external URL and only leave
the button :guilabel:`Create new relation`.

..  _fal-using-fal-tca-migration-extensionmanagementutility-getfilefieldtcaconfig:

Migration from `ExtensionManagementUtility::getFileFieldTCAConfig`
==================================================================

..  code-block:: diff
    :caption: EXT:my_extension/Configuration/TCA/my_table.php (migration)

    -use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
    -
     'columns' => [
         'image' => [
             'label' => 'My image',
    -        'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
    -            'image',
    -            [
    -                'maxitems' => 6,
    -            ],
    -            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
    -        ),
    +        'config' => [
    +            'type' => 'file',
    +            'maxitems' => 6,
    +            'allowed' => 'common-image-types'
    +        ],
         ],
     ],
