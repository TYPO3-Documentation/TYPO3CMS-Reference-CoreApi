.. include:: /Includes.rst.txt
.. index:: File abstraction layer; Storages
.. _fal-administration-storages:

=============
File storages
=============

File storages can be administered through the List module. They have a few properties which deserve further explanation.

.. figure:: ../Images/AdministrationFileStorageAccessTab.png
   :alt: The Access tab of a File storage

   Special properties in the Access tab of a File storage


Is browsable?
  If this box is not checked, the storage will not be browsable by
  users via the **FILE > Filelist** module, nor via the link browser
  window.

Is publicly available?
  When this box is unchecked, the "publicUrl" property of files is
  replaced by an eID call pointing to a file dumping script provided
  by the TYPO3 CMS Core. The public URL looks something like
  :code:`index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.
  Behind the scenes, class :php:`\TYPO3\CMS\Core\Controller\FileDumpController`
  is invoked to manage the download. The class itself does not implement
  any access checks, but provides a hook for doing so.

  .. warning::

     This does not protect your files if they are within your web root
     (e.g. below the :file:`fileadmin` folder). They will still be available to
     anyone who knows the path to the file. To implement a strict access restriction,
     the storage must point to some path outside the web root. Alternatively, the folder it points
     to must contain web server restrictions to block direct access to the files it
     contains (for example, in an Apache :file:`.htaccess` file).

Is writable?
  When this box is unchecked, the storage is read-only.

Is online?
  A storage that is not online cannot be accessed in any way. This flag is
  set automatically when files are not accessible (for example, when a 
  third-party storage service is not available) and the underlying Driver 
  detects someone trying to access files in that storage.

  The important thing to note is that a storage must be turned online again
  manually.
