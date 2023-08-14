.. include:: /Includes.rst.txt

.. _fal-using-fal-examples-file-search:

===================
Searching for files
===================

An API is provided by the File Abstraction Layer to search for files in a
storage or folder. It includes matches in meta data of those files. The given
search term is looked for in all
:ref:`search fields defined in TCA <t3tca:ctrl-reference-searchfields>` of
:sql:`sys_file` and :sql:`sys_file_metadata` tables.

Searching for files in a folder works like this:

..  code-block:: php

    use TYPO3\CMS\Core\Resource\Search\FileSearchDemand;

    $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
    $files = $folder->searchFiles($searchDemand);

Searching for files in a storage works like this:

..  code-block:: php

    $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
    $files = $storage->searchFiles($searchDemand);

It is possible to further limit the result set, by adding additional
restrictions to the :php:`FileSearchDemand`. Please note, that
:php:`FileSearchDemand` is an immutable value object, but allows chaining
methods for ease of use:

..  code-block:: php

    $searchDemand = FileSearchDemand::createForSearchTerm($this->searchWord)
        ->withRecursive()
        ->withMaxResults(10)
        ->withOrdering('fileext');
    $files = $storage->searchFiles($searchDemand);


Performance optimization in a custom driver
===========================================

A driver capability
:php:`\TYPO3\CMS\Core\Resource\ResourceStorageInterface::CAPABILITY_HIERARCHICAL_IDENTIFIERS`
is available to implement an optimized search with good performance. Drivers can
optionally add this capability in case the identifiers constructed by the driver
include the directory structure. Adding this capability to drivers
can provide a big performance boost when it comes to recursive search (which is
the default in the file list and file browser UI).
