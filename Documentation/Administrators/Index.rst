.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin:

Admin Documentation
-------------------

This chapter explains what admins need to know when working with files
and TYPO3. In particular it explains what to note when upgrading an
older version of TYPO3 to TYPO3 6.0 and thereby make the switch to FAL.

In case you're interested in the inner workings of FAL, you can also
have a look at the
:ref:`architecture overview <architecture-overview>`.


.. _admin-changes:

Necessary changes
"""""""""""""""""

When a pre-FAL installation is migrated to FAL, this is what needs to
be changed (see next chapter about the tools that help you achieve
that):

* File mounts in the sys_filemounts table need to be migrated
* For every mount point with an absolute path, a new storage is created
  with the absolute path as base path
* For every mount point, the ``sys_file_mount`` record is converted to
  a new structure where mounts act as "filters" on storages which can
  be assigned to users

* A new "Storage" record is created by the upgrade wizard which mounts
  the "fileadmin/" directory in your installation.

* The media and image fields of the Content and Pages tables have been
  changed to use proper FAL relations -- technically speaking the images
  have been copied to the fileadmin directory and proper relations were
  created. This means that:

  * For each new file in fileadmin/, a ``sys_file`` record has been
    created (also called the "index record")
  * For each usage of the file from a content element (table
    ``tt_content``), a relation record has been created (table
    ``sys_file_reference``) which relates the content record to the
    index record (table ``sys_file``). This also includes overlays
    from the content element for the image title, description and
    alternative text, plus the file links

* extensions have to be made compatible (they will still work with the
  backwards-compatibility layer, but this layer is just a transitional
  tool and will be removed in the future)



.. _admin-compatibility:

Extension compatibility
"""""""""""""""""""""""

Generally, all extensions which just use files in a frontend extension
or have database records with files attached to them should continue to
work without any adaption.

.. note::
  DAM does not work with FAL currently, and FAL will not support using
  the DAM; instead, FAL provides a . Extensions which depend on DAM
  need manual adaption, see the developers section for more details.

However, if you want to support FAL "the right way" and not just by
means of the backwards compatibility layer, the extensions should be
updated to make use of the API as outlined in the developers
documentation.


.. _admin-remote-storages:

Using Remote Storages
"""""""""""""""""""""

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
""""""""

TODO: Write.

* fine-tuning
* cron-automation
* housekeeping


.. _admin-faq:

Frequently Asked Questions (FAQ)
""""""""""""""""""""""""""""""""

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


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Introduction/Index
   Permissions/Index
