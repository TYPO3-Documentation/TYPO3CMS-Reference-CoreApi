.. include:: /Includes.rst.txt

.. _cropvariants:

=====================
General Configuration
=====================

The following examples are meant to add one single
cropping configuration to sys_file_reference, which will then apply to every
record referencing images.

In this example we configure two crop variants, one with the id "mobile",
one with the id "desktop". The array key defines the crop variant id, which will be used
when rendering an image with the image view helper.

For each crop variant there's at least one *ratio configuration* defined as ``allowedAspectRatios``:

* its key **must not** contain the dot character (``.``):

  * good examples: ``NaN``, ``4:3`` or ``other-format``
  * bad example: ``1:1.441``
 
* its value is an array consisting of two keys:

  * ``title``: should be a string (or even better: a LLL reference)
  * ``value``: **should** be a float (not a string!)

.. code-block:: php

    'config' => [
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

Crop Area
=========

It is also possible to define an initial crop area. If no initial crop area is defined, the default selected crop area will cover the complete image.
Crop areas are defined relatively with floating point numbers. The x and y coordinates and width and height must be specified for that.
The below example has an initial crop area in the size the previous image cropper provided by default.

.. code-block:: php

    'config' => [
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

Focus Area
==========

Users can also select a focus area, when configured. The focus area is always **inside**
the crop area and marks the area of the image which must be visible for the image to transport
its meaning. The selected area is persisted to the database but will have no effect on image processing.
The data points are however made available as data attribute when using the `<f:image />` view helper and
can be used by Javascript libraries.

The below example adds a focus area, which is initially one third of the size of the image
and centered.

.. code-block:: php

    'config' => [
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

Cover Area
==========

Images are often used in a context where they are overlaid with other DOM elements
like a headline. To give editors a hint which area of the image is affected, when selecting a crop area,
it is possible to define multiple so-called cover areas. These areas are shown inside
the crop area. The focus area cannot intersect with any of the cover areas.

.. code-block:: php

    'config' => [
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


Rendering crop variants
=======================

To render specific crop variants, the variant can be specified as argument of the image view helper:

.. code-block:: html

    <f:image image="{data.image}" cropVariant="mobile" width="800" />
