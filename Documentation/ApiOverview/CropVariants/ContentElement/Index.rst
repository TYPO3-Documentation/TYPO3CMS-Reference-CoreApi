..  include:: /Includes.rst.txt

..  _CE_cropvariants:

===============================================
Crop variants configuration per content element
===============================================

It is possible to provide a configuration per content element. If you want a different
cropping configuration for tt_content images, then you can add the following to
your `image` field configuration of tt_content records:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php (excerpt)

    'config' => [
        'overrideChildTca' => [
            'columns' => [
                'crop' => [
                    'config' => [
                        'cropVariants' => [
                            'mobile' => [
                                'title' => 'ext_key.messages:imageManipulation.mobile',
                                'cropArea' => [
                                    'x' => 0.1,
                                    'y' => 0.1,
                                    'width' => 0.8,
                                    'height' => 0.8,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]

Please note, you need to specify the target column name as array key. Most of the time this will be `crop`
as this is the default field name for image manipulation in `sys_file_reference`

It is also possible to set the cropping configuration only for a **specific tt_content element type** by using the
`columnsOverrides` feature:

..  literalinclude:: _tt_content.php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

..  _ce-cropvariants-disable-crop-variants:

Disable crop variants
=====================

Please note, as the array for `overrideChildTca` is merged with the child TCA, so are the crop variants that are defined
in the child TCA (most likely sys_file_reference). Because you cannot remove crop variants easily, it is possible to disable them
for certain field types by setting the array key for a crop variant `disabled` to the value `true` as you can see in the
example above for the default variant.
