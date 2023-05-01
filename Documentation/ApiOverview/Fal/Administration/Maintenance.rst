.. include:: /Includes.rst.txt
.. index:: File abstraction layer; Maintenance
.. _fal-administration-maintenance:

===========
Maintenance
===========

There are various maintenance tasks which can be performed
to maintain a healthy TYPO3 installation with the
file abstraction layer.


.. index:: pair: File abstraction layer; Scheduler
.. _fal-administration-maintenance-scheduler:

Scheduler tasks
===============

Two base tasks provided by the Scheduler are related to the
file abstraction layer.

File abstraction layer: Update storage index
  This task goes through a storage and makes sures that every file
  is properly indexed. When files are manipulated only via the TYPO3
  backend, they are always indexed. However if files get added via other
  means (e.g. FTP) or if some storages are based on drivers accessing
  remote systems, it is crucial to run this task regularly so that
  the TYPO3 installation knows about all existing files in order
  to make them available to users.

  This task is defined per storage.

File abstraction layer: Extract metadata in storage
  This task goes through all files in a storage and updates their
  metadata. Again this is especially important when files can be
  manipulated by other means or actually reside on external systems.

  This task is defined per storage.


.. index::
   File abstraction layer; Processed files
   Folder; fileadmin/_processed_
   Folder; _processed_
   Maintenance tool; Remove Temporary Assets
.. _fal-administration-maintenance-processed-files:

Processed files
===============

If you change some graphics-related settings, it may be necessary
to force a regeneration of all processed files. This can be achieved
by deleting all existing processed files in
:guilabel:`Admin Tools > Maintenance > Remove Temporary Assets`.

.. include:: /Images/AutomaticScreenshots/AdminTools/MaintenanceRemoveTemporaryAssets.rst.txt

Here you can choose to delete all files in :file:`fileadmin/_processed_/`

This cleanup is also good if processed files have accumulated for a
long time. Many of them may then be obsolete.

.. attention::

    If you delete processed files, you should flush the (page) cache immediately
    afterwards. If pages are cached and the page uses processed images, these
    will not be regenerated on the fly when a page is loaded. Ideally, make sure
    the removal of the processed files and flushing of page cache is one atomic
    operation which is performed as quickly as possible.

Also, deleting processed files while editors are active is not ideal.
Preferably, lock the TYPO3 Backend before you remove the processed files.

See also the next section in case you have many processed files and removal
would take long (e.g. several minutes).

Bulk removal of processed files
-------------------------------

This entire section is a "use at your own risk" hint.

In general, processed files should be removed in one atomic operation. The page
cache should be flushed after removing processed files.

Removing processed files may take long if there are many. As a shortcut, you may
remove all at once, but always be sure to consider the database table
(sys_file_processedfiles) **and** the files on the filesystem (e.g.
file:`fileadmin/_processed_`).

TYPO3 uses storage 0 as default storage if files are not found in one of
the configured storages. You may want to check if you have any processed
files with storage=0 and where they are located before you begin. It is
recommended to use TYPO3 functionality only when handling processed files in
storage 0.

.. code-block:: mysql
    :caption: MySQL (or compatible) command for checking for processed files in storage 0

    SELECT storage,identifier FROM sys_file_processedfile WHERE storage=0;

See the original paths of the files as well:

.. code-block:: mysql
    :caption: MySQL command for showing file identifier for processed files in storage 0

    SELECT p.storage,p.identifier,p.original,f.identifier FROM sys_file_processedfile p LEFT OUTER JOIN sys_file f ON p.original=f.uid WHERE p.storage=0;

In order to remove the files, do this for each storage (sys_file_storage):

.. code-block:: shell
    :caption: command line: Move away processed files

    # moving the directory may be much faster than removing individual files
    #   unless on different mount points
    # do not move the processed files into any managed filesystem (e.g. in
    #   fileadmin) because the would be scanned as well.
    mv fileadmin/_processed_ /var/tmp/fileadmin_processed.bak

For the SQL command, consider the storage here as well, in case you have several
storages and want to perform the task individually for each storage.

.. code-block:: mysql
    :caption: MySQL (or compatible) command for removing processed files in storage 1

    DELETE FROM sys_file_processedfile WHERE storage=1;

Alternatively, use truncate to delete all processed files in all storages.

.. code-block:: mysql
    :caption: MySQL (or compatible) command for removing all processed files

    TRUNCATE sys_file_processedfile;

