
Copying and Moving
##################

This is a short explanation on how copy and move actions are handled in all layers.

FileUsage layer
================

Copy and Move actions are not allowed here, as it's impossible to use
FileUsages in any file management operation.

File/Folder
============

The File and Folder objects have shorthand methods to perform copy and move actions, but
the real work is then done by methods in the Storage.

The shorthand functions available in the File are::

    $file->moveTo($targetFolder);
    $file->copyTo($targetFolder);

And on the Folder::

    $folder->moveTo($targetFolder);
    $folder->copyTo($targetFolder);

As you can see, the above methods are always seen from the object you want to move/copy.

Storage
================

Now, this layer and the below layer is where the interesting stuff happens. In terms of the
actual copying, it makes a big difference if you want to move or copy a file within the same
storage, or if you want to copy to / from a different one.

If you want to copy or move things within the same storage, this action is staight forward
and the Storage just passes the request on to the Driver to actually do it (after checking
permissions, mounts etc. of course though).

However, if two different storages are involved, the Storage has to do some magic. What it
does in those cases, is to first get a local copy of the file from the source, and then
add it to the target storage (and finally delete from the original Storage if it was a move
action and not a copy). Obviously, this is very resource consuming, so copying from one
Storage to the other should be handled with care by the end users.

The functions in the storage responsible for copy and move actions are::

    $storage->moveFile($file, $targetFolder);
    $storage->copyFile($file, $targetFolder);

Driver (especially LocalDriver)
===============================

.. note::
    The below documentation is only relevant for Driver developers.

    As an end-user, you will never have to access the driver methods directly, but always
    use either the shortcut methods of the File and Folder or use the methods provided by
    the Storage.

Case: Source and target are in the current storage::

        # Note that the below code is seen from the storage point of view, as
        # only the storage accesses the driver.

        // For copying/moving Files
    $driver->moveFileWithinStorage($file, $targetFolder);
    $driver->copyFileWithinStorage($file, $targetFolder);

        // For copy/moving Folders:
    $driver->moveFolderWithinStorage($folderToMove, $targetFolder);
    $driver->copyFolderWithinStorage($folderToMove, $targetFolder);

Case: Source and target are in different Storages::

    $driver->addFileRaw($localFilePath, $targetFolder);
    $driver->deleteFileRaw($file);

In the driver you don't need to implement any magic to decide whether the source and the
target are on the same Storage, as that has already been done by the Storage and you can
rely on it.