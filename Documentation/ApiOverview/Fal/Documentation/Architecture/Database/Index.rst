.. include:: ../../Includes.txt


.. _Database-Structure:
.. _architecture-database:

Database structure
^^^^^^^^^^^^^^^^^^

This chapter lists the various tables related to FAL
and highlights some of their important fields.


.. _DB-table-sys_file:
.. _architecture-database-sys-file:

sys\_file
"""""""""

This table is used to store basic information about each file.
Some important fields:

storage
  Id of the storage where the file is stored.

identifier
  A string which should uniquely identify a file within its storage.
  Duplicate identifiers are possible, but will create a confusion.
  For the local file system driver, the identifier is the path to the
  file, relative to the storage root (starting with a slash and using 
  a slash as directory delimiter).

name
  The name of the file. For the local file system driver, this will be
  the current name of the file in the file system.

sha1
  A hash of the file's content. This is used to detect whether a file
  has changed or not.

metadata
  Foreign side of the "sys\_file\_metadata" relation. Always "0" in the
  database, but necessary for the TCA of the "sys\_file".


.. _DB-table-sys_metadata:
.. _architecture-database-sys-file-metadata:

sys\_file\_metadata
"""""""""""""""""""

This table is used to store metadata about each file. It has a
one-to-one relationship with table "sys\_file". Contrary to the
basic information stored in "sys\_file", the content of the table
"sys\_file\_metadata" can be translated.

Most fields are really just additional information. The most
important one is:

file
  Id of the sys_file record of the file the metadata is related to.

The "sys\_file\_metadata" table is extended by system extension
"filemetadata". In particular, it adds the necessary definitions
to categorize files with system categories.


.. _DB-table-sys_file_reference:
.. _architecture-database-sys-file-reference:

sys\_file\_reference
""""""""""""""""""""

This table is used to store all references between files and
whatever other records they are used in, typically pages and
content elements. The most important fields are:

uid_local
  Id of the file.

uid_foreign
  Id of the related record.

tablenames
  Name of the table containing the related record.

fieldname
  Name of the field of the related record where the relation was created.

table_local
  Always "sys\_file".

title
  When a file is referenced, normally its title is used (for
  whatever purpose, like displaying a caption for example). However it is
  possible to define a title in the reference, which will be used instead
  of the original file's title.

  The fields "description", "alternative" and "downloadname" obey the same principle.


.. _DB-table-sys_file_processedfile:
.. _architecture-database-sys-file-processedfile:

sys\_file\_processedfile
""""""""""""""""""""""""

This table is similar to "sys\_file", but for "temporary" files,
like image previews. This table does not have a TCA representation,
as it is only written for using direct SQL queries in the source code.


.. _DB-table-sys_file_collection:
.. _architecture-database-sys-file-collection:

sys\_file\_collection
"""""""""""""""""""""

FAL offers the possibility to create File Collections,
which can then be used for various purposes. By default,
they can be used with the "File links" content element.

The most important fields are:

type
  The type of the Collection. A Collection can be based on hand-picked files,
  a folder or categories.

files
  The list of selected files. The relationship between files and their Collection
  is also stored in "sys\_file\_reference".

storage
  The chosen storage, for folder-type Collections.

folder
  The chosen folder, for folder-type Collections.

category
  The chosen categories, for category-type Collections.


.. _DB-table-sys_file_storage:
.. _architecture-database-sys-file-storage:

sys\_file\_storage
""""""""""""""""""

This table is used to store the Storages available in the installation.
The most important fields are:

driver
  The type of Driver used for the storage.

configuration
  The Storage configuration with regards to its Driver. This is a
  :ref:`FlexForm field <t3tca:columns-flex>` and the current options
  depend on the selected Driver.


.. _DB-table-sys_filemounts:
.. _architecture-database-sys-filemounts:

sys\_filemounts
"""""""""""""""

File Mounts are not specifically part of the FAL (they existed long
before), but their definition is based on Storages. Each File Mount is
related to a specific storage. The most important fields are:

base
  Id of the storage the File Mount is related to.

path
  Folder which will actually be mounted (absolute path, considering
  that :file:`/` is the root of the selected Storage).

