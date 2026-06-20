:navigation-title: General Configuration

..  include:: /Includes.rst.txt

..  _cropvariants-general:

==========================
Crop variant configuration
==========================

The example below adds a new crop configuration to table :sql:`sys_file_reference`,
which is then applied to every record that references images.

Two crop variants are configured; one with the id "mobile" and
one with the id "desktop". Crop variant ids are referenced
by image view helpers to render images.

Each crop variant has at least one *ratio configuration* defined under ``allowedAspectRatios``:

*  the ratio configuration key **must not** contain a dot character (``.``):

   *  good examples: ``NaN``, ``4:3`` or ``other-format``
   *  bad example: ``1:1.441``

*  the ratio configuration value is an array consisting of two keys:

   *  ``title``: should be a string (or preferably an LLL reference)
   *  ``value``: should be a **float** (not a string)

..  code-block:: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_file_reference.php

    $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
         'type' => 'imageManipulation',
         'cropVariants' => [
             'mobile' => [
                 'title' => 'LLL:EXT:ext_key/Resources/Private/Language/locallang.xlf:imageManipulation.mobile',
                 'allowedAspectRatios' => [
                     '4:3' => [
                         'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.4_3',
                         'value' => 4 / 3
                     ],
                     'NaN' => [
                         'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.free',
                         'value' => 0.0
                     ],
                 ],
             ],
             'desktop' => [
                 'title' => 'LLL:EXT:ext_key/Resources/Private/Language/locallang.xlf:imageManipulation.desktop',
                 'allowedAspectRatios' => [
                     '4:3' => [
                         'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.4_3',
                         'value' => 4 / 3
                     ],
                     'NaN' => [
                         'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.free',
                         'value' => 0.0
                     ],
                 ],
             ],
         ]
    ]

..  _cropvariants-general-cropArea:

Crop Area
=========

An initial crop area can be defined. If it is not defined, the default crop area will cover the complete image.
Crop areas are defined relatively with floating point numbers: x and y coordinates and width and height must be specified.
The example below has an initial crop area in the same size that the previous image cropper provided by default.

.. code-block:: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_file_reference.php

    $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
        'type' => 'imageManipulation',
        'cropVariants' => [
            'mobile' => [
                'title' => 'LLL:EXT:ext_key/Resources/Private/Language/locallang.xlf:imageManipulation.mobile',
                'cropArea' => [
                    'x' => 0.1,
                    'y' => 0.1,
                    'width' => 0.8,
                    'height' => 0.8,
                ],
            ],
        ],
    ]

..  _cropvariants-general-focusArea:

Focus Area
==========

Users can also select a focus area, if configured. The focus area is always **inside**
the crop area and marks the area of the image which is important and must be
visible. The selected area is persisted to the database but will have no effect on image processing.
The data points are, however, made available as data attribute when using the `<f:image />` view helper and
can be used by Javascript libraries.

The example below adds a focus area which is initially one third of the size of the image
and centered.

.. code-block:: php

    :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_file_reference.php

    $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
        'type' => 'imageManipulation',
        'cropVariants' => [
            'mobile' => [
                'title' => 'LLL:EXT:ext_key/Resources/Private/Language/locallang.xlf:imageManipulation.mobile',
                'focusArea' => [
                    'x' => 1 / 3,
                    'y' => 1 / 3,
                    'width' => 1 / 3,
                    'height' => 1 / 3,
                ],
            ],
        ],
    ]

..  _cropvariants-general-coverAreas:

Cover Area
==========

Images are often used in a context where they are overlaid with other DOM elements
like a headline. To give editors a hint about which area of an image is affected,
when selecting a crop area it is possible to define multiple "cover areas". These areas are shown inside
the crop area. The focus area cannot intersect with any cover areas.

.. code-block:: php

    :caption: EXT:my_extension/Configuration/TCA/Overrides/sys_file_reference.php

    $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
        'type' => 'imageManipulation',
        'cropVariants' => [
            'mobile' => [
                'title' => 'LLL:EXT:ext_key/Resources/Private/Language/locallang.xlf:imageManipulation.mobile',
                'coverAreas' => [
                    [
                        'x' => 0.05,
                        'y' => 0.85,
                        'width' => 0.9,
                        'height' => 0.1,
                    ]
                ],
            ],
        ],
    ]

..  _cropvariants-general-rendering:

Rendering crop variants
=======================

Render a crop variant by adding it as an argument to an image view helper:

.. code-block:: html

    <f:image image="{data.image}" cropVariant="mobile" width="800" />
