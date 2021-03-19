.. include:: /Includes.rst.txt

.. _fal-concepts:

==============
Basic Concepts
==============

This chapter presents the general concepts underlying the TYPO3 CMS
File Abstraction Layer (FAL). The whole point of FAL - as its name
implies - is to provide information about files abstracted with
regards to their actual nature and storage.

Information about files is stored inside database tables and
using a given file is mostly about creating a database relation
to the record representing that file.


.. _fal-concepts-storages-drivers:


Storages and Drivers
====================

Every file belongs to a storage, which is a very general concept
encompassing any kind of place where a file can be stored: a local
file system, a remote server or a cloud-based resource. Accessing
these different places requires an appropriate driver.

Each storage relies on a driver to provide the user with the
ability to use and manipulate the files that exist in the storage.
By default TYPO3 CMS provides only a local file system driver.

A new TYPO3 CMS installation comes with a predefined storage,
using the local file system driver and pointing to the
:file:`fileadmin/` directory, located in your public folder.
If it's missing/offline after installation you can create it yourself.


.. _fal-concepts-files-metadata:

Files and Metadata
==================

For each available file in all present storages, there exists a
corresponding database record in table "sys\_file", which
contains basic information about the file (name, path, size, etc.),
and an additional record in table "sys\_file\_metadata", designed
to hold a large variety of additional information about the file
(metadata such as title, description, width, height, etc.).

.. tip::

   Although FAL is part of the TYPO3 CMS Core, there is a
   system extension called "filemetadata", which is not installed
   by default. It extends the "sys\_file\_metadata" table with
   fields such as copyright notice, author name, location, etc.


.. _fal-concepts-file-references:

File References
===============

Whenever a file is used - for example an image attached to a
content element - a reference is created in the database
between the file and the content element. This reference can
hold additional information like an alternative title to
use for this file just for this reference.

This central reference table ("sys\_file\_reference") makes
it easy to track every place where a file is used inside a
TYPO3 CMS installation.

All these elements are explored in greater depth in the chapter
about :ref:`FAL components <fal-architecture-components>`.
