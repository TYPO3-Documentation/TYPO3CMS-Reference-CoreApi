..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Concepts
..  _fal-concepts:

==============
Basic concepts
==============

This chapter presents the general concepts underlying the TYPO3
file abstraction layer (FAL). The whole point of FAL - as its name
implies - is to provide information about files abstracted with
regards to their actual nature and storage.

Information about files is stored inside database tables and
using a given file is mostly about creating a database relation
to the record representing that file.


..  index:: File abstraction layer; Storage
..  _fal-concepts-storages-drivers:

Storages and drivers
====================

Every file belongs to a storage, which is a very general concept
encompassing any kind of place where a file can be stored: a local
file system, a remote server or a cloud-based resource. Accessing
these different places requires an appropriate driver.

Each storage relies on a driver to provide the user with the
ability to use and manipulate the files that exist in the storage.
By default, TYPO3 provides only a local file system driver.

A new TYPO3 installation comes with a predefined storage,
using the local file system driver and pointing to the
:file:`fileadmin/` directory, located in your public folder.
If it is missing or offline after installation, you can create it yourself.


..  index:: File abstraction layer; Metadata
..  _fal-concepts-files-metadata:

Files and metadata
==================

For each available file in all present storages, there exists a
corresponding database record in the table :sql:`sys_file`, which
contains basic information about the file (name, path, size, etc.),
and an additional record in the table :sql:`sys_file_metadata`, designed
to hold a large variety of additional information about the file
(metadata such as title, description, width, height, etc.).

..  tip::
    Although FAL is part of the TYPO3 Core, there is a
    system extension called `filemetadata`_, which is not installed
    by default. It extends the :sql:`sys_file_metadata` table with
    fields such as copyright notice, author name, location, etc.

..  _filemetadata: https://packagist.org/packages/typo3/cms-filemetadata

..  index:: File abstraction layer; File references
..  _fal-concepts-file-references:

File references
===============

Whenever a file is used - for example, an image attached to a
content element - a reference is created in the database
between the file and the content element. This reference can
hold additional information like an alternative title to
use for this file just for this reference.

This central reference table (:sql:`sys_file_reference`) makes
it easy to track every place where a file is used inside a
TYPO3 installation.

All these elements are explored in greater depth in the chapter
about :ref:`FAL components <fal-architecture-components>`.
