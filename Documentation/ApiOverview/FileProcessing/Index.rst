.. include:: /Includes.rst.txt
.. index:: File processors
.. _file_processing:

======================
Custom file processors
======================

For custom needs in terms of file processing, registration of custom file processors is available.

.. _file_processing-create:

Create a new processor class
============================

The file must implement the :php:`\TYPO3\CMS\Core\Resource\Processing\ProcessorInterface` and two required methods.

:php:`canProcessTask()`
   Will decide whether the given file should be handled at all. The expected return type is boolean.

:php:`processTask()`
   Will then do whatever needs to be done to process the given file.

.. _file_processing-register:

Register the file processor
============================

To register a new processor, add the following code to :file:`ext_localconf.php`

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['processors']['MyNewImageProcessor'] = [
       'className' => \Vendor\ExtensionName\Resource\Processing\MyNewImageProcessor::class,
       'before' => ['LocalImageProcessor'],
   ];

With the `before` and `after` options, priority can be defined.

.. note::

   Only one file processor will handle any given file. Once the first match for :php:`canProcessTask()` has been found, this is the
   processor that will handle the file. There is no cascading or sequence possible, so make sure your processor does all the work
   necessary.
