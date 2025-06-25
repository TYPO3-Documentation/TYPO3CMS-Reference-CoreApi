..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; GFX
    TYPO3_CONF_VARS GFX
..  _typo3ConfVars_gfx:

============================
GFX - graphics configuration
============================

You can test the graphics configuration in module
:guilabel:`Environment > Image Processing`.
See also :ref:`environment-test-image-processing`.

The following configuration variables can be used to configure settings for
the handling of images and graphics:

The configuration values listed here are keys in the global PHP array
:php:`$GLOBALS['TYPO3_CONF_VARS']['GFX']`.

This variable can be set in one of the following files:

*   :ref:`config/system/settings.php <typo3ConfVars-settings>`
*   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-gfx
    :display: tree
    :type:

..  _typo3ConfVars_gfx_thumbnails:

..  confval:: thumbnails
    :name: globals-typo3-conf-vars-sys-gfx-thumbnails
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails']
    :type: bool
    :Default: true

    Enables the use of thumbnails in the backend interface.

.. _typo3ConfVars_gfx_thumbnails_png:

.. confval:: thumbnails_png
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails_png']
    :name: globals-typo3-conf-vars-sys-gfx-thumbnails_png
    :type: bool
    :Default: true

    If disabled, thumbnails from non-image files will be converted
    to gif, otherwise png (default).

.. _typo3ConfVars_gfx_gif_compress:

..  confval:: gif_compress
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gif_compress']
    :name: globals-typo3-conf-vars-sys-gfx-gif_compress
    :type: bool
    :Default: true

    Enables the use of the
    :php:`\TYPO3\CMS\Core\Imaging\GraphicalFunctionsgifCompress()` workaround
    function for compressing .gif files made with GD or IM, which probably use
    only RLE or no compression at all.

.. _typo3ConfVars_gfx_imagefile_ext:

..  confval:: imagefile_ext
    :name: globals-typo3-conf-vars-sys-gfx-imagefile_ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
    :type: list
    :Default: 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg,webp'

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']

   :type: list
   :Default: 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg'

   Comma-separated list of file extensions perceived as images by TYPO3.
   List should be set to :php:`'gif,png,jpeg,jpg'` if IM is not available.
   Lowercase and no spaces between!

.. _typo3ConfVars_gfx_gdlib:

..  confval:: gdlib
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib']
    :name: globals-typo3-conf-vars-sys-gfx-gdlib
    :type: bool
    :Default: true

    Enables the use of GD.

.. _typo3ConfVars_gfx_gdlib_png:

..  confval:: gdlib_png
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png']
    :name: globals-typo3-conf-vars-sys-gfx-gdlib_png
    :type: bool
    :Default: false

    Enables the use of GD, with PNG only. This means that all items normally
    generated as gif-files will be png-files instead!

..  _typo3ConfVars_gfx_processor_enabled:

..  confval:: processor_enabled
    :name: globals-typo3-conf-vars-sys-gfx-processor_enabled
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_enabled']
    :type: bool
    :Default: true

    Enables the use of Image- or GraphicsMagick.

..  _typo3ConfVars_gfx_processor_path:

..  confval:: processor_path
    :name: globals-typo3-conf-vars-sys-gfx-processor_path
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path']
    :type: text
    :Default: '/usr/bin/'

    Path to the IM tools convert, combine, identify.

..  _typo3ConfVars_gfx_processor:

..  confval:: processor
    :name: globals-typo3-conf-vars-sys-gfx-processor
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor']
    :type: dropdown
    :Default: 'ImageMagick'
    :allowedValues:
       ImageMagick
           Choose ImageMagick for processing images
       GraphicsMagick
           Choose GraphicsMagick for processing images

    Select which external software on the server should process images -
    see also the preset functionality to see what is available.

..  _typo3ConfVars_gfx_processor_effects:

..  confval:: processor_effects
    :name: globals-typo3-conf-vars-sys-gfx-processor_effects
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_effects']
    :type: bool
    :Default: false

    If enabled, apply blur and sharpening in ImageMagick/GraphicsMagick functions

..  _typo3ConfVars_gfx_processor_allowUpscaling:

..  confval:: processor_allowUpscaling
    :name: globals-typo3-conf-vars-sys-gfx-processor_allowUpscaling
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowUpscaling']
    :type: bool
    :Default: true

    If set, images can be scaled up if told so (in
    :php:`\TYPO3\CMS\Core\Imaging\GraphicalFunctions`)

..  _typo3ConfVars_gfx_processor_allowFrameSelection:

