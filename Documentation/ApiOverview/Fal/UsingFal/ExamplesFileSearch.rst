.. include:: /Includes.rst.txt



.. _fal-using-fal-examples-file-search:

===================
Searching for Files
===================

Since TYPO3 9.5.6, there is an API in FAL to search for files in a storage or folder, which includes matches in meta data
of those files. The given search term is looked for in all search fields defined in TCA of `sys_file`
and `sys_file_metadata` tables.


Searching for files in a folder works like this:

.. code-block:: php

   use TYPO3\CMS\Core\Resource\Search\FileSearchDemand;

   $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
   $files = $folder->searchFiles($searchDemand);

Searching for files in a complete storage works like this:

.. code-block:: php

   $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
   $files = $storage->searchFiles($searchDemand);

It is possible to further limit the result set, by adding additional restrictions to the `FileSearchDemand`.
Please note, that `FileSearchDemand` is an immutable value object, but allows chaining methods for ease of use:

.. code-block:: php

   $searchDemand = FileSearchDemand::createForSearchTerm($this->searchWord)
       ->withRecursive()
       ->withMaxResults(10)
       ->withOrdering('fileext');
   $files = $storage->searchFiles($searchDemand);


There is also a driver capability `\TYPO3\CMS\Core\Resource\ResourceStorageInterface::CAPABILITY_HIERARCHICAL_IDENTIFIERS`
to allow implementing an optimized search with good performance.
Drivers can optionally add this capability in case the identifiers that are constructed by the driver
include the directory structure.
Adding this capability to drivers can provide a big performance boost
when it comes to recursive search (which is default in the file list and file browser UI).
