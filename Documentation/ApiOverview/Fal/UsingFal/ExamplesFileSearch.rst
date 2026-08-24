..  include:: /Includes.rst.txt

..  _fal-using-fal-examples-file-search:

===================
Searching for files
===================

An API is provided by the file abstraction layer (FAL) to search for files in a
storage or folder. It includes matches in meta data of those files. The given
search term is looked for in all supported TCA fields of the tables
:sql:`sys_file` and :sql:`sys_file_metadata`.

..  contents::
    :local:


..  _fal-using-fal-examples-file-search-searching-files-folder:

Searching for files in a folder
===============================

..  literalinclude:: _ExamplesFileSearch/_SearchInFolder.php
    :caption: EXT:my_extension/Classes/SearchInFolderExample.php


..  _fal-using-fal-examples-file-search-searching-files-storage:

Searching for files in a storage
================================

..  literalinclude:: _ExamplesFileSearch/_SearchInStorage.php
    :caption: EXT:my_extension/Classes/SearchInStorageExample.php

..  seealso::
    :ref:`fal-using-fal-examples-storage-repository`


..  _fal-using-fal-examples-file-search-add-additional-restrictions:

Add additional restrictions
===========================

It is possible to further limit the result set, by adding additional
restrictions to the :php:`FileSearchDemand`. Please note, that
:php:`FileSearchDemand` is an immutable value object, but allows chaining
methods for ease of use:

..  literalinclude:: _ExamplesFileSearch/_SearchInStorageWithRestrictions.php
    :caption: EXT:my_extension/Classes/SearchInStorageWithRestrictionsExample.php


..  _fal-using-fal-examples-file-search-api:

API
===

..  include:: /CodeSnippets/Resource/FileSearchDemand.rst.txt


..  _fal-using-fal-examples-file-search-performance-optimization-custom:

Performance optimization in a custom driver
===========================================

A driver capability
:php:`\TYPO3\CMS\Core\Resource\Capabilities::CAPABILITY_HIERARCHICAL_IDENTIFIERS`
is available to implement an optimized search with good performance. Drivers can
optionally add this capability in case the identifiers constructed by the driver
include the directory structure. Adding this capability to drivers
can provide a big performance boost when it comes to recursive search (which is
the default in the file list and file browser UI).
