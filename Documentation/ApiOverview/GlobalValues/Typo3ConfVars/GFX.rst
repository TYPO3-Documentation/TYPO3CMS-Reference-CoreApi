.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; GFX
   TYPO3_CONF_VARS GFX
.. _typo3ConfVars_gfx:

==================================
$GLOBALS['TYPO3_CONF_VARS']['GFX']
==================================

.. index::
   TYPO3_CONF_VARS GFX; thumbnails
.. _typo3ConfVars_gfx_thumbnails:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails']
================================================

.. confval:: thumbnails
   :type: bool
   :Default: true

   Enables the use of thumbnails in the backend interface.

.. index::
   TYPO3_CONF_VARS GFX; thumbnails_png
.. _typo3ConfVars_gfx_thumbnails_png:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails_png']
====================================================

.. confval:: thumbnails_png
   :type: bool
   :Default: true

   If disabled, thumbnails from non-image files will be converted
   to gif, otherwise png (default).

.. index::
   TYPO3_CONF_VARS GFX; gif_compress
.. _typo3ConfVars_gfx_gif_compress:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['gif_compress']
==================================================

.. confval:: gif_compress
   :type: bool
   :Default: true

   Enables the use of the
   :php:`\TYPO3\CMS\Core\Imaging\GraphicalFunctionsgifCompress()` workaround
   function for compressing .gif files made with GD or IM, which probably use
   only RLE or no compression at all.

.. index::
   TYPO3_CONF_VARS GFX; imagefile_ext
.. _typo3ConfVars_gfx_imagefile_ext:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
===================================================

.. confval:: imagefile_ext
   :type: list
   :Default: 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg'

   Comma-separated list of file extensions perceived as images by TYPO3.
   List should be set to :php:`'gif,png,jpeg,jpg'` if IM is not available.
   Lowercase and no spaces between!

.. index::
   TYPO3_CONF_VARS GFX; gdlib
.. _typo3ConfVars_gfx_gdlib:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib']
===========================================

.. confval:: gdlib
   :type: bool
   :Default: true

   Enables the use of GD.

.. index::
   TYPO3_CONF_VARS GFX; gdlib_png
.. _typo3ConfVars_gfx_gdlib_png:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png']
===============================================

.. confval:: gdlib_png
   :type: bool
   :Default: false

   Enables the use of GD, with PNG only. This means that all items normally
   generated as gif-files will be png-files instead!

.. index::
   TYPO3_CONF_VARS GFX;
.. _typo3ConfVars_gfx_processor_enabled:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_enabled']
=======================================================

.. confval:: processor_enabled
   :type: bool
   :Default: true

   Enables the use of Image- or GraphicsMagick.

.. index::
   TYPO3_CONF_VARS GFX; processor_path
.. _typo3ConfVars_gfx_processor_path:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path']
====================================================

.. confval:: processor_path
   :type: text
   :Default: '/usr/bin/'

   Path to the IM tools convert, combine, identify.

.. index::
   TYPO3_CONF_VARS GFX; processor_path_lzw
.. _typo3ConfVars_gfx_processor_path_lzw:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path_lzw']
========================================================

.. confval:: processor_path_lzw
   :type: text
   :Default: '/usr/bin/'

   Path to the IM tool convert with LZW enabled! See gif_compress.
   If your version 4.2.9 of ImageMagick is compiled with LZW you may leave
   this field blank AND disable the flag gif_compress.

   .. tip::
      You can call LZW convert with a prefix like myver_convert by setting
      this path with it, eg. :php:`'/usr/bin/myver_'` instead of just
      :php:`'/usr/bin/'`.

.. index::
   TYPO3_CONF_VARS GFX; processor
.. _typo3ConfVars_gfx_processor:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor']
===============================================

.. confval:: processor
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

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_effects']
=======================================================

.. confval:: processor_effects
   :type: bool
   :Default: false

   If enabled, apply blur and sharpening in ImageMagick/GraphicMagick functions

.. index::
   TYPO3_CONF_VARS GFX; processor_allowUpscaling
.. _typo3ConfVars_gfx_processor_allowUpscaling:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowUpscaling']
==============================================================

.. confval:: processor_allowUpscaling
   :type: bool
   :Default: true

   If set, images can be scaled up if told so (in
   :php:`\TYPO3\CMS\Core\Imaging\GraphicalFunctions`)

.. index::
   TYPO3_CONF_VARS GFX; processor_allowFrameSelection
.. _typo3ConfVars_gfx_processor_allowFrameSelection:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowFrameSelection']
===================================================================

.. confval:: processor_allowFrameSelection
   :type: bool
   :Default: true

   If set, the [x] frame selector is appended to input filenames in
   stdgraphic. This speeds up image processing for PDF files considerably.
   Disable if your image processor or environment cant cope with the
   frame selection.

.. index::
   TYPO3_CONF_VARS GFX; processor_allowTemporaryMasksAsPng
.. _typo3ConfVars_gfx_processor_allowTemporaryMasksAsPng:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowTemporaryMasksAsPng']
========================================================================

.. confval:: processor_allowTemporaryMasksAsPng
   :type: bool
   :Default: false

   This should be set if your processor supports using PNGs as masks as this
   is usually faster.

.. index::
   TYPO3_CONF_VARS GFX;
.. _typo3ConfVars_gfx_processor_stripColorProfileByDefault:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileByDefault']
==========================================================================

.. confval:: processor_stripColorProfileByDefault
   :type: bool
   :Default: true

   If set, the processor_stripColorProfileCommand is used with all processor
   image operations by default. See tsRef for setting this parameter explicitly
   for IMAGE generation.

.. index::
   TYPO3_CONF_VARS GFX; processor_stripColorProfileCommand
.. _typo3ConfVars_gfx_processor_stripColorProfileCommand:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand']
========================================================================

.. confval:: processor_stripColorProfileCommand
   :type: text
   :Default: \+profile \'\*\'

   Specifies the command to strip the profile information, which can reduce
   thumbnail size up to 60KB. Command can differ in IM/GM, IM also know the
   -strip command. See
   `imagemagick.org<http//www.imagemagick.org/Usage/thumbnails/#profiles>`__
   for details

.. index::
   TYPO3_CONF_VARS GFX; processor_colorspace
.. _typo3ConfVars_gfx_processor_colorspace:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_colorspace']
==========================================================

.. confval:: processor_colorspace
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

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_interlace']
=========================================================

.. confval:: processor_interlace
   :type: text
   :Default: 'None'

   Specifies the interlace option to use. The result differs in different
   GM / IM versions. See manual of GraphicsMagick or ImageMagick for
   right option.

   Possible values: None, Line, Plane, Partition

.. index::
   TYPO3_CONF_VARS GFX; jpg_quality
.. _typo3ConfVars_gfx_jpg_quality:

$GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality']
=================================================

.. confval:: jpg_quality
   :type: int
   :Default: 85

   Default JPEG generation quality
