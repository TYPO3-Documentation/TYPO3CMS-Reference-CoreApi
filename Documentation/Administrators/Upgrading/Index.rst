
.. include:: ../../Includes.txt

.. _Administrators-Upgrading:

================
Upgrading to FAL
================

What needs to be considered when you're upgrading from a 4.x TYPO3 version
to FAL?


.. _admin-changes:

Migration Steps
===============

When a pre-FAL installation is migrated to FAL, these are the steps
that need to be done. This is what the TYPO3 6.2 upgrade wizard does
((may need verification)):

-  File mounts in the :ref:`DB-table-sys_filemounts` table are migrated.
   See :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\FilemountUpdateWizard`

-  For every mount point with an absolute path, a new :ref:`DB-table-sys_file_storage` record
   is created with has the absolute path as base path.

-  For every mount point, the `sys_file_mount` record is converted to
   a new structure where mounts act as "filters" on storages which can
   be assigned to users

-  A new "storage" record is created by the upgrade wizard which mounts
   the "fileadmin/" directory in your installation

-  The media and image fields of the content (tt_content) and pages (pages)
   tables are changed to use proper FAL relations.
   This means:

   -  Each image is **moved** to the fileadmin directory.

   -  For each new file in fileadmin/, a :ref:`DB-table-sys_file` record is
      created. This entry is also called the "index record".

   -  If the same image but with a different name is encountered it is **NOT**
      move to fileadmin. Instead the first image is used again.

   -  For each usage of the file from a content element (table "tt_content"),
      a relation record has been created in table :ref:`DB-table-sys_file_reference`
      which relates the content record to the index record table :ref:`DB-table-sys_file`.
      This also includes overlays from the content element for the image title, description and
      alternative text, plus the file links.

-  Extensions need to be made compatible. They will still worked as long as the
   backwards-compatibility layer was active. But this layer was just a transitional
   tool and has been removed in TYPO3 version 7.


.. attention::

   The TYPO3 6.2 upgrade wizards only migrate standard TYPO3 tables.
   See

   -  :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\TceformsUpdateWizard`
   -  :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\FilemountUpdateWizard`
   -  :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\RteFileLinksUpdateWizard`
   -  :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\RteMagicImagesUpdateWizard`




.. _admin-compatibility:

Extension compatibility
=======================

Generally, all extensions which just use files in a frontend extension
or have database records with files attached to them should continue to
work without any adaption.

.. note::

   DAM does not work with FAL currently, and FAL will not support using
   the DAM; instead, FAL provides an alternative. Extensions which depend
   on DAM need manual adaption, see the developers section for more details.

However, if you want to support FAL "the right way" and not just by
means of the backwards compatibility layer, the extensions should be
updated to make use of the API as outlined in the developers
documentation.


Tips and tricks
---------------

.. tip::

   Add your specific tables and fields to the parameter array
   in the update wizard of TYPO3 6.2 and make the install tool
   migrated your custom file fields as well!

You can make the 6.2 update wizard migrate your custom fields of type
'file' as well.

1. Check the code at :ref:`t3api62:TYPO3\\CMS\\Install\\Updates\\TceformsUpdateWizard`

2. Add your own tables and fields to the configuration array::

      /**
       * Table fields to migrate
       * @var array
       */
      protected $tables = array(
         // ...
         'pages' => array(
            'media' => array(
               'sourcePath' => 'uploads/media/',
               // Relative to fileadmin
               'targetPath' => '_migrated/media/'
            )
         ),
         'tx_myextension_abc' => array(
            'my_image_field' => array(
               'sourcePath' => 'uploads/tx_myextension/',
               'targetPath' => '_migrated/tx_myextension/'
            )
        ),
        // ...
      );

3. Run the update wizard in the install tool as usual.



.. _admin-remote-storages:

Using Remote Storages
=====================

To use a remote storage, you have to do two things:

1. Install a driver extension for the remote system (e.g. WebDAV)

   Drivers are shipped in normal TYPO3 extensions and can be found on
   the TYPO3 Extension Repository. One example driver is the "WebDAV"
   driver (https://forge.typo3.org/projects/extension-fal_webdav), but
   it is also possible to program a custom driver which could e.g.
   connect to a cloud storage like Amazon S3 or similar.

   Once the driver extension is installed, you can proceed to the next step.

2. Create a new Storage record for the remote storage

   When you create the Storage record for the remote Storage, you are
   asked for more details on the connection to the remote Storage such
   as authentification credentials (if necessary) and server URLs. Once
   the Storage is configured, its data should be shown in the
   File > Filelist module just like files from a local storage.


.. _admin-indexing:

Indexing
========

TODO: Write.

* fine-tuning
* cron-automation
* housekeeping


.. _admin-faq:

Frequently Asked Questions (FAQ)
================================

What happened to the TCEForms "group" field with internal_type "file"?
  It's still working in the same way it used to work, copying files to
  the uploads/ folder for maximum backwards compatibility.
  However, it is adviced to adopt extensions to use FAL natively as the
  field type is now deprecated.

What happened to the typo3temp/ folder?
  The typo3temp/ folder is no longer used for files that are used in
  your site's content. Instead, a configurable temporary directory per
  storage (the "processing folder") replaces that concept.
  Temporary files are now called "processedFiles" and are tracked in
  the database table ``sys_file_processedfile``.

