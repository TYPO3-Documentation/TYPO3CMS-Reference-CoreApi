.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; GFX
   TYPO3_CONF_VARS GFX
.. _typo3ConfVars_gfx:

============================
GFX - graphics configuration
============================

The following configuration variables can be used to configure settings for
the handling of images and graphics:

..  contents::
    :local:

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['GFX']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`


.. index::
   TYPO3_CONF_VARS GFX; thumbnails
.. _typo3ConfVars_gfx_thumbnails:

thumbnails
==========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails']

   :type: bool
   :Default: true

   Enables the use of thumbnails in the backend interface.

.. index::
   TYPO3_CONF_VARS GFX; imagefile_ext
.. _typo3ConfVars_gfx_imagefile_ext:

imagefile_ext
=============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']

   :type: list
   :Default: 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg'

   Comma-separated list of file extensions perceived as images by TYPO3.
   List should be set to :php:`'gif,png,jpeg,jpg'` if IM is not available.
   Lowercase and no spaces between!

.. index::
   TYPO3_CONF_VARS GFX; gdlib
.. _typo3ConfVars_gfx_gdlib:

gdlib
=====

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib']

   :type: bool
   :Default: true

   Enables the use of GD.

.. index::
   TYPO3_CONF_VARS GFX; gdlib_png
.. _typo3ConfVars_gfx_gdlib_png:

gdlib_png
=========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png']

   :type: bool
   :Default: false

   Enables the use of GD, with PNG only. This means that all items normally
   generated as gif-files will be png-files instead!

.. index::
   TYPO3_CONF_VARS GFX;
.. _typo3ConfVars_gfx_processor_enabled:

processor_enabled
=================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_enabled']

   :type: bool
   :Default: true

   Enables the use of Image- or GraphicsMagick.

.. index::
   TYPO3_CONF_VARS GFX; processor_path
.. _typo3ConfVars_gfx_processor_path:

processor_path
==============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path']

   :type: text
   :Default: '/usr/bin/'

   Path to the IM tools convert, combine, identify.

.. index::
   TYPO3_CONF_VARS GFX; processor
.. _typo3ConfVars_gfx_processor:

processor
=========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor']

   :type: dropdown
   :Default: 'ImageMagick'
   :allowedValues:
      ImageMagick
         Choose ImageMagick for processing images
      GraphicsMagick
         Choose GraphicsMagick for processing images

   Select which external software on the server should process images -
   see also the preset functionality to see what is available.

.. index::
   TYPO3_CONF_VARS GFX; processor_effects
.. _typo3ConfVars_gfx_processor_effects:

processor_effects
=================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_effects']

   :type: bool
   :Default: false

   If enabled, apply blur and sharpening in ImageMagick/GraphicMagick functions

.. index::
   TYPO3_CONF_VARS GFX; processor_allowUpscaling
.. _typo3ConfVars_gfx_processor_allowUpscaling:

processor_allowUpscaling
========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowUpscaling']

   :type: bool
   :Default: true

   If set, images can be scaled up if told so (in
   :php:`\TYPO3\CMS\Core\Imaging\GraphicalFunctions`)

.. index::
   TYPO3_CONF_VARS GFX; processor_allowFrameSelection
.. _typo3ConfVars_gfx_processor_allowFrameSelection:

processor_allowFrameSelection
=============================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowFrameSelection']

   :type: bool
   :Default: true

   If set, the [x] frame selector is appended to input filenames in
   stdgraphic. This speeds up image processing for PDF files considerably.
   Disable if your image processor or environment cant cope with the
   frame selection.

.. index::
   TYPO3_CONF_VARS GFX;
.. _typo3ConfVars_gfx_processor_stripColorProfileByDefault:

processor_stripColorProfileByDefault
====================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileByDefault']

   :type: bool
   :Default: true

   If set, the processor_stripColorProfileCommand is used with all processor
   image operations by default. See tsRef for setting this parameter explicitly
   for IMAGE generation.

.. index::
   TYPO3_CONF_VARS GFX; processor_stripColorProfileCommand
.. _typo3ConfVars_gfx_processor_stripColorProfileCommand:

processor_stripColorProfileCommand
==================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand']

   :type: text
   :Default: \+profile \'\*\'

   Specifies the command to strip the profile information, which can reduce
   thumbnail size up to 60KB. Command can differ in IM/GM, IM also know the
   -strip command. See
   `imagemagick.org <https://legacy.imagemagick.org/Usage/thumbnails/#profiles>`__
   for details

.. index::
   TYPO3_CONF_VARS GFX; processor_colorspace
.. _typo3ConfVars_gfx_processor_colorspace:

processor_colorspace
====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_colorspace']

   :type: text
   :Default: RGB

   Specifes the colorspace to use. Some ImageMagick versions (like 6.7.0 and
   above) use the sRGB colorspace, so all images are darker then the original.

   Possible Values: CMY, CMYK, Gray, HCL, HSB, HSL, HWB, Lab, LCH, LMS, Log,
   Luv, OHTA, Rec601Luma, Rec601YCbCr, Rec709Luma, Rec709YCbCr, RGB, sRGB,
   Transparent, XYZ, YCbCr, YCC, YIQ, YCbCr, YUV

.. index::
   TYPO3_CONF_VARS GFX; processor_interlace
.. _typo3ConfVars_gfx_processor_interlace:

processor_interlace
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_interlace']

   :type: text
   :Default: 'None'

   Specifies the interlace option to use. The result differs in different
   GM / IM versions. See manual of GraphicsMagick or ImageMagick for
   right option.

   Possible values: None, Line, Plane, Partition

.. index::
   TYPO3_CONF_VARS GFX; jpg_quality
.. _typo3ConfVars_gfx_jpg_quality:

jpg_quality
===========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality']

   :type: int
   :Default: 85

   Default JPEG generation quality

..  index::
    TYPO3_CONF_VARS GFX; thumbnails_png
..  _typo3ConfVars_gfx_thumbnails_png:

thumbnails_png
==============

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails_png']

    ..  versionchanged:: 13.0
        This setting has been removed. Thumbnails from non-image files (like
        PDF) are always generated as PNG.

..  index::
    TYPO3_CONF_VARS GFX; gif_compress
..  _typo3ConfVars_gfx_gif_compress:

gif_compress
============

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['gif_compress']

    ..  versionchanged:: 13.0
        This setting has been removed.

..  index::
    TYPO3_CONF_VARS GFX; processor_allowTemporaryMasksAsPng
..  _typo3ConfVars_gfx_processor_allowTemporaryMasksAsPng:

processor_allowTemporaryMasksAsPng
==================================

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowTemporaryMasksAsPng']

    ..  versionchanged:: 13.0
        This setting has been removed. Temporarily saved masking images are
        always saved as PNG files rather than GIF images.