..  confval:: processor_allowFrameSelection
    :name: globals-typo3-conf-vars-sys-gfx-processor_allowFrameSelection
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowFrameSelection']
    :type: bool
    :Default: true

    If set, the [x] frame selector is appended to input filenames in
    stdgraphic. This speeds up image processing for PDF files considerably.
    Disable if your image processor or environment cant cope with the
    frame selection.

.. _typo3ConfVars_gfx_processor_allowTemporaryMasksAsPng:

..  confval:: processor_allowTemporaryMasksAsPng
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowTemporaryMasksAsPng']
    :name: globals-typo3-conf-vars-sys-gfx-processor_allowTemporaryMasksAsPng
    :type: bool
    :Default: false

    This should be set if your processor supports using PNGs as masks as this
    is usually faster.

.. index::
   TYPO3_CONF_VARS GFX;
.. _typo3ConfVars_gfx_processor_stripColorProfileByDefault:

..  confval:: processor_stripColorProfileByDefault
    :name: globals-typo3-conf-vars-sys-gfx-processor_stripColorProfileByDefault
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileByDefault']
    :type: bool
    :Default: true

    If set, the processor_stripColorProfileCommand is used with all processor
    image operations by default. See tsRef for setting this parameter explicitly
    for IMAGE generation.

..  _typo3ConfVars_gfx_processor_stripColorProfileCommand:

..  confval:: processor_stripColorProfileCommand
    :name: globals-typo3-conf-vars-sys-gfx-processor_stripColorProfileCommand
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand']
    :type: string

    ..  versionchanged:: 11.5.35/12.4.11
        This string-based configuration option has been superseded by
        :ref:`$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileParameters'] <typo3ConfVars_gfx_processor_stripColorProfileParameters>`
        for `security reasons <https://typo3.org/security/advisory/typo3-core-sa-2024-002>`__.

    This option expected a string of command line parameters. The defined
    parameters had to be shell-escaped beforehand, while the new option
    :ref:`typo3ConfVars_gfx_processor_stripColorProfileParameters` expects
    an array of strings that will be shell-escaped by TYPO3 when used.

    The existing configuration will continue to be supported. Still, it is
    suggested to use the new configuration format, as the Install Tool is
    adapted to allow modification of the new configuration option only:

    ..  code-block:: php

        // Before
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand'] = '+profile \'*\'';

        // After
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileParameters'] = [
            '+profile',
            '*'
        ];

..  _typo3ConfVars_gfx_processor_stripColorProfileParameters:

..  confval:: processor_stripColorProfileParameters
    :name: globals-typo3-conf-vars-sys-gfx-processor_stripColorProfileParameters
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileParameters']
    :type: array of strings
    :Default: :php:`['+profile', '*']`

    ..  versionchanged:: 11.5.35/12.4.11

    Specifies the parameters to strip the profile information, which can reduce
    thumbnail size up to 60KB. Command can differ in IM/GM, IM also knows the
    :bash:`-strip` command. See
    `imagemagick.org <https://legacy.imagemagick.org/Usage/thumbnails/#profiles>`__
    for details.

..  _typo3ConfVars_gfx_processor_colorspace:

..  confval:: processor_colorspace
    :name: globals-typo3-conf-vars-sys-gfx-processor_colorspace
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_colorspace']
    :type: text
    :Default: RGB

    Specifies the colorspace to use. Some ImageMagick versions (like 6.7.0 and
    above) use the sRGB colorspace, so all images are darker then the original.

    Possible Values: CMY, CMYK, Gray, HCL, HSB, HSL, HWB, Lab, LCH, LMS, Log,
    Luv, OHTA, Rec601Luma, Rec601YCbCr, Rec709Luma, Rec709YCbCr, RGB, sRGB,
    Transparent, XYZ, YCbCr, YCC, YIQ, YCbCr, YUV

..  _typo3ConfVars_gfx_processor_interlace:

..  confval:: processor_interlace
    :name: globals-typo3-conf-vars-sys-gfx-processor_interlace
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_interlace']
    :type: text
    :Default: 'None'

    Specifies the interlace option to use. The result differs in different
    GM / IM versions. See manual of GraphicsMagick or ImageMagick for
    right option.

    Possible values: None, Line, Plane, Partition

..  _typo3ConfVars_gfx_jpg_quality:
..  confval:: jpg_quality
    :name: globals-typo3-conf-vars-sys-gfx-jpg_quality
    :Path: $GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality']
    :type: int
    :Default: 85
    :Allowed values: Between 10 (lowest quality) and 100 (highest quality)

    ..  versionadded:: 13.0
        Lowest quality can be "1". Previously the lowest quality setting was "10".

    Default JPEG generation quality
