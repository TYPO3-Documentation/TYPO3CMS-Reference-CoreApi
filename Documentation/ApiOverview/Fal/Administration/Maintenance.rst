..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Maintenance
..  _fal-administration-maintenance:

===========
Maintenance
===========

There are various maintenance tasks which can be performed
to maintain a healthy TYPO3 installation with the
file abstraction layer.


..  index:: pair: File abstraction layer; Scheduler
..  _fal-administration-maintenance-scheduler:

Scheduler tasks
===============

Two base tasks provided by the :doc:`scheduler <ext_scheduler:Index>` are
related to the file abstraction layer.

File abstraction layer: Update storage index
    This task goes through a :ref:`storage <fal-architecture-components-storage>`
    and makes sure that each file is properly indexed. If files are only
    manipulated via the TYPO3 backend, they are always indexed. However, if
    files are added by other means (for example, FTP), or if some storages are
    based on :ref:`drivers <fal-architecture-components-drivers>` accessing
    remote systems, it is essential to run this task regularly so that the TYPO3
    installation knows about all the existing files and can make them available
    to users.

    This task is defined per storage.

File abstraction layer: Extract metadata in storage
    This task goes through all files in a
    :ref:`storage <fal-architecture-components-storage>` and updates their
    metadata. Again, this is especially important when files can be manipulated
    by other means or actually reside on external systems.

    This task is defined per storage.


..  index::
    File abstraction layer; Processed files
    Folder; fileadmin/_processed_
    Folder; _processed_
    Maintenance tool; Remove Temporary Assets
..  _fal-administration-maintenance-processed-files:

Processed files
===============

If you change some graphics-related settings, it may be necessary
to force a regeneration of all processed files. This can be achieved
by deleting all existing processed files in
:guilabel:`System > Maintenance > Remove Temporary Assets`.

.. include:: /Images/AutomaticScreenshots/AdminTools/MaintenanceRemoveTemporaryAssets.rst.txt

Here you can choose to delete all files in :file:`fileadmin/_processed_/`

This cleanup is also a good idea if you have been accumulating files for a long
time. Many of them may be obsolete.

..  attention::
    If you delete processed files, you should flush the page cache immediately
    afterwards. If pages are cached and the page uses processed images, these
    will not be regenerated on the fly when a page is loaded. Ideally, make sure
    the removal of the processed files and flushing of page cache is one atomic
    operation which is performed as quickly as possible.

After flushing page cache, it is a good idea to warmup the page cache. Generating
the pages for the first time may take longer than usual because the processed
files need to be regenerated. There is currently no Core functionality to warmup
the page cache for all pages, but there are a number of extensions which
provide this functionality. Alternatively, one can use the sitemap and a tool
such as wget for this.

Also, deleting processed files while editors are active is not ideal.
Preferably, lock the TYPO3 backend before you remove the processed files.
