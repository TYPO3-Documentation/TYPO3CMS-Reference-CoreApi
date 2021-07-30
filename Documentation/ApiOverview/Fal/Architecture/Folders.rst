.. include:: /Includes.rst.txt
.. index:: File abstraction layer; Folders
.. _architecture-folders:

=======
Folders
=======

The actual storage structure depends on which Driver each storage
is based on. When using the local file system Driver provided by
the TYPO3 CMS Core, a storage will correspond to some existing
folder on the local storage system (e.g. hard drive). Other
Drivers may use virtual structures.

By default, a storage pointing to the :file:`fileadmin` folder
is created automatically in every TYPO3 CMS installation.


.. index:: File abstraction layer; Processed files
.. _fal-architecture-folders-processed-files:

Processed files
===============

Inside each storage there will be a folder named :file:`_processed_`
which contains all resized images, be they rendered in the frontend
or thumbnails from the backend. The name of this folder is not
hard-coded. It can be defined as a property of the storage.
It may even point to a different storage.

.. figure:: /Images/ManualScreenshots/Fal/ArchitectureFoldersProcessedFolder.png
   :alt: Defining a location for processed files

   Editing a file storage to define a location for processed files
