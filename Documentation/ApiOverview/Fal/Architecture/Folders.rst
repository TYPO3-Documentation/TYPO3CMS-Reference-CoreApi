..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Folders
..  _architecture-folders:

=======
Folders
=======

The actual storage structure depends on which
:ref:`driver <fal-architecture-components-drivers>` each
:ref:`storage <fal-architecture-components-storage>`
is based on. When using the local file system driver provided by
the TYPO3 Core, a storage will correspond to some existing
folder on the local storage system (for example, on the hard drive). Other
drivers may use virtual structures.

Without further configuration, every TYPO3 installation has a storage for the
folder :file:`fileadmin/`, see
`The default storage without a configuration file <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-default>`_.


..  index:: File abstraction layer; Processed files
..  _fal-architecture-folders-processed-files:

Processed files
===============

Inside each storage there will be a folder named :file:`_processed_/`
which contains all resized images, be they rendered in the frontend
or thumbnails from the backend. The name of this folder is not
hard-coded. The storage option `processingFolder` sets it, see
`Options of a storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-options>`_.
It may even point to a different storage.

..  versionchanged:: 15.0
    :changelog: feature-110702-1789927725

    Before, processed images from extensions were stored in
    :file:`typo3temp/assets/_processed_/`.

Images that an extension or a package ships, referenced as `EXT:` or `PKG:`
system resource, are not in a storage. TYPO3 caches their processed variants in
:file:`typo3temp/assets/images/system/`, without a database record. Do not rely
on the name or location of a processed file.
