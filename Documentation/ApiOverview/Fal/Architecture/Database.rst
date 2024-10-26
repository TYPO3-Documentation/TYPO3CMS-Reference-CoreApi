..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Database structure
..  _fal-architecture-database:

==================
Database structure
==================

This chapter lists the various tables related to the file abstraction layer
(FAL) and highlights some of their important fields.

..  contents::
    :local:


..  index:: Tables; sys_file
..  _fal-architecture-database-sys-file:

:sql:`sys_file`
===============

This table is used to store basic information about each file.
Some important fields:

:sql:`storage`
    ID of the storage where the file is stored.

:sql:`type`
    The type of the file represented by an integer defined by an enum
    :php:`\TYPO3\CMS\Core\Resource\FileType` value.

    See :ref:`globals-constants-file-types` for more details.

:sql:`identifier`
    A string which should uniquely identify a file within its
    :ref:`storage <fal-architecture-components-storage>`.
    Duplicate identifiers are possible, but will create a confusion.
    For the local file system :ref:`driver <fal-architecture-components-drivers>`,
    the identifier is the path to the file, relative to the storage root
    (starting with a slash and using a slash as directory delimiter).

:sql:`name`
    The name of the file. For the local file system driver, this will be
    the current name of the file in the file system.

:sql:`sha1`
    A hash of the file's content. This is used to detect whether a file
    has changed or not.

:sql:`metadata`
    Foreign side of the :ref:`sys_file_metadata <fal-architecture-database-sys-file-metadata>`
    relation. Always :sql:`0` in the database, but necessary for the
    :ref:`TCA <t3tca:start>` of the :sql:`sys_file` table.


.. caution::
   .. versionchanged:: 13.0.1/12.4.11/11.5.35
   Modifying the :sql:`sys_file` table using DataHandler is blocked since TYPO3
   version 11.5.35, 12.4.11, and 13.0.1. The table
   should not be extended and additional fields should be added to
   :sql:`sys_file_metadata`. See `security advisory TYPO3-CORE-SA-2024-006 <https://typo3.org/security/advisory/typo3-core-sa-2024-006>`__
   for more information.


..  index:: Tables; sys_file_metadata
..  _fal-architecture-database-sys-file-metadata:

:sql:`sys_file_metadata`
========================

This table is used to store metadata about each file. It has a one-to-one
relationship with table :ref:`sys_file <fal-architecture-database-sys-file>`.
Contrary to the basic information stored in :sql:`sys_file`, the content of the
table :sql:`sys_file_metadata` can be translated.

Most fields are really just additional information. The most
important one is:

:sql:`file`
    ID of the :sql:`sys_file` record of the file the metadata is related to.

The :sql:`sys_file_metadata` table is extended by the system extension
`filemetadata`_. In particular, it adds the necessary definitions
to categorize files with :ref:`system categories <categories>`.

Also some other helpful metadata attributes are provided (and some of them
can be automatically inferred from the file). Most of these attributes
are self-explanatory; this list may not reflect the most recent TYPO3
version, so it is recommended to inspect the actual TCA configuration
of that table:

*  :sql:`caption`
*  :sql:`color_space`
*  :sql:`content_creation_date` - Refers to when the contents of the file were created (retrievable for images through EXIF metadata)
*  :sql:`content_modification_date`
*  :sql:`copyright`
*  :sql:`creator`
*  :sql:`creator_tool` - Name of a tool that was used to create the file (for example for auto-generated files)
*  :sql:`download_name` - An alternate name of a file when being downloaded (to protect actual file name security relevance)
*  :sql:`duration` - length of audio/video files, or "reading time"
*  :sql:`height`
*  :sql:`keywords`
*  :sql:`language` - file content language
*  :sql:`latitude`
*  :sql:`location_city`
*  :sql:`location_country`
*  :sql:`location_region`
*  :sql:`longitude`
*  :sql:`note`
*  :sql:`pages` - Related pages
*  :sql:`publisher`
*  :sql:`ranking` - Information on prioritizing files (like "star ratings")
*  :sql:`source` - Where a file was fetched from (for example from libraries, clients, remote storage, ...)
*  :sql:`status` - indicate whether a file may need metadata update based on differences between locally cached metadata and remote/actual file metadata
*  :sql:`unit` - measurement units
*  :sql:`visible`
*  :sql:`width`

..  _filemetadata: https://packagist.org/packages/typo3/cms-filemetadata


..  index:: Tables; sys_file_reference
..  _fal-architecture-database-sys-file-reference:

:sql:`sys_file_reference`
=========================

This table is used to store all references between files and
whatever other records they are used in, typically pages and
content elements. The most important fields are:

:sql:`uid_local`
    ID of the file.

:sql:`uid_foreign`
    ID of the related record.

:sql:`tablenames`
    Name of the table containing the related record.

:sql:`fieldname`
    Name of the field of the related record where the relation was created.

:sql:`title`
    When a file is referenced, normally its title is used (for
    whatever purpose, like displaying a caption for example). However it is
    possible to define a title in the reference, which will be used instead
    of the original file's title.

    The fields :sql:`description`, :sql:`alternative` and :sql:`downloadname`
    obey the same principle.


..  index:: Tables; sys_file_processedfile
..  _fal-architecture-database-sys-file-processedfile:

:sql:`sys_file_processedfile`
=============================

This table is similar to :ref:`sys_file <fal-architecture-database-sys-file>`,
but for "temporary" files, like image previews. This table does not have a
:ref:`TCA <t3tca:start>` representation, as it is only written for using
direct SQL queries in the source code.


..  index:: Tables; sys_file_collection
..  _fal-architecture-database-sys-file-collection:

:sql:`sys_file_collection`
==========================

..  versionchanged:: 12.2
    The two fields :sql:`storage` and :sql:`folder` are now combined into the
    new field :sql:`folder_identifier`.

FAL offers the possibility to create file collections,
which can then be used for various purposes. By default,
they can be used with the "File links" content element.

The most important fields are:

:sql:`type`
    The type of the collection. A collection can be based on hand-picked files,
    a folder or categories.

:sql:`files`
    The list of selected files. The relationship between files and their collection
    is also stored in :ref:`sys_file_reference <fal-architecture-database-sys-file-reference>`.

:sql:`folder_identifier`
    The field contains the so-called "combined identifier" in the format
    `storage:folder`, where "storage" is the :sql:`uid` of the corresponding
    :sql:`sys_file_storage` record and :sql:`folder` the absolute path to the
    folder. An example for a combined identifier is `1:/user_upload`.

:sql:`category`
    The chosen categories, for category-type :ref:`collections <collections-files>`.


..  index:: Tables; sys_file_storage
..  _fal-architecture-database-sys-file-storage:

:sql:`sys_file_storage`
=======================

This table is used to store the storages available in the installation.
The most important fields are:

:sql:`driver`
    The type of :ref:`driver <fal-architecture-components-drivers>` used for the
    :ref:`storage <fal-architecture-components-storage>`.

:sql:`configuration`
    The storage configuration with regards to its driver. This is a
    :ref:`FlexForm field <t3tca:columns-flex>` and the current options
    depend on the selected driver.


..  index:: Tables; sys_filemounts
..  _fal-architecture-database-sys-filemounts:

:sql:`sys_filemounts`
=====================

.. versionchanged:: 12.0

File mounts are not specifically part of FAL (they existed long
before), but their definition is based on
:ref:`storages <fal-architecture-components-storage>`. Each file mount is
related to a specific storage. The most important field is:

:sql:`identifier`
    The identifier in the format `base:path`, where `base` is the storage ID and
    `path` the path to the folder, for example `1:/user_upload`.
