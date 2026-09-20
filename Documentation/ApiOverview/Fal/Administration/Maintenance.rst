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

The :composer:`typo3/cms-scheduler` system extension provides two main tasks
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

..  figure:: /Images/ManualScreenshots/AdminTools/MaintenanceRemoveTemporaryAssets.png
    :zoom: lightbox

    Removing all processed files in the Maintenance Tool

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

..  index::
    File abstraction layer; cleanup:localprocessedfiles
    Command; cleanup:localprocessedfiles
..  _fal-administration-maintenance-processed-files-cli:

Cleaning up processed files on the command line
-----------------------------------------------

The console command `vendor/bin/typo3 cleanup:localprocessedfiles
<https://docs.typo3.org/permalink/t3coreapi:console-command-cleanup-localprocessedfiles>`_
from system extension :composer:`typo3/cms-lowlevel` removes processed files
that are no longer needed from local storage (`Local` driver rather than cloud
storage). It deletes

*   files in the processing folders that are not referred to by any
    :sql:`sys_file_processedfile` records, and
*   :sql:`sys_file_processedfile` records where the processed file no longer
    exists.

Show which files and records the command would delete, without deleting them:

..  tabs::

    ..  group-tab:: Composer mode

        ..  code-block:: bash

            vendor/bin/typo3 cleanup:localprocessedfiles --dry-run -v

    ..  group-tab:: Classic mode

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cleanup:localprocessedfiles --dry-run -v

The command asks for confirmation before deletion. Option `-f`
(`--force`) skips confirmation, as does running the command without
interaction, for example when running it as a
:ref:`scheduler task <symfony-console-commands-scheduler>` for regular cleanup.

Option `--all` deletes processed files in all storage and all the associated
records, including those still in use. TYPO3 then recreates the processed files,
which is useful, for example, if a new file processor has been added. Flush
the page cache afterwards, as described above.
