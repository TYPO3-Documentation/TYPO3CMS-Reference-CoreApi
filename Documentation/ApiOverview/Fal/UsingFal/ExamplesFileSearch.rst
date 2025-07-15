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


Searching for files in a folder
===============================

..  literalinclude:: _ExamplesFileSearch/_SearchInFolder.php
    :language: php
    :caption: EXT:my_extension/Classes/SearchInFolderExample.php


Searching for files in a storage
================================

..  literalinclude:: _ExamplesFileSearch/_SearchInStorage.php
    :language: php
    :caption: EXT:my_extension/Classes/SearchInStorageExample.php

..  seealso::
    :ref:`fal-using-fal-examples-storage-repository`


Add additional restrictions
===========================

It is possible to further limit the result set, by adding additional
restrictions to the :php:`FileSearchDemand`. Please note, that
:php:`FileSearchDemand` is an immutable value object, but allows chaining
methods for ease of use:

..  literalinclude:: _ExamplesFileSearch/_SearchInStorageWithRestrictions.php
    :language: php
    :caption: EXT:my_extension/Classes/SearchInStorageWithRestrictionsExample.php


API
===

..  include:: /CodeSnippets/Resource/FileSearchDemand.rst.txt


Performance optimization in a custom driver
===========================================

A driver capability
:php:`\TYPO3\CMS\Core\Resource\Capabilities::CAPABILITY_HIERARCHICAL_IDENTIFIERS`
is available to implement an optimized search with good performance. Drivers can
optionally add this capability in case the identifiers constructed by the driver
include the directory structure. Adding this capability to drivers
can provide a big performance boost when it comes to recursive search (which is
the default in the file list and file browser UI).

..  versionchanged:: 13.0
    The :php:`CAPABILITY_*` constants from the class
    :php:`\TYPO3\CMS\Core\Resource\ResourceStorageInterface` were removed
    and are now available via the class :php:`\TYPO3\CMS\Core\Resource\Capabilities`.
