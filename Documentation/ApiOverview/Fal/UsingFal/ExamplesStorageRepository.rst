..  include:: /Includes.rst.txt

..  _fal-using-fal-examples:
..  _fal-using-fal-examples-storage-repository:

===========================
The StorageRepository class
===========================

The :php:`\TYPO3\CMS\Core\Resource\StorageRepository` is the
main class for creating and retrieving
:ref:`file storage <fal-architecture-components-storage>` objects.
It contains a number of utility methods, some of
which are described here, some others which appear in the
other code samples provided in this chapter.


..  _fal-using-fal-examples-storage-repository-default-storage:

Getting the default storage
===========================

Of all available storages, one may be marked as default. This
is the storage that will be used for any operation whenever
no storage has been explicitly chosen or defined (for example,
when not using a :ref:`combined identifier <fal-architecture-components-files-folders>`).

..  literalinclude:: _ExamplesStorageRepository/_GetDefaultStorageExample.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/GetDefaultStorageExample.php


..  _fal-using-fal-examples-storage-repository-getting-storage:

Getting any storage
===================

The :php:`StorageRepository` class should be used for retrieving any storage.

..  literalinclude:: _ExamplesStorageRepository/_GetStorageObjectExample.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/GetStorageObjectExample.php
