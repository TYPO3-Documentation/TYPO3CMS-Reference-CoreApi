..  include:: /Includes.rst.txt
..  index:: File processors
..  _file-processing:

======================
Custom file processors
======================

For custom needs in terms of file processing, registration of custom file processors is available.


..  _file-processing-create:

Create a new processor class
============================

The file must implement the :php:`\TYPO3\CMS\Core\Resource\Processing\ProcessorInterface` and two required methods.

:php:`canProcessTask()`
   Will decide whether the given file should be handled at all. The expected return type is boolean.

:php:`processTask()`
   Will then do whatever needs to be done to process the given file.


..  _file-processing-register:

Register the file processor
===========================

To register a new processor, add the following code to :file:`ext_localconf.php`

..  literalinclude:: _ext_localconf.php
    :caption: EXT:my_extension/ext_localconf.php

With the `before` and `after` options, priority can be defined.

..  note::

    Only one file processor will handle any given file. Once the first match for :php:`canProcessTask()` has been found, this is the
    processor that will handle the file. There is no cascading or sequence possible, so make sure your processor does all the work
    necessary.


..  _file-processing-system-resources:

Processing system resources from `EXT:` and `PKG:`
==================================================

..  versionchanged:: 15.0
    :changelog: breaking-110702-1789915156

    The processing pipeline also processes system resources. Before, an image
    from an extension was processed through a FAL compatibility storage.

The processing pipeline also scales and crops images that an extension or a
package ships, referenced as `EXT:` or `PKG:` system resource. For such a task
:php-short:`\TYPO3\CMS\Core\Resource\Processing\TaskInterface::getSourceFile()`
returns a
:php-short:`\TYPO3\CMS\Core\SystemResource\Type\SystemResourceInterface`
that is not a FAL :php-short:`\TYPO3\CMS\Core\Resource\File`. The result is
not stored in the database or in a :file:`_processed_/` folder. See
`Processed files <https://docs.typo3.org/permalink/t3coreapi:fal-architecture-folders-processed-files>`_.

A processor receives such a task only if it implements the marker interface
:php-short:`\TYPO3\CMS\Core\Resource\Processing\ResourceAwareProcessorInterface`.
The Core processors
:php-short:`\TYPO3\CMS\Core\Resource\Processing\LocalImageProcessor` and
:php-short:`\TYPO3\CMS\Core\Resource\Processing\SvgImageProcessor`
implement it for the task type `Image.CropScaleMask`. A subclass of these
processors inherits the interface. If the subclass uses methods that only a FAL
file has, it must decline other sources in :php:`canProcessTask()`.

..  _file-processing-system-resources-example:

Example: Process only FAL files in a subclass of `LocalImageProcessor`
----------------------------------------------------------------------

The processor declines a task if the source is not a FAL file. The Core
processors then handle the system resources.

..  literalinclude:: _FalOnlyImageProcessor.php
    :caption: EXT:my_extension/Classes/Resource/Processing/FalOnlyImageProcessor.php
