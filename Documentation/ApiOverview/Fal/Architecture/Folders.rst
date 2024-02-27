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

By default, a storage pointing to the :file:`fileadmin/` folder
is created automatically in every TYPO3 installation.


..  index:: File abstraction layer; Processed files
..  _fal-architecture-folders-processed-files:

Processed files
===============

Inside each storage there will be a folder named :file:`_processed_/`
which contains all resized images, be they rendered in the frontend
or thumbnails from the backend. The name of this folder is not
hard-coded. It can be defined as a property of the storage.
It may even point to a different storage.

..  include:: /Images/AutomaticScreenshots/Fal/AdministrationFileStorageAccessTab.rst.txt
