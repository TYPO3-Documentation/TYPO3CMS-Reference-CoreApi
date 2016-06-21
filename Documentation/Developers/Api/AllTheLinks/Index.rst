.. include:: ../../../Includes.txt


=======================
All The Links: Resource
=======================

About `\\TYPO3\\CMS\\Core\\Resource`

.. tip::

   Hello **TYPO3 core developers,** here you have the links to the
   RESOURCE Api enriched by **YOUR descriptions** as you have
   given them in the PHPDoc blocks of the code.
   So please: **Start being more eloquent!** It's worth it!


AbstractFile
============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile`
   ...

:ref:`AbstractFile::copyTo <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::copyTo>`
   Copies this file into a target folder


:ref:`AbstractFile::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::delete>`
   Deletes this file from its storage. This also means that this object becomes useless.


:ref:`AbstractFile::exists <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::exists>`
   Checks if this file exists. This should normally always return TRUE; it might only return FALSE when this object has been created from an index record without checking for.


:ref:`AbstractFile::getCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getCombinedIdentifier>`
   Returns a combined identifier of this file, i.e. the storage UID and the folder identifier separated by a colon ":".


:ref:`AbstractFile::getContents <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getContents>`
   Get the contents of this file


:ref:`AbstractFile::getCreationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getCreationTime>`
   Returns the creation time of the file as Unix timestamp


:ref:`AbstractFile::getExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getExtension>`
   Get the extension of this file in a lower-case variant


:ref:`AbstractFile::getForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getForLocalProcessing>`
   Returns a path to a local version of this file to process it locally (e.g. with some system tool). If the file is normally located on a remote storages, this creates a local copy. If the file is already on the local system, this only makes a new copy if $writable is set to TRUE.


:ref:`AbstractFile::getHashedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getHashedIdentifier>`
   Get hashed identifier


:ref:`AbstractFile::getIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getIdentifier>`
   Returns the identifier of this file


:ref:`AbstractFile::getMimeType <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getMimeType>`
   Get the MIME type of this file


:ref:`AbstractFile::getModificationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getModificationTime>`
   Returns the date (as UNIX timestamp) the file was last modified.


:ref:`AbstractFile::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getName>`
   Returns the name of this file


:ref:`AbstractFile::getNameWithoutExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getNameWithoutExtension>`
   Returns the basename (the name without extension) of this file.


:ref:`AbstractFile::getParentFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getParentFolder>`
   Returns the parent folder.


:ref:`AbstractFile::getProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getProperties>`
   Returns the properties of this object.


:ref:`AbstractFile::getProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getProperty>`
   Returns a property value


:ref:`AbstractFile::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getPublicUrl>`
   Returns a publicly accessible URL for this file

   WARNING: Access to the file may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`AbstractFile::getSha1 <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getSha1>`
   Returns the Sha1 of this file


:ref:`AbstractFile::getSize <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getSize>`
   Returns the size of this file


:ref:`AbstractFile::getStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getStorage>`
   Get the storage this file is located in


:ref:`AbstractFile::getType <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getType>`
   Returns the fileType of this file basically there are only five main "file types" "audio" "image" "software" "text" "video" "other" see the constants in this class


:ref:`AbstractFile::getUid <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::getUid>`
   Returns the uid of this file


:ref:`AbstractFile::hasProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::hasProperty>`
   Returns true if the given property key exists for this file.


:ref:`AbstractFile::isDeleted <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::isDeleted>`
   Returns TRUE if this file has been deleted


:ref:`AbstractFile::moveTo <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::moveTo>`
   Moves the file into the target folder


:ref:`AbstractFile::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::rename>`
   Renames this file.


:ref:`AbstractFile::setContents <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::setContents>`
   Replace the current file contents with the given string


:ref:`AbstractFile::setDeleted <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::setDeleted>`
   ...

:ref:`AbstractFile::setIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::setIdentifier>`
   Set the identifier of this file


:ref:`AbstractFile::setStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::setStorage>`
   Sets the storage this file is located in. This is only meant for -internal usage; don't use it to move files.


:ref:`AbstractFile::updateProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractFile::updateProperties>`
   Updates properties of this object. This method is used to reconstitute settings from the database into this object after being intantiated.



AbstractRepository
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository`
   ...

:ref:`AbstractRepository::__call <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::\_\_call>`
   Magic call method for repository methods.


:ref:`AbstractRepository::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::\_\_construct>`
   Creates this object.


:ref:`AbstractRepository::add <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::add>`
   Adds an object to this repository.


:ref:`AbstractRepository::countAll <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::countAll>`
   Returns the total number objects of this repository.


:ref:`AbstractRepository::createDomainObject <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::createDomainObject>`
   Creates an object managed by this repository.


:ref:`AbstractRepository::createQuery <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::createQuery>`
   Returns a query for objects of this repository


:ref:`AbstractRepository::findAll <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::findAll>`
   Returns all objects of this repository.


:ref:`AbstractRepository::findByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::findByIdentifier>`
   Finds an object matching the given identifier.


:ref:`AbstractRepository::findByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::findByUid>`
   Finds an object matching the given identifier.


:ref:`AbstractRepository::getAddedObjects <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getAddedObjects>`
   ...

:ref:`AbstractRepository::getDatabaseConnection <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getDatabaseConnection>`
   ...

:ref:`AbstractRepository::getEntityClassName <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getEntityClassName>`
   Returns the object type this repository is managing.


:ref:`AbstractRepository::getEnvironmentMode <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getEnvironmentMode>`
   Function to return the current TYPO3\_MODE. This function can be mocked in unit tests to be able to test frontend behaviour.


:ref:`AbstractRepository::getRemovedObjects <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getRemovedObjects>`
   ...

:ref:`AbstractRepository::getWhereClauseForEnabledFields <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::getWhereClauseForEnabledFields>`
   get the WHERE clause for the enabled fields of this TCA table depending on the context


:ref:`AbstractRepository::remove <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::remove>`
   Removes an object from this repository.


:ref:`AbstractRepository::removeAll <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::removeAll>`
   ...

:ref:`AbstractRepository::replace <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::replace>`
   Replaces an object by another.


:ref:`AbstractRepository::setDefaultOrderings <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::setDefaultOrderings>`
   Sets the property names to order the result by per default. Expected like this: array( 'foo' => Tx\_Extbase\_Persistence\_QueryInterface::ORDER\_ASCENDING, 'bar' => Tx\_Extbase\_Persistence\_QueryInterface::ORDER\_DESCENDING )


:ref:`AbstractRepository::setDefaultQuerySettings <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::setDefaultQuerySettings>`
   Sets the default query settings to be used in this repository


:ref:`AbstractRepository::update <t3api62:TYPO3\\CMS\\Core\\Resource\\AbstractRepository::update>`
   Replaces an existing object with the same identifier by the given object



AbstractFileCollection
======================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection`
   ...

:ref:`AbstractFileCollection::add <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::add>`
   Adds a file to this collection.


:ref:`AbstractFileCollection::fromArray <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::fromArray>`
   Similar to method in , but without $this->itemTableName= $array['table\_name'], but with $this->storageItemsFieldContent = $array[self::$storageItemsField];


:ref:`AbstractFileCollection::getItemsCriteria <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::getItemsCriteria>`
   Gets ths items criteria.


:ref:`AbstractFileCollection::getPersistableDataArray <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::getPersistableDataArray>`
   Returns an array of the persistable properties and contents which are processable by TCEmain.


:ref:`AbstractFileCollection::removeAll <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::removeAll>`
   Removes all elements of the current collection.


:ref:`AbstractFileCollection::setDescription <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::setDescription>`
   Sets the description.


:ref:`AbstractFileCollection::setItemsCriteria <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::setItemsCriteria>`
   Sets the items criteria.


:ref:`AbstractFileCollection::setTitle <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\AbstractFileCollection::setTitle>`
   Sets the title.



CategoryBasedFileCollection
===========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\CategoryBasedFileCollection`
   ...

:ref:`CategoryBasedFileCollection::getDatabaseConnection <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\CategoryBasedFileCollection::getDatabaseConnection>`
   Gets the database object.


:ref:`CategoryBasedFileCollection::loadContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\CategoryBasedFileCollection::loadContents>`
   Populates the content-entries of the collection



FileCollectionRegistry
======================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry`
   ...

:ref:`FileCollectionRegistry::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry::\_\_construct>`
   Constructor


:ref:`FileCollectionRegistry::addTypeToTCA <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry::addTypeToTCA>`
   Add the type to the TCA of sys\_file\_collection


:ref:`FileCollectionRegistry::fileCollectionTypeExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry::fileCollectionTypeExists>`
   Checks if the given FileCollection type exists


:ref:`FileCollectionRegistry::getFileCollectionClass <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry::getFileCollectionClass>`
   Returns a class name for a given type


:ref:`FileCollectionRegistry::registerFileCollectionClass <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FileCollectionRegistry::registerFileCollectionClass>`
   Register a (new) FileCollection type



FolderBasedFileCollection
=========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FolderBasedFileCollection`
   ...

:ref:`FolderBasedFileCollection::getItemsCriteria <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FolderBasedFileCollection::getItemsCriteria>`
   Gets the items criteria.


:ref:`FolderBasedFileCollection::getPersistableDataArray <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FolderBasedFileCollection::getPersistableDataArray>`
   Returns an array of the persistable properties and contents which are processable by TCEmain.


:ref:`FolderBasedFileCollection::loadContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\FolderBasedFileCollection::loadContents>`
   Populates the content-entries of the storage

   Queries the underlying storage for entries of the collection and adds them to the collection data.

   If the content entries of the storage had not been loaded on creation ($fillItems = false) this function is to be used for loading the contents afterwards.



StaticFileCollection
====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Collection\\StaticFileCollection`
   ...


AbstractDriver
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver`
   ...

:ref:`AbstractDriver::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::\_\_construct>`
   Creates this object.


:ref:`AbstractDriver::canonicalizeAndCheckFileIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::canonicalizeAndCheckFileIdentifier>`
   Makes sure the identifier given as parameter is valid


:ref:`AbstractDriver::canonicalizeAndCheckFilePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::canonicalizeAndCheckFilePath>`
   Makes sure the path given as parameter is valid


:ref:`AbstractDriver::canonicalizeAndCheckFolderIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::canonicalizeAndCheckFolderIdentifier>`
   Makes sure the identifier given as parameter is valid


:ref:`AbstractDriver::getCapabilities <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::getCapabilities>`
   Returns the capabilities of this driver.


:ref:`AbstractDriver::getTemporaryPathForFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::getTemporaryPathForFile>`
   Returns a temporary path for a given file, including the file extension.


:ref:`AbstractDriver::hasCapability <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::hasCapability>`
   Returns TRUE if this driver has the given capability.


:ref:`AbstractDriver::hashIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::hashIdentifier>`
   Hashes a file identifier, taking the case sensitivity of the file system into account. This helps mitigating problems with case-insensitive databases.


:ref:`AbstractDriver::isCaseSensitiveFileSystem <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::isCaseSensitiveFileSystem>`
   Returns TRUE if this driver uses case-sensitive identifiers. NOTE: This is a configurable setting, but the setting does not change the way the underlying file system treats the identifiers; the setting should therefore always reflect the file system and not try to change its behaviour


:ref:`AbstractDriver::isValidFilename <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::isValidFilename>`
   Checks a fileName for validity. This could be overidden in concrete drivers if they have different file naming rules.


:ref:`AbstractDriver::sanitizeFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::sanitizeFileName>`
   Basic implementation of the method that does directly return the file name as is.


:ref:`AbstractDriver::setStorageUid <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver::setStorageUid>`
   Sets the storage uid the driver belongs to



AbstractHierarchicalFilesystemDriver
====================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver`
   ...

:ref:`AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFileIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFileIdentifier>`
   Makes sure the Path given as parameter is valid


:ref:`AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFilePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFilePath>`
   Makes sure the Path given as parameter is valid


:ref:`AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFolderIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver::canonicalizeAndCheckFolderIdentifier>`
   Makes sure the Path given as parameter is valid


:ref:`AbstractHierarchicalFilesystemDriver::getParentFolderIdentifierOfIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver::getParentFolderIdentifierOfIdentifier>`
   Returns the identifier of the folder the file resides in


:ref:`AbstractHierarchicalFilesystemDriver::isPathValid <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractHierarchicalFilesystemDriver::isPathValid>`
   Wrapper for ::validPathStr()



DriverInterface
===============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface`
   ...

:ref:`DriverInterface::addFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::addFile>`
   Adds a file from the local server hard disk to a given path in TYPO3s virtual file system. This assumes that the local file exists, so no further check is done here! After a successful the original file must not exist anymore.


:ref:`DriverInterface::copyFileWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::copyFileWithinStorage>`
   ...

:ref:`DriverInterface::copyFolderWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::copyFolderWithinStorage>`
   ...

:ref:`DriverInterface::createFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::createFile>`
   Creates a new (empty) file and returns the identifier.


:ref:`DriverInterface::createFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::createFolder>`
   Creates a folder, within a parent folder. If no parent folder is given, a root level folder will be created


:ref:`DriverInterface::deleteFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::deleteFile>`
   Removes a file from the filesystem. This does not check if the file is still used or if it is a bad idea to delete it for some other reason this has to be taken care of in the upper layers (e.g. the Storage)!


:ref:`DriverInterface::deleteFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::deleteFolder>`
   Removes a folder in filesystem.


:ref:`DriverInterface::dumpFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::dumpFileContents>`
   Directly output the contents of the file to the output buffer. Should not take care of header files or flushing buffer before. Will be taken care of by the Storage.


:ref:`DriverInterface::fileExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::fileExists>`
   Checks if a file exists.


:ref:`DriverInterface::fileExistsInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::fileExistsInFolder>`
   Checks if a file inside a folder exists


:ref:`DriverInterface::folderExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::folderExists>`
   Checks if a folder exists.


:ref:`DriverInterface::folderExistsInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::folderExistsInFolder>`
   Checks if a folder inside a folder exists.


:ref:`DriverInterface::getCapabilities <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getCapabilities>`
   Returns the capabilities of this driver.


:ref:`DriverInterface::getDefaultFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getDefaultFolder>`
   Returns the identifier of the default folder new files should be put into.


:ref:`DriverInterface::getFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFileContents>`
   Returns the contents of a file. Beware that this requires to load the complete file into memory and also may require fetching the file from an external location. So this might be an expensive operation (both in terms of processing resources and money) for large files.


:ref:`DriverInterface::getFileForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFileForLocalProcessing>`
   Returns a path to a local copy of a file for processing it. When changing the file, you have to take care of replacing the current version yourself!


:ref:`DriverInterface::getFileInfoByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFileInfoByIdentifier>`
   Returns information about a file.


:ref:`DriverInterface::getFilesInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFilesInFolder>`
   Returns a list of files inside the specified path


:ref:`DriverInterface::getFolderInfoByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFolderInfoByIdentifier>`
   Returns information about a file.


:ref:`DriverInterface::getFoldersInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getFoldersInFolder>`
   Returns a list of folders inside the specified path


:ref:`DriverInterface::getParentFolderIdentifierOfIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getParentFolderIdentifierOfIdentifier>`
   Returns the identifier of the folder the file resides in


:ref:`DriverInterface::getPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getPermissions>`
   Returns the permissions of a file/folder as an array (keys r, w) of boolean flags


:ref:`DriverInterface::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getPublicUrl>`
   Returns the public URL to a file. Either fully qualified URL or relative to PATH\_site (rawurlencoded).


:ref:`DriverInterface::getRootLevelFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::getRootLevelFolder>`
   Returns the identifier of the root level folder of the storage.


:ref:`DriverInterface::hasCapability <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::hasCapability>`
   Returns TRUE if this driver has the given capability.


:ref:`DriverInterface::hash <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::hash>`
   Creates a hash for a file.


:ref:`DriverInterface::hashIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::hashIdentifier>`
   Hashes a file identifier, taking the case sensitivity of the file system into account. This helps mitigating problems with case-insensitive databases.


:ref:`DriverInterface::initialize <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::initialize>`
   Initializes this object. This is called by the storage after the driver has been attached.


:ref:`DriverInterface::isCaseSensitiveFileSystem <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::isCaseSensitiveFileSystem>`
   Returns TRUE if this driver uses case-sensitive identifiers. NOTE: This is a configurable setting, but the setting does not change the way the underlying file system treats the identifiers; the setting should therefore always reflect the file system and not try to change its behaviour


:ref:`DriverInterface::isFolderEmpty <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::isFolderEmpty>`
   Checks if a folder contains files and (if supported) other folders.


:ref:`DriverInterface::isWithin <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::isWithin>`
   Checks if a given identifier is within a container, e.g. if a file or folder is within another folder. This can e.g. be used to check for web-mounts.

   Hint: this also needs to return TRUE if the given identifier matches the container identifier to allow access to the root folder of a filemount.


:ref:`DriverInterface::mergeConfigurationCapabilities <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::mergeConfigurationCapabilities>`
   Merges the capabilites merged by the user at the storage configuration into the actual capabilities of the driver and returns the result.


:ref:`DriverInterface::moveFileWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::moveFileWithinStorage>`
   ...

:ref:`DriverInterface::moveFolderWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::moveFolderWithinStorage>`
   ...

:ref:`DriverInterface::processConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::processConfiguration>`
   ...

:ref:`DriverInterface::renameFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::renameFile>`
   Renames a file in this storage.


:ref:`DriverInterface::renameFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::renameFolder>`
   Renames a folder in this storage.


:ref:`DriverInterface::replaceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::replaceFile>`
   Replaces a file with file in local file system.


:ref:`DriverInterface::sanitizeFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::sanitizeFileName>`
   Cleans a fileName from not allowed characters


:ref:`DriverInterface::setFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::setFileContents>`
   Sets the contents of a file to the specified value.


:ref:`DriverInterface::setStorageUid <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverInterface::setStorageUid>`
   Sets the storage uid the driver belongs to



DriverRegistry
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry`
   ...

:ref:`DriverRegistry::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry::\_\_construct>`
   Creates this object.


:ref:`DriverRegistry::addDriversToTCA <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry::addDriversToTCA>`
   ...

:ref:`DriverRegistry::driverExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry::driverExists>`
   Checks if the given driver exists


:ref:`DriverRegistry::getDriverClass <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry::getDriverClass>`
   Returns a class name for a given class name or short name.


:ref:`DriverRegistry::registerDriverClass <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry::registerDriverClass>`
   Registers a driver class with an optional short name.



LocalDriver
===========

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver`
   ...

:ref:`LocalDriver::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::\_\_construct>`
   ...

:ref:`LocalDriver::addFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::addFile>`
   Adds a file from the local server hard disk to a given path in TYPO3s virtual file system. This assumes that the local file exists, so no further check is done here! After a successful the original file must not exist anymore.


:ref:`LocalDriver::applyFilterMethodsToDirectoryItem <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::applyFilterMethodsToDirectoryItem>`
   Applies a set of filter methods to a file name to find out if it should be used or not. This is e.g. used by directory listings.


:ref:`LocalDriver::calculateBasePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::calculateBasePath>`
   Calculates the absolute path to this drivers storage location.


:ref:`LocalDriver::copyFileToTemporaryPath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::copyFileToTemporaryPath>`
   Copies a file to a temporary path and returns that path.


:ref:`LocalDriver::copyFileWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::copyFileWithinStorage>`
   ...

:ref:`LocalDriver::createFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::createFile>`
   Creates a new (empty) file and returns the identifier.


:ref:`LocalDriver::createFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::createFolder>`
   Creates a folder, within a parent folder. If no parent folder is given, a rootlevel folder will be created


:ref:`LocalDriver::createIdentifierMap <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::createIdentifierMap>`
   Creates a map of old and new file/folder identifiers after renaming or moving a folder. The old identifier is used as the key, the new one as the value.


:ref:`LocalDriver::deleteFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::deleteFile>`
   Removes a file from the filesystem. This does not check if the file is still used or if it is a bad idea to delete it for some other reason this has to be taken care of in the upper layers (e.g. the Storage)!


:ref:`LocalDriver::deleteFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::deleteFolder>`
   Removes a folder from this storage.


:ref:`LocalDriver::determineBaseUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::determineBaseUrl>`
   ...

:ref:`LocalDriver::dumpFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::dumpFileContents>`
   Directly output the contents of the file to the output buffer. Should not take care of header files or flushing buffer before. Will be taken care of by the Storage.


:ref:`LocalDriver::extractFileInformation <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::extractFileInformation>`
   Extracts information about a file from the filesystem.


:ref:`LocalDriver::fileExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::fileExists>`
   Checks if a file exists.


:ref:`LocalDriver::fileExistsInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::fileExistsInFolder>`
   Checks if a file inside a folder exists


:ref:`LocalDriver::folderExists <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::folderExists>`
   Checks if a folder exists.


:ref:`LocalDriver::folderExistsInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::folderExistsInFolder>`
   Checks if a folder inside a folder exists.


:ref:`LocalDriver::getAbsoluteBasePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getAbsoluteBasePath>`
   Returns the absolute path of the folder this driver operates on.


:ref:`LocalDriver::getAbsolutePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getAbsolutePath>`
   Returns the absolute path of a file or folder.


:ref:`LocalDriver::getCharsetConversion <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getCharsetConversion>`
   Gets the charset conversion object.


:ref:`LocalDriver::getDefaultFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getDefaultFolder>`
   Returns identifier of the default folder new files should be put into.


:ref:`LocalDriver::getDirectoryItemList <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getDirectoryItemList>`
   Generic wrapper for extracting a list of items from a path.


:ref:`LocalDriver::getFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFileContents>`
   Returns the contents of a file. Beware that this requires to load the complete file into memory and also may require fetching the file from an external location. So this might be an expensive operation (both in terms of processing resources and money) for large files.


:ref:`LocalDriver::getFileForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFileForLocalProcessing>`
   Returns (a local copy of) a file for processing it. This makes a copy first when in writable mode, so if you change the file, you have to update it yourself afterwards.


:ref:`LocalDriver::getFileInfoByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFileInfoByIdentifier>`
   Returns information about a file.


:ref:`LocalDriver::getFilesInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFilesInFolder>`
   Returns a list of files inside the specified path


:ref:`LocalDriver::getFolderInfoByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFolderInfoByIdentifier>`
   Returns information about a folder.


:ref:`LocalDriver::getFolderInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFolderInFolder>`
   Returns the Identifier for a folder within a given folder.


:ref:`LocalDriver::getFoldersInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getFoldersInFolder>`
   Returns a list of folders inside the specified path


:ref:`LocalDriver::getMimeTypeOfFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getMimeTypeOfFile>`
   Get MIME type of file.


:ref:`LocalDriver::getPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getPermissions>`
   Returns the permissions of a file/folder as an array (keys r, w) of boolean flags


:ref:`LocalDriver::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getPublicUrl>`
   Returns the public URL to a file. For the local driver, this will always return a path relative to PATH\_site.


:ref:`LocalDriver::getRole <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getRole>`
   Returns the role of an item (currently only folders; can later be extended for files as well)


:ref:`LocalDriver::getRootLevelFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getRootLevelFolder>`
   Returns the Identifier of the root level folder of the storage.


:ref:`LocalDriver::getSpecificFileInformation <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::getSpecificFileInformation>`
   Extracts a specific FileInformation from the FileSystems.


:ref:`LocalDriver::hash <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::hash>`
   Creates a (cryptographic) hash for a file.


:ref:`LocalDriver::initialize <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::initialize>`
   Initializes this object. This is called by the storage after the driver has been attached.


:ref:`LocalDriver::isFolderEmpty <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::isFolderEmpty>`
   Checks if a folder contains files and (if supported) other folders.


:ref:`LocalDriver::isWithin <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::isWithin>`
   Checks if a given identifier is within a container, e.g. if a file or folder is within another folder. It will also return TRUE if both canonicalized identifiers are equal.


:ref:`LocalDriver::mergeConfigurationCapabilities <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::mergeConfigurationCapabilities>`
   Merges the capabilites merged by the user at the storage configuration into the actual capabilities of the driver and returns the result.


:ref:`LocalDriver::moveFileWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::moveFileWithinStorage>`
   ...

:ref:`LocalDriver::moveFolderWithinStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::moveFolderWithinStorage>`
   ...

:ref:`LocalDriver::processConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::processConfiguration>`
   Processes the configuration for this driver.


:ref:`LocalDriver::renameFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::renameFile>`
   Renames a file in this storage.


:ref:`LocalDriver::renameFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::renameFolder>`
   Renames a folder in this storage.


:ref:`LocalDriver::replaceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::replaceFile>`
   Replaces the contents (and file-specific metadata) of a file object with a local file.


:ref:`LocalDriver::sanitizeFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::sanitizeFileName>`
   Returns a string where any character not matching [.a-zA-Z0-9\_-] is substituted by '\_' Trailing dots are removed

   Previously in ::cleanFileName()


:ref:`LocalDriver::setFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\Driver\\LocalDriver::setFileContents>`
   Sets the contents of a file to the specified value.



Exception
=========

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception`
   ...


AbstractFileOperationException
==============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\AbstractFileOperationException`
   ...


ExistingTargetFileNameException
===============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\ExistingTargetFileNameException`
   ...


ExistingTargetFolderException
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\ExistingTargetFolderException`
   ...


FileDoesNotExistException
=========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\FileDoesNotExistException`
   ...


FileOperationErrorException
===========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\FileOperationErrorException`
   ...


FolderDoesNotExistException
===========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\FolderDoesNotExistException`
   ...


IllegalFileExtensionException
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\IllegalFileExtensionException`
   ...


InsufficientFileAccessPermissionsException
==========================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFileAccessPermissionsException`
   ...


InsufficientFileReadPermissionsException
========================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFileReadPermissionsException`
   ...


InsufficientFileWritePermissionsException
=========================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFileWritePermissionsException`
   ...


InsufficientFolderAccessPermissionsException
============================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFolderAccessPermissionsException`
   ...


InsufficientFolderReadPermissionsException
==========================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFolderReadPermissionsException`
   ...


InsufficientFolderWritePermissionsException
===========================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientFolderWritePermissionsException`
   ...


InsufficientUserPermissionsException
====================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InsufficientUserPermissionsException`
   ...


InvalidConfigurationException
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidConfigurationException`
   ...


InvalidFileException
====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidFileException`
   ...


InvalidFileNameException
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidFileNameException`
   ...


InvalidFolderException
======================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidFolderException`
   ...


InvalidPathException
====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidPathException`
   ...


InvalidTargetFolderException
============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidTargetFolderException`
   ...


InvalidUidException
===================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\InvalidUidException`
   ...


NotInMountPointException
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\NotInMountPointException`
   ...


ResourceDoesNotExistException
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\ResourceDoesNotExistException`
   ...


ResourcePermissionsUnavailableException
=======================================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\ResourcePermissionsUnavailableException`
   ...


UploadException
===============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\UploadException`
   ...


UploadSizeException
===================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Exception\\UploadSizeException`
   ...


File
====

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\File`
   ...

:ref:`File::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\File::\_\_construct>`
   Constructor for a file object. Should normally not be used directly, use the corresponding factory methods instead.


:ref:`File::_getMetaData <t3api62:TYPO3\\CMS\\Core\\Resource\\File::\_getMetaData>`
   Returns the MetaData


:ref:`File::_getPropertyRaw <t3api62:TYPO3\\CMS\\Core\\Resource\\File::\_getPropertyRaw>`
   ...

:ref:`File::_updateMetaDataProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\File::\_updateMetaDataProperties>`
   Updates MetaData properties


:ref:`File::calculateChecksum <t3api62:TYPO3\\CMS\\Core\\Resource\\File::calculateChecksum>`
   Creates a MD5 hash checksum based on the combined identifier of the file, the files' mimetype and the systems' encryption key. used to generate a thumbnail, and this hash is checked if valid


:ref:`File::checkActionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\File::checkActionPermission>`
   Check if a file operation (= action) is allowed for this file


:ref:`File::getContents <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getContents>`
   Get the contents of this file


:ref:`File::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getFileIndexRepository>`
   ...

:ref:`File::getIndexerService <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getIndexerService>`
   Internal function to retrieve the indexer service, if it does not exist, an instance will be created


:ref:`File::getMetaDataRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getMetaDataRepository>`
   ...

:ref:`File::getProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getProperties>`
   Returns the properties of this object.


:ref:`File::getProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getProperty>`
   Returns a property value


:ref:`File::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getPublicUrl>`
   Returns a publicly accessible URL for this file When file is marked as missing or deleted no url is returned

   WARNING: Access to the file may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`File::getSha1 <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getSha1>`
   Gets SHA1 hash.


:ref:`File::getUpdatedProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\File::getUpdatedProperties>`
   Returns the names of all properties that have been updated in this record


:ref:`File::hasProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\File::hasProperty>`
   Checks if the file has a (metadata) property which can be retrieved by "getProperty"


:ref:`File::isIndexed <t3api62:TYPO3\\CMS\\Core\\Resource\\File::isIndexed>`
   Returns TRUE if this file is indexed


:ref:`File::isMissing <t3api62:TYPO3\\CMS\\Core\\Resource\\File::isMissing>`
   ...

:ref:`File::loadMetaData <t3api62:TYPO3\\CMS\\Core\\Resource\\File::loadMetaData>`
   ...

:ref:`File::process <t3api62:TYPO3\\CMS\\Core\\Resource\\File::process>`
   Returns a modified version of the file.


:ref:`File::setContents <t3api62:TYPO3\\CMS\\Core\\Resource\\File::setContents>`
   Replace the current file contents with the given string


:ref:`File::setIndexingInProgess <t3api62:TYPO3\\CMS\\Core\\Resource\\File::setIndexingInProgess>`
   ...

:ref:`File::setMissing <t3api62:TYPO3\\CMS\\Core\\Resource\\File::setMissing>`
   ...

:ref:`File::toArray <t3api62:TYPO3\\CMS\\Core\\Resource\\File::toArray>`
   Returns an array representation of the file. (This is used by the generic listing module vidi when displaying file records.)


:ref:`File::updateProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\File::updateProperties>`
   Updates the properties of this file, e.g. after re-indexing or moving it. By default, only properties that exist as a key in the $properties array are overwritten. If you want to explicitly unset a property, set the corresponding key to NULL in the array.



FileCollectionRepository
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository`
   ...

:ref:`FileCollectionRepository::createDomainObject <t3api62:TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository::createDomainObject>`
   Creates a record collection domain object.


:ref:`FileCollectionRepository::findByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository::findByUid>`
   Finds a record collection by uid.


:ref:`FileCollectionRepository::getFileFactory <t3api62:TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository::getFileFactory>`
   Gets the file factory.



FileInterface
=============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface`
   ...

:ref:`FileInterface::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::delete>`
   Deletes this file from its storage. This also means that this object becomes useless.


:ref:`FileInterface::getContents <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getContents>`
   Get the contents of this file


:ref:`FileInterface::getCreationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getCreationTime>`
   Returns the creation time of the file as Unix timestamp


:ref:`FileInterface::getExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getExtension>`
   Get the file extension


:ref:`FileInterface::getForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getForLocalProcessing>`
   Returns a path to a local version of this file to process it locally (e.g. with some system tool). If the file is normally located on a remote storages, this creates a local copy. If the file is already on the local system, this only makes a new copy if $writable is set to TRUE.


:ref:`FileInterface::getMimeType <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getMimeType>`
   Get the MIME type of this file


:ref:`FileInterface::getModificationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getModificationTime>`
   Returns the modification time of the file as Unix timestamp


:ref:`FileInterface::getNameWithoutExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getNameWithoutExtension>`
   Returns the basename (the name without extension) of this file.


:ref:`FileInterface::getProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getProperty>`
   Get the value of the $key property.


:ref:`FileInterface::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getPublicUrl>`
   Returns a publicly accessible URL for this file

   WARNING: Access to the file may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`FileInterface::getSha1 <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getSha1>`
   Returns the Sha1 of this file


:ref:`FileInterface::getSize <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::getSize>`
   Returns the size of this file


:ref:`FileInterface::hasProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::hasProperty>`
   Returns true if the given key exists for this file.


:ref:`FileInterface::isIndexed <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::isIndexed>`
   Returns TRUE if this file is indexed


:ref:`FileInterface::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::rename>`
   Renames this file.


:ref:`FileInterface::setContents <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::setContents>`
   Replace the current file contents with the given string.


:ref:`FileInterface::toArray <t3api62:TYPO3\\CMS\\Core\\Resource\\FileInterface::toArray>`
   Returns an array representation of the file. (This is used by the generic listing module vidi when displaying file records.)



FileReference
=============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference`
   ...

:ref:`FileReference::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::delete>`
   ...

:ref:`FileReference::getAlternative <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getAlternative>`
   Returns the alternative text to this image

   TODO: Possibly move this to the image domain object instead


:ref:`FileReference::getCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getCombinedIdentifier>`
   Returns a combined identifier of the underlying original file


:ref:`FileReference::getContents <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getContents>`
   Get the contents of this file


:ref:`FileReference::getCreationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getCreationTime>`
   Returns the creation time of the file as Unix timestamp


:ref:`FileReference::getDescription <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getDescription>`
   Returns the description text to this file

   TODO: Possibly move this to the image domain object instead


:ref:`FileReference::getExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getExtension>`
   Get the file extension of this file


:ref:`FileReference::getForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getForLocalProcessing>`
   Returns a path to a local version of this file to process it locally (e.g. with some system tool). If the file is normally located on a remote storages, this creates a local copy. If the file is already on the local system, this only makes a new copy if $writable is set to TRUE.


:ref:`FileReference::getHashedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getHashedIdentifier>`
   Get hashed identifier


:ref:`FileReference::getIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getIdentifier>`
   Returns the identifier of the underlying original file


:ref:`FileReference::getLink <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getLink>`
   Returns the link that should be active when clicking on this image

   TODO: Move this to the image domain object instead


:ref:`FileReference::getMimeType <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getMimeType>`
   Get the MIME type of this file


:ref:`FileReference::getModificationTime <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getModificationTime>`
   Returns the modification time of the file as Unix timestamp


:ref:`FileReference::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getName>`
   Returns the name of this file


:ref:`FileReference::getNameWithoutExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getNameWithoutExtension>`
   Returns the basename (the name without extension) of this file.


:ref:`FileReference::getOriginalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getOriginalFile>`
   Gets the original file being referenced.


:ref:`FileReference::getParentFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getParentFolder>`
   Returns the parent folder.


:ref:`FileReference::getProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getProperties>`
   Gets all properties, falling back to values of the parent.


:ref:`FileReference::getProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getProperty>`
   Gets a property, falling back to values of the parent.


:ref:`FileReference::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getPublicUrl>`
   Returns a publicly accessible URL for this file

   WARNING: Access to the file may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`FileReference::getReferenceProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getReferenceProperties>`
   Gets all properties of the file reference.


:ref:`FileReference::getReferenceProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getReferenceProperty>`
   Gets a property of the file reference.


:ref:`FileReference::getSha1 <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getSha1>`
   Returns the Sha1 of this file


:ref:`FileReference::getSize <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getSize>`
   Returns the size of this file


:ref:`FileReference::getStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getStorage>`
   Get the storage the original file is located in


:ref:`FileReference::getTitle <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getTitle>`
   Returns the title text to this image

   TODO: Possibly move this to the image domain object instead


:ref:`FileReference::getType <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getType>`
   Returns the fileType of this file


:ref:`FileReference::getUid <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::getUid>`
   ...

:ref:`FileReference::hasProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::hasProperty>`
   Returns true if the given key exists for this file.


:ref:`FileReference::isIndexed <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::isIndexed>`
   ...

:ref:`FileReference::isMissing <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::isMissing>`
   Check if file is marked as missing by indexer


:ref:`FileReference::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::rename>`
   Renames the fileName in this particular usage.


:ref:`FileReference::restoreNonNullValuesCallback <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::restoreNonNullValuesCallback>`
   Callback to handle the NULL value feature


:ref:`FileReference::setContents <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::setContents>`
   Replace the current file contents with the given string


:ref:`FileReference::toArray <t3api62:TYPO3\\CMS\\Core\\Resource\\FileReference::toArray>`
   Returns an array representation of the file. (This is used by the generic listing module vidi when displaying file records.)



FileRepository
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository`
   ...

:ref:`FileRepository::addToIndex <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::addToIndex>`
   ...

:ref:`FileRepository::createDomainObject <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::createDomainObject>`
   Creates an object managed by this repository.


:ref:`FileRepository::createFileReferenceObject <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::createFileReferenceObject>`
   ...

:ref:`FileRepository::findBySha1Hash <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::findBySha1Hash>`
   Returns all files with the corresponding SHA-1 hash. This is queried against the database, so only indexed files will be found


:ref:`FileRepository::findByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::findByUid>`
   ...

:ref:`FileRepository::findFileReferenceByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::findFileReferenceByUid>`
   ...

:ref:`FileRepository::getFileIndexRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::getFileIndexRecord>`
   Returns an index record of a file, or FALSE if the file is not indexed.


:ref:`FileRepository::getFileIndexRecordsForFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::getFileIndexRecordsForFolder>`
   Returns the index-data of all files within that folder


:ref:`FileRepository::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::getFileIndexRepository>`
   Return a file index repository


:ref:`FileRepository::getFileIndexStatus <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::getFileIndexStatus>`
   Checks the index status of a file and returns FALSE if the file is not indexed, the uid otherwise.


:ref:`FileRepository::getIndexerService <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::getIndexerService>`
   Internal function to retrieve the indexer service, if it does not exist, an instance will be created


:ref:`FileRepository::update <t3api62:TYPO3\\CMS\\Core\\Resource\\FileRepository::update>`
   Updates an existing file object in the database



FileExtensionFilter
===================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter`
   ...

:ref:`FileExtensionFilter::convertToLowercaseArray <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::convertToLowercaseArray>`
   Converts mixed (string or array) input arguments into an array, NULL if empty.

   All array values will be converted to lower case.


:ref:`FileExtensionFilter::filterFileList <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::filterFileList>`
   Entry method for use as file list filter.

   We have to use -1 as the „don't include“ return value, as call\_user\_func() will return FALSE if calling the method failed and thus we can't use that as a return value.


:ref:`FileExtensionFilter::filterInlineChildren <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::filterInlineChildren>`
   Entry method for use as TCEMain "inline" field filter


:ref:`FileExtensionFilter::isAllowed <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::isAllowed>`
   Checks whether a file is allowed according to the criteria defined in the class variables ($this->allowedFileExtensions etc.)


:ref:`FileExtensionFilter::setAllowedFileExtensions <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::setAllowedFileExtensions>`
   Set allowed file extensions


:ref:`FileExtensionFilter::setDisallowedFileExtensions <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter::setDisallowedFileExtensions>`
   Set disallowed file extensions



FileNameFilter
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileNameFilter`
   ...

:ref:`FileNameFilter::filterHiddenFilesAndFolders <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileNameFilter::filterHiddenFilesAndFolders>`
   ...

:ref:`FileNameFilter::getShowHiddenFilesAndFolders <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileNameFilter::getShowHiddenFilesAndFolders>`
   Gets the info whether the hidden files are also displayed currently


:ref:`FileNameFilter::setShowHiddenFilesAndFolders <t3api62:TYPO3\\CMS\\Core\\Resource\\Filter\\FileNameFilter::setShowHiddenFilesAndFolders>`
   set the flag to show (or hide) the hidden files



Folder
======

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Folder`
   ...

:ref:`Folder::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::\_\_construct>`
   Initialization of the folder


:ref:`Folder::addFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::addFile>`
   Adds a file from the local server disk. If the file already exists and overwriting is disabled,


:ref:`Folder::addUploadedFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::addUploadedFile>`
   Adds an uploaded file into the Storage.


:ref:`Folder::checkActionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::checkActionPermission>`
   Check if a file operation (= action) is allowed on this folder


:ref:`Folder::copyTo <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::copyTo>`
   Copies folder to a target folder


:ref:`Folder::createFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::createFile>`
   Creates a new blank file


:ref:`Folder::createFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::createFolder>`
   Creates a new folder


:ref:`Folder::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::delete>`
   Deletes this folder from its storage. This also means that this object becomes useless.


:ref:`Folder::getCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getCombinedIdentifier>`
   Returns a combined identifier of this folder, i.e. the storage UID and the folder identifier separated by a colon ":".


:ref:`Folder::getFileCount <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getFileCount>`
   Returns amount of all files within this folder, optionally filtered by the given pattern


:ref:`Folder::getFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getFiles>`
   Returns a list of files in this folder, optionally filtered. There are several filter modes available, see the FILTER\_MODE\_\* constants for more information.

   For performance reasons the returned items can also be limited to a given range


:ref:`Folder::getHashedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getHashedIdentifier>`
   Get hashed identifier


:ref:`Folder::getIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getIdentifier>`
   Returns the path of this folder inside the storage. It depends on the type of storage whether this is a real path or just some unique identifier.


:ref:`Folder::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getName>`
   Returns the name of this folder.


:ref:`Folder::getParentFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getParentFolder>`
   Returns the parent folder.

   In non-hierarchical storages, that always is the root folder.

   The parent folder of the root folder is the root folder.


:ref:`Folder::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getPublicUrl>`
   Returns a publicly accessible URL for this folder

   WARNING: Access to the folder may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`Folder::getReadablePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getReadablePath>`
   Returns the full path of this folder, from the root.


:ref:`Folder::getRole <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getRole>`
   Returns the role of this folder (if any). See FolderInterface::ROLE\_\* constants for possible values.


:ref:`Folder::getStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getStorage>`
   Returns the storage this folder belongs to.


:ref:`Folder::getSubfolders <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::getSubfolders>`
   Returns a list of subfolders


:ref:`Folder::hasFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::hasFile>`
   Checks if a file exists in this folder


:ref:`Folder::hasFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::hasFolder>`
   Checks if a folder exists in this folder.


:ref:`Folder::moveTo <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::moveTo>`
   Moves folder to a target folder


:ref:`Folder::prepareFiltersInStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::prepareFiltersInStorage>`
   Prepares the filters in this folder's storage according to a set filter mode.


:ref:`Folder::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::rename>`
   Renames this folder.


:ref:`Folder::restoreBackedUpFiltersInStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::restoreBackedUpFiltersInStorage>`
   Restores the filters of a storage.


:ref:`Folder::setFileAndFolderNameFilters <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::setFileAndFolderNameFilters>`
   Sets the filters to use when listing files. These are only used if the filter mode is one of FILTER\_MODE\_USE\_OWN\_FILTERS and FILTER\_MODE\_USE\_OWN\_AND\_STORAGE\_FILTERS


:ref:`Folder::setName <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::setName>`
   Sets a new name of the folder currently this does not trigger the "renaming process" as the name is more seen as a label


:ref:`Folder::updateProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\Folder::updateProperties>`
   Updates the properties of this folder, e.g. after re-indexing or moving it.



FolderInterface
===============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface`
   ...

:ref:`FolderInterface::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::delete>`
   Deletes this folder from its storage. This also means that this object becomes useless.


:ref:`FolderInterface::getSubfolder <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::getSubfolder>`
   Returns the object for a subfolder of the current folder, if it exists.


:ref:`FolderInterface::getSubfolders <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::getSubfolders>`
   Returns a list of all subfolders


:ref:`FolderInterface::hasFile <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::hasFile>`
   Checks if a file exists in this folder


:ref:`FolderInterface::hasFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::hasFolder>`
   Checks if a folder exists in this folder.


:ref:`FolderInterface::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\FolderInterface::rename>`
   Renames this folder.



FileDumpEIDHookInterface
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileDumpEIDHookInterface`
   ...

:ref:`FileDumpEIDHookInterface::checkFileAccess <t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileDumpEIDHookInterface::checkFileAccess>`
   Perform custom security/access when accessing file Method should issue 403 if access is rejected or 401 if authentication is required



FileInfoHook
============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileInfoHook`
   ...

:ref:`FileInfoHook::renderFileInfo <t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileInfoHook::renderFileInfo>`
   User function for sys\_file (element)


:ref:`FileInfoHook::renderFileInformationContent <t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileInfoHook::renderFileInformationContent>`
   Renders a HTML Block with file information


:ref:`FileInfoHook::renderFileMetadataInfo <t3api62:TYPO3\\CMS\\Core\\Resource\\Hook\\FileInfoHook::renderFileMetadataInfo>`
   User function for sys\_file\_meta (element)



InaccessibleFolder
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder`
   ...

:ref:`InaccessibleFolder::addFile <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::addFile>`
   Adds a file from the local server disk. If the file already exists and overwriting is disabled,


:ref:`InaccessibleFolder::addUploadedFile <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::addUploadedFile>`
   Adds an uploaded file into the Storage.


:ref:`InaccessibleFolder::copyTo <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::copyTo>`
   Copies folder to a target folder


:ref:`InaccessibleFolder::createFile <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::createFile>`
   Creates a new blank file


:ref:`InaccessibleFolder::createFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::createFolder>`
   Creates a new folder


:ref:`InaccessibleFolder::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::delete>`
   Deletes this folder from its storage. This also means that this object becomes useless.


:ref:`InaccessibleFolder::getFileCount <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::getFileCount>`
   Returns amount of all files within this folder, optionally filtered by the given pattern


:ref:`InaccessibleFolder::getFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::getFiles>`
   Returns a list of files in this folder, optionally filtered. There are several filter modes available, see the FILTER\_MODE\_\* constants for more information.

   For performance reasons the returned items can also be limited to a given range


:ref:`InaccessibleFolder::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::getPublicUrl>`
   Returns a publicly accessible URL for this folder

   WARNING: Access to the folder may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`InaccessibleFolder::getSubfolder <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::getSubfolder>`
   Returns the object for a subfolder of the current folder, if it exists.


:ref:`InaccessibleFolder::getSubfolders <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::getSubfolders>`
   Returns a list of subfolders


:ref:`InaccessibleFolder::hasFile <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::hasFile>`
   Checks if a file exists in this folder


:ref:`InaccessibleFolder::hasFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::hasFolder>`
   Checks if a folder exists in this folder.


:ref:`InaccessibleFolder::moveTo <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::moveTo>`
   Moves folder to a target folder


:ref:`InaccessibleFolder::rename <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::rename>`
   Renames this folder.


:ref:`InaccessibleFolder::setFileAndFolderNameFilters <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::setFileAndFolderNameFilters>`
   Sets the filters to use when listing files. These are only used if the filter mode is one of FILTER\_MODE\_USE\_OWN\_FILTERS and FILTER\_MODE\_USE\_OWN\_AND\_STORAGE\_FILTERS


:ref:`InaccessibleFolder::setName <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::setName>`
   Sets a new name of the folder currently this does not trigger the "renaming process" as the name is more seen as a label


:ref:`InaccessibleFolder::throwInaccessibleException <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::throwInaccessibleException>`
   ...

:ref:`InaccessibleFolder::updateProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\InaccessibleFolder::updateProperties>`
   Updates the properties of this folder, e.g. after re-indexing or moving it.



ExtractorInterface
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface`
   ...

:ref:`ExtractorInterface::canProcess <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::canProcess>`
   Checks if the given file can be processed by this Extractor


:ref:`ExtractorInterface::extractMetaData <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::extractMetaData>`
   The actual processing TASK

   Should return an array with database properties for sys\_file\_metadata to write


:ref:`ExtractorInterface::getDriverRestrictions <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::getDriverRestrictions>`
   Get all supported DriverClasses

   Since some extractors may only work for local files, and other extractors are especially made for grabbing data from remote.

   Returns array of string with driver names of Drivers which are supported, If the driver did not register a name, it's the classname. empty array indicates no restrictions


:ref:`ExtractorInterface::getExecutionPriority <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::getExecutionPriority>`
   ...

:ref:`ExtractorInterface::getFileTypeRestrictions <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::getFileTypeRestrictions>`
   Returns an array of supported file types; An empty array indicates all filetypes


:ref:`ExtractorInterface::getPriority <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorInterface::getPriority>`
   ...


ExtractorRegistry
=================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry`
   ...

:ref:`ExtractorRegistry::compareExtractorPriority <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry::compareExtractorPriority>`
   Compare the priority of two Extractor classes. Is used for sorting array of Extractor instances by priority. We want the result to be ordered from high to low so a higher priority comes before a lower.


:ref:`ExtractorRegistry::createExtractorInstance <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry::createExtractorInstance>`
   Create an instance of a Metadata Extractor


:ref:`ExtractorRegistry::getExtractorsWithDriverSupport <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry::getExtractorsWithDriverSupport>`
   Get Extractors which work for a special driver


:ref:`ExtractorRegistry::getInstance <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry::getInstance>`
   Returns an instance of this class


:ref:`ExtractorRegistry::registerExtractionService <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\ExtractorRegistry::registerExtractionService>`
   ...


FileIndexRepository
===================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository`
   ...

:ref:`FileIndexRepository::add <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::add>`
   Adds a file to the index


:ref:`FileIndexRepository::addRaw <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::addRaw>`
   Add data from record (at indexing time)


:ref:`FileIndexRepository::emitRecordCreatedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::emitRecordCreatedSignal>`
   Signal that is called after an IndexRecord is created


:ref:`FileIndexRepository::emitRecordDeletedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::emitRecordDeletedSignal>`
   Signal that is called after an IndexRecord is deleted


:ref:`FileIndexRepository::emitRecordUpdatedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::emitRecordUpdatedSignal>`
   Signal that is called after an IndexRecord is updated


:ref:`FileIndexRepository::findByContentHash <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findByContentHash>`
   Returns all indexed files which match the content hash Used by the indexer to detect already present files


:ref:`FileIndexRepository::findByFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findByFolder>`
   ...

:ref:`FileIndexRepository::findInStorageAndNotInUidList <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findInStorageAndNotInUidList>`
   ...

:ref:`FileIndexRepository::findInStorageWithIndexOutstanding <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findInStorageWithIndexOutstanding>`
   Finds the files needed for second indexer step


:ref:`FileIndexRepository::findOneByCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findOneByCombinedIdentifier>`
   ...

:ref:`FileIndexRepository::findOneByFileObject <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findOneByFileObject>`
   ...

:ref:`FileIndexRepository::findOneByStorageUidAndIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findOneByStorageUidAndIdentifier>`
   ...

:ref:`FileIndexRepository::findOneByStorageUidAndIdentifierHash <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findOneByStorageUidAndIdentifierHash>`
   ...

:ref:`FileIndexRepository::findOneByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::findOneByUid>`
   ...

:ref:`FileIndexRepository::getDatabaseConnection <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getDatabaseConnection>`
   Gets database instance


:ref:`FileIndexRepository::getInstance <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getInstance>`
   Returns an Instance of the Repository


:ref:`FileIndexRepository::getObjectManager <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getObjectManager>`
   Get the ObjectManager


:ref:`FileIndexRepository::getResourceFactory <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getResourceFactory>`
   ...

:ref:`FileIndexRepository::getSignalSlotDispatcher <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getSignalSlotDispatcher>`
   ...

:ref:`FileIndexRepository::getWhereClauseForFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::getWhereClauseForFile>`
   Returns a where clause to find a file in database


:ref:`FileIndexRepository::hasIndexRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::hasIndexRecord>`
   Checks if a file is indexed


:ref:`FileIndexRepository::insertRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::insertRecord>`
   Helper to reduce code duplication


:ref:`FileIndexRepository::markFileAsMissing <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::markFileAsMissing>`
   Marks given file as missing in sys\_file


:ref:`FileIndexRepository::remove <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::remove>`
   Remove a sys\_file record from the database


:ref:`FileIndexRepository::update <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::update>`
   Updates the index record in the database


:ref:`FileIndexRepository::updateIndexingTime <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository::updateIndexingTime>`
   Updates the timestamp when the file indexer extracted metadata



Indexer
=======

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer`
   ...

:ref:`Indexer::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::\_\_construct>`
   ...

:ref:`Indexer::createIndexEntry <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::createIndexEntry>`
   Create index entry


:ref:`Indexer::detectChangedFilesInStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::detectChangedFilesInStorage>`
   Adds updated files to the processing queue


:ref:`Indexer::detectMissingFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::detectMissingFiles>`
   Since by now all files in filesystem have been looked at it is save to assume, that files that are in indexed but not touched in this run are missing


:ref:`Indexer::extractRequiredMetaData <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::extractRequiredMetaData>`
   Since the core desperately needs image sizes in metadata table put them there This should be called after every "content" update and "record" creation


:ref:`Indexer::gatherFileInformationArray <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::gatherFileInformationArray>`
   Collects the information to be cached in sys\_file


:ref:`Indexer::getExtractorRegistry <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::getExtractorRegistry>`
   ...

:ref:`Indexer::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::getFileIndexRepository>`
   ...

:ref:`Indexer::getFileType <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::getFileType>`
   Maps the mimetype to a sys\_file table type


:ref:`Indexer::getMetaDataRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::getMetaDataRepository>`
   ...

:ref:`Indexer::getResourceFactory <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::getResourceFactory>`
   ...

:ref:`Indexer::processChangedAndNewFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::processChangedAndNewFiles>`
   Processes the Files which have been detected as "changed or new" in the storage


:ref:`Indexer::processChangesInStorages <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::processChangesInStorages>`
   ...

:ref:`Indexer::runMetaDataExtraction <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::runMetaDataExtraction>`
   ...

:ref:`Indexer::transformFromDriverFileInfoArrayToFileObjectFormat <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::transformFromDriverFileInfoArrayToFileObjectFormat>`
   However it happened, the properties of a file object which are persisted to the database are named different than the properties the driver returns in getFileInfo. Therefore a mapping must happen.


:ref:`Indexer::updateIndexEntry <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\Indexer::updateIndexEntry>`
   Update index entry



MetaDataRepository
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository`
   ...

:ref:`MetaDataRepository::createMetaDataRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::createMetaDataRecord>`
   Create empty


:ref:`MetaDataRepository::emitRecordCreatedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::emitRecordCreatedSignal>`
   Signal that is called after an IndexRecord is created


:ref:`MetaDataRepository::emitRecordDeletedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::emitRecordDeletedSignal>`
   Signal that is called after an IndexRecord is deleted


:ref:`MetaDataRepository::emitRecordPostRetrievalSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::emitRecordPostRetrievalSignal>`
   Signal that is called after a record has been loaded from database Allows other places to do extension of metadata at runtime or for example translation and workspace overlay


:ref:`MetaDataRepository::emitRecordUpdatedSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::emitRecordUpdatedSignal>`
   Signal that is called after an IndexRecord is updated


:ref:`MetaDataRepository::findByFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::findByFile>`
   Returns array of meta-data properties


:ref:`MetaDataRepository::findByFileUid <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::findByFileUid>`
   Retrieves metadata for file


:ref:`MetaDataRepository::getDatabaseConnection <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::getDatabaseConnection>`
   Wrapper method for getting DatabaseConnection


:ref:`MetaDataRepository::getGeneralWhereClause <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::getGeneralWhereClause>`
   General Where-Clause which is needed to fetch only language 0 and live record.


:ref:`MetaDataRepository::getInstance <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::getInstance>`
   ...

:ref:`MetaDataRepository::getObjectManager <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::getObjectManager>`
   Get the ObjectManager


:ref:`MetaDataRepository::getSignalSlotDispatcher <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::getSignalSlotDispatcher>`
   Get the SignalSlot dispatcher


:ref:`MetaDataRepository::removeByFileUid <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::removeByFileUid>`
   Remove all metadata records for a certain file from the database


:ref:`MetaDataRepository::update <t3api62:TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository::update>`
   Updates the metadata record in the database



ProcessedFile
=============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile`
   ...

:ref:`ProcessedFile::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::\_\_construct>`
   Constructor for a processed file object. Should normally not be used directly, use the corresponding factory methods instead.


:ref:`ProcessedFile::calculateChecksum <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::calculateChecksum>`
   Returns a unique checksum for this file's processing configuration and original file.


:ref:`ProcessedFile::delete <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::delete>`
   Delete processed file


:ref:`ProcessedFile::generateProcessedFileNameWithoutExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::generateProcessedFileNameWithoutExtension>`
   ...

:ref:`ProcessedFile::getIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getIdentifier>`
   Get the identifier of the file

   If there is no processed file in the file system (as the original file did not have to be modified e.g. when the original image is in the boundaries of the maxW/maxH stuff), then just return the identifier of the original file


:ref:`ProcessedFile::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getName>`
   Get the name of the file

   If there is no processed file in the file system (as the original file did not have to be modified e.g. when the original image is in the boundaries of the maxW/maxH stuff) then just return the name of the original file


:ref:`ProcessedFile::getOriginalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getOriginalFile>`
   ...

:ref:`ProcessedFile::getProcessingConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getProcessingConfiguration>`
   Returns the processing information


:ref:`ProcessedFile::getProperty <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getProperty>`
   Getter for file-properties


:ref:`ProcessedFile::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getPublicUrl>`
   Returns a publicly accessible URL for this file


:ref:`ProcessedFile::getTask <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getTask>`
   Returns the task object associated with this processed file.


:ref:`ProcessedFile::getTaskIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getTaskIdentifier>`
   Getter for the task identifier.


:ref:`ProcessedFile::getUid <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::getUid>`
   Returns the uid of this file


:ref:`ProcessedFile::isIndexed <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isIndexed>`
   Returns TRUE if this file is indexed


:ref:`ProcessedFile::isNew <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isNew>`
   ...

:ref:`ProcessedFile::isOutdated <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isOutdated>`
   Returns TRUE if the original file of this file changed and the file should be processed again.


:ref:`ProcessedFile::isPersisted <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isPersisted>`
   ...

:ref:`ProcessedFile::isProcessed <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isProcessed>`
   Returns TRUE if this file is already processed.


:ref:`ProcessedFile::isUnchanged <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isUnchanged>`
   Returns TRUE if this file has not been changed during processing (i.e., we just deliver the original file)


:ref:`ProcessedFile::isUpdated <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::isUpdated>`
   Checks whether the object since last reconstitution, and therefore needs persistence again


:ref:`ProcessedFile::needsReprocessing <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::needsReprocessing>`
   ...

:ref:`ProcessedFile::reconstituteFromDatabaseRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::reconstituteFromDatabaseRecord>`
   ...

:ref:`ProcessedFile::setContents <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::setContents>`
   Replace the current file contents with the given string


:ref:`ProcessedFile::setName <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::setName>`
   Sets a new file name


:ref:`ProcessedFile::setUsesOriginalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::setUsesOriginalFile>`
   ...

:ref:`ProcessedFile::toArray <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::toArray>`
   Basic array function for the DB update


:ref:`ProcessedFile::updateProperties <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::updateProperties>`
   ...

:ref:`ProcessedFile::updateWithLocalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::updateWithLocalFile>`
   Injects a local file, which is a processing result into the object.


:ref:`ProcessedFile::usesOriginalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFile::usesOriginalFile>`
   ...


ProcessedFileRepository
=======================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository`
   ...

:ref:`ProcessedFileRepository::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::\_\_construct>`
   Creates this object.


:ref:`ProcessedFileRepository::add <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::add>`
   Adds a processedfile object in the database


:ref:`ProcessedFileRepository::cleanUnavailableColumns <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::cleanUnavailableColumns>`
   Removes all array keys which cannot be persisted


:ref:`ProcessedFileRepository::createDomainObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::createDomainObject>`
   ...

:ref:`ProcessedFileRepository::createNewProcessedFileObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::createNewProcessedFileObject>`
   ...

:ref:`ProcessedFileRepository::findAllByOriginalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::findAllByOriginalFile>`
   ...

:ref:`ProcessedFileRepository::findByStorageAndIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::findByStorageAndIdentifier>`
   ...

:ref:`ProcessedFileRepository::findOneByOriginalFileAndTaskTypeAndConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::findOneByOriginalFileAndTaskTypeAndConfiguration>`
   ...

:ref:`ProcessedFileRepository::getLogger <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::getLogger>`
   ...

:ref:`ProcessedFileRepository::removeAll <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::removeAll>`
   Removes all processed files and also deletes the associated physical files


:ref:`ProcessedFileRepository::update <t3api62:TYPO3\\CMS\\Core\\Resource\\ProcessedFileRepository::update>`
   Updates an existing file object in the database



AbstractGraphicalTask
=====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractGraphicalTask`
   ...

:ref:`AbstractGraphicalTask::determineTargetFileExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractGraphicalTask::determineTargetFileExtension>`
   Gets the file extension the processed file should have in the filesystem by either using the configuration setting, or the extension of the original file.


:ref:`AbstractGraphicalTask::getTargetFileExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractGraphicalTask::getTargetFileExtension>`
   Determines the file extension the processed file should have in the filesystem.


:ref:`AbstractGraphicalTask::getTargetFilename <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractGraphicalTask::getTargetFilename>`
   Returns the name the processed file should have in the filesystem.



AbstractTask
============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask`
   ...

:ref:`AbstractTask::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::\_\_construct>`
   ...

:ref:`AbstractTask::getChecksumData <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getChecksumData>`
   ...

:ref:`AbstractTask::getConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getConfiguration>`
   ...

:ref:`AbstractTask::getConfigurationChecksum <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getConfigurationChecksum>`
   Returns the checksum for this task's configuration, also taking the file and task type into account.


:ref:`AbstractTask::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getName>`
   Returns the name of this task


:ref:`AbstractTask::getSourceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getSourceFile>`
   ...

:ref:`AbstractTask::getTargetFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getTargetFile>`
   ...

:ref:`AbstractTask::getTargetFileExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getTargetFileExtension>`
   Gets the file extension the processed file should have in the filesystem.


:ref:`AbstractTask::getTargetFilename <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getTargetFilename>`
   Returns the filename


:ref:`AbstractTask::getType <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::getType>`
   Returns the type of this task


:ref:`AbstractTask::isExecuted <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::isExecuted>`
   Returns TRUE if this task has been executed, no matter if the execution was successful.


:ref:`AbstractTask::isSuccessful <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::isSuccessful>`
   ...

:ref:`AbstractTask::isValidConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::isValidConfiguration>`
   Checks if the given configuration is sensible for this task, i.e. if all required parameters are given, within the boundaries and don't conflict with each other.


:ref:`AbstractTask::setExecuted <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::setExecuted>`
   Set this task executed. This is used by the Processors in order to transfer the state of this task to the file processing service.


:ref:`AbstractTask::setSourceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::setSourceFile>`
   ...

:ref:`AbstractTask::setTargetFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\AbstractTask::setTargetFile>`
   ...


FileDeletionAspect
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect`
   ...

:ref:`FileDeletionAspect::cleanupCategoryReferences <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::cleanupCategoryReferences>`
   Remove all category references of the deleted file.


:ref:`FileDeletionAspect::cleanupProcessedFilesPostFileAdd <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::cleanupProcessedFilesPostFileAdd>`
   Remove all processed files on SIGNAL\_PostFileAdd


:ref:`FileDeletionAspect::cleanupProcessedFilesPostFileReplace <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::cleanupProcessedFilesPostFileReplace>`
   Remove all processed files on SIGNAL\_PostFileReplace


:ref:`FileDeletionAspect::getDatabaseConnection <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::getDatabaseConnection>`
   Wrapper method for getting DatabaseConnection


:ref:`FileDeletionAspect::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::getFileIndexRepository>`
   Return a file index repository


:ref:`FileDeletionAspect::getMetaDataRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::getMetaDataRepository>`
   Return a metadata repository


:ref:`FileDeletionAspect::getProcessedFileRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::getProcessedFileRepository>`
   Return a processed file repository


:ref:`FileDeletionAspect::removeFromRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\FileDeletionAspect::removeFromRepository>`
   Cleanup database record for a deleted file



ImageCropScaleMaskTask
======================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImageCropScaleMaskTask`
   ...

:ref:`ImageCropScaleMaskTask::fileNeedsProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImageCropScaleMaskTask::fileNeedsProcessing>`
   Returns TRUE if the file has to be processed at all, such as e.g. the original file does.


:ref:`ImageCropScaleMaskTask::getTargetFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImageCropScaleMaskTask::getTargetFileName>`
   ...

:ref:`ImageCropScaleMaskTask::isValidConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImageCropScaleMaskTask::isValidConfiguration>`
   Checks if the given configuration is sensible for this task, i.e. if all required parameters are given, within the boundaries and don't conflict with each other.



ImagePreviewTask
================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImagePreviewTask`
   ...

:ref:`ImagePreviewTask::fileNeedsProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImagePreviewTask::fileNeedsProcessing>`
   Returns TRUE if the file has to be processed at all, such as e.g. the original file does.


:ref:`ImagePreviewTask::getTargetFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImagePreviewTask::getTargetFileName>`
   Returns the target filename for this task.


:ref:`ImagePreviewTask::isValidConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ImagePreviewTask::isValidConfiguration>`
   Checks if the given configuration is sensible for this task, i.e. if all required parameters are given, within the boundaries and don't conflict with each other.



LocalCropScaleMaskHelper
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalCropScaleMaskHelper`
   ...

:ref:`LocalCropScaleMaskHelper::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalCropScaleMaskHelper::\_\_construct>`
   ...

:ref:`LocalCropScaleMaskHelper::getConfigurationForImageCropScaleMask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalCropScaleMaskHelper::getConfigurationForImageCropScaleMask>`
   ...

:ref:`LocalCropScaleMaskHelper::getFilenameForImageCropScaleMask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalCropScaleMaskHelper::getFilenameForImageCropScaleMask>`
   Returns the filename for a cropped/scaled/masked file.


:ref:`LocalCropScaleMaskHelper::modifyImageMagickStripProfileParameters <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalCropScaleMaskHelper::modifyImageMagickStripProfileParameters>`
   Modifies the parameters for ImageMagick for stripping of profile information.



LocalImageProcessor
===================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor`
   ...

:ref:`LocalImageProcessor::canProcessTask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::canProcessTask>`
   Returns TRUE if this processor can process the given task.


:ref:`LocalImageProcessor::getGraphicalFunctionsObject <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::getGraphicalFunctionsObject>`
   ...

:ref:`LocalImageProcessor::getHelperByTaskName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::getHelperByTaskName>`
   ...

:ref:`LocalImageProcessor::getTemporaryImageWithText <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::getTemporaryImageWithText>`
   Creates error image based on gfx/notfound\_thumb.png Requires GD lib enabled, otherwise it will exit with the three textstrings outputted as text. Outputs the image stream to browser and exits!


:ref:`LocalImageProcessor::processTask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::processTask>`
   Processes the given task.


:ref:`LocalImageProcessor::wrapFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalImageProcessor::wrapFileName>`
   Escapes a file name so it can safely be used on the command line.



LocalPreviewHelper
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalPreviewHelper`
   ...

:ref:`LocalPreviewHelper::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalPreviewHelper::\_\_construct>`
   ...

:ref:`LocalPreviewHelper::generatePreviewFromFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalPreviewHelper::generatePreviewFromFile>`
   Generates a preview for a file


:ref:`LocalPreviewHelper::getTemporaryFilePath <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalPreviewHelper::getTemporaryFilePath>`
   Returns the path to a temporary file for processing


:ref:`LocalPreviewHelper::process <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\LocalPreviewHelper::process>`
   This method actually does the processing of files locally

   takes the original file (on remote storages this will be fetched from the remote server) does the IM magic on the local server by creating a temporary typo3temp/ file copies the typo3temp/ file to the processing folder of the target storage removes the typo3temp/ file



ProcessorInterface
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ProcessorInterface`
   ...

:ref:`ProcessorInterface::canProcessTask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ProcessorInterface::canProcessTask>`
   Returns TRUE if this processor can process the given task.


:ref:`ProcessorInterface::processTask <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\ProcessorInterface::processTask>`
   Processes the given task and sets the processing result in the task object.



TaskInterface
=============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface`
   ...

:ref:`TaskInterface::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::\_\_construct>`
   ...

:ref:`TaskInterface::fileNeedsProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::fileNeedsProcessing>`
   Returns TRUE if the file has to be processed at all, such as e.g. the original file does.


:ref:`TaskInterface::getConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getConfiguration>`
   Returns the configuration for this task.


:ref:`TaskInterface::getConfigurationChecksum <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getConfigurationChecksum>`
   Returns the configuration checksum of this task.


:ref:`TaskInterface::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getName>`
   Returns the name of this task.


:ref:`TaskInterface::getSourceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getSourceFile>`
   Returns the original file this task is based on.


:ref:`TaskInterface::getTargetFile <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getTargetFile>`
   Returns the processed file this task is executed on.


:ref:`TaskInterface::getTargetFileExtension <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getTargetFileExtension>`
   Gets the file extension the processed file should have in the filesystem.


:ref:`TaskInterface::getTargetFileName <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getTargetFileName>`
   Returns the name the processed file should have in the filesystem.


:ref:`TaskInterface::getType <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::getType>`
   Returns the type of this task.


:ref:`TaskInterface::isExecuted <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::isExecuted>`
   Returns TRUE if this task has been executed, no matter if the execution was successful.


:ref:`TaskInterface::isSuccessful <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::isSuccessful>`
   Returns TRUE if this task has been successfully executed. Only call this method if the task has been processed at all.


:ref:`TaskInterface::setExecuted <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskInterface::setExecuted>`
   Mark this task as executed. This is used by the Processors in order to transfer the state of this task to the file processing service.



TaskTypeRegistry
================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskTypeRegistry`
   ...

:ref:`TaskTypeRegistry::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskTypeRegistry::\_\_construct>`
   Register task types from configuration


:ref:`TaskTypeRegistry::getClassForTaskType <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskTypeRegistry::getClassForTaskType>`
   Returns the class that implements the given task type.


:ref:`TaskTypeRegistry::getTaskForType <t3api62:TYPO3\\CMS\\Core\\Resource\\Processing\\TaskTypeRegistry::getTaskForType>`
   ...


ResourceCompressor
==================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor`
   ...

:ref:`ResourceCompressor::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::\_\_construct>`
   Constructor


:ref:`ResourceCompressor::checkBaseDirectory <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::checkBaseDirectory>`
   Decides whether a file comes from one of the baseDirectories


:ref:`ResourceCompressor::compressCssFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::compressCssFile>`
   Compresses a CSS file

   Options: baseDirectories If set, only include files below one of the base directories


:ref:`ResourceCompressor::compressCssFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::compressCssFiles>`
   Compress multiple css files


:ref:`ResourceCompressor::compressCssPregCallback <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::compressCssPregCallback>`
   Callback function for preg\_replace


:ref:`ResourceCompressor::compressJsFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::compressJsFile>`
   Compresses a javascript file


:ref:`ResourceCompressor::compressJsFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::compressJsFiles>`
   Compress multiple javascript files


:ref:`ResourceCompressor::concatenateCssFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::concatenateCssFiles>`
   Concatenates the Stylesheet files

   Options: baseDirectories If set, only include files below one of the base directories


:ref:`ResourceCompressor::concatenateJsFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::concatenateJsFiles>`
   Concatenates the JavaScript files


:ref:`ResourceCompressor::createMergedCssFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::createMergedCssFile>`
   Creates a merged CSS file


:ref:`ResourceCompressor::createMergedFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::createMergedFile>`
   Creates a merged file with given file type


:ref:`ResourceCompressor::createMergedJsFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::createMergedJsFile>`
   Creates a merged JS file


:ref:`ResourceCompressor::cssFixRelativeUrlPaths <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::cssFixRelativeUrlPaths>`
   Fixes the relative paths inside of url() references in CSS files


:ref:`ResourceCompressor::cssFixStatements <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::cssFixStatements>`
   ...

:ref:`ResourceCompressor::findAndReplaceUrlPathsByRegex <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::findAndReplaceUrlPathsByRegex>`
   Finds and replaces all URLs by using a given regex


:ref:`ResourceCompressor::getFilenameFromMainDir <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::getFilenameFromMainDir>`
   Finds the relative path to a file, relative to the root path.


:ref:`ResourceCompressor::retrieveExternalFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::retrieveExternalFile>`
   Retrieves an external file and stores it locally.


:ref:`ResourceCompressor::returnFileReference <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::returnFileReference>`
   Decides whether a client can deal with gzipped content or not and returns the according file name, based on HTTP\_ACCEPT\_ENCODING


:ref:`ResourceCompressor::setBackPath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setBackPath>`
   Sets relative back path


:ref:`ResourceCompressor::setInitialBackPath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setInitialBackPath>`
   Sets relative back path


:ref:`ResourceCompressor::setInitialPaths <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setInitialPaths>`
   Sets initial values for paths.


:ref:`ResourceCompressor::setInitialRelativePath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setInitialRelativePath>`
   Sets relative path to PATH\_site


:ref:`ResourceCompressor::setInitialRootPath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setInitialRootPath>`
   Sets absolute path to working directory


:ref:`ResourceCompressor::setRelativePath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setRelativePath>`
   Sets relative path to PATH\_site


:ref:`ResourceCompressor::setRootPath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::setRootPath>`
   Sets absolute path to working directory


:ref:`ResourceCompressor::writeFileAndCompressed <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceCompressor::writeFileAndCompressed>`
   Writes $contents into file $filename together with a gzipped version into $filename.gz



ResourceFactory
===============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory`
   ...

:ref:`ResourceFactory::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::\_\_construct>`
   Inject signal slot dispatcher


:ref:`ResourceFactory::convertFlexFormDataToConfigurationArray <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::convertFlexFormDataToConfigurationArray>`
   Converts a flexform data string to a flat array with key value pairs


:ref:`ResourceFactory::createFolderObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::createFolderObject>`
   Creates a folder to directly access (a part of) a storage.


:ref:`ResourceFactory::createStorageObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::createStorageObject>`
   Creates a storage object from a storage database row.


:ref:`ResourceFactory::emitPostProcessStorageSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::emitPostProcessStorageSignal>`
   Emits a signal after a resource storage was initialized


:ref:`ResourceFactory::findBestMatchingStorageByLocalPath <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::findBestMatchingStorageByLocalPath>`
   Checks whether a file resides within a real storage in local file system. If no match is found, uid 0 is returned which is a fallback storage pointing to PATH\_site.

   The file identifier is adapted accordingly to match the new storage's base path.


:ref:`ResourceFactory::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFileIndexRepository>`
   Returns an instance of the FileIndexRepository


:ref:`ResourceFactory::getFileObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFileObject>`
   Creates an instance of the file given UID. The $fileData can be supplied to increase performance.


:ref:`ResourceFactory::getFileObjectByStorageAndIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFileObjectByStorageAndIdentifier>`
   Gets an file object from storage by file identifier If the file is outside of the process folder it gets indexed and returned as file object afterwards If the file is within processing folder the file object will be directly returned


:ref:`ResourceFactory::getFileObjectFromCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFileObjectFromCombinedIdentifier>`
   Gets an file object from an identifier [storage]:[fileId]


:ref:`ResourceFactory::getFileReferenceObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFileReferenceObject>`
   ...

:ref:`ResourceFactory::getFolderObjectFromCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getFolderObjectFromCombinedIdentifier>`
   Gets a folder object from an identifier [storage]:[fileId]


:ref:`ResourceFactory::getIndexer <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getIndexer>`
   Returns an instance of the Indexer


:ref:`ResourceFactory::getInstance <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getInstance>`
   Gets a singleton instance of this class.


:ref:`ResourceFactory::getObjectFromCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getObjectFromCombinedIdentifier>`
   Gets a file or folder object.


:ref:`ResourceFactory::getProcessedFileRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getProcessedFileRepository>`
   ...

:ref:`ResourceFactory::getStorageObjectFromCombinedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::getStorageObjectFromCombinedIdentifier>`
   Gets a storage object from a combined identifier


:ref:`ResourceFactory::retrieveFileOrFolderObject <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactory::retrieveFileOrFolderObject>`
   Bulk function, can be used for anything to get a file or folder



ResourceFactoryInterface
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceFactoryInterface`
   ...


ResourceInterface
=================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface`
   ...

:ref:`ResourceInterface::getHashedIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface::getHashedIdentifier>`
   Get hashed identifier


:ref:`ResourceInterface::getIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface::getIdentifier>`
   Returns the identifier of this file


:ref:`ResourceInterface::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface::getName>`
   Returns the name of this file


:ref:`ResourceInterface::getParentFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface::getParentFolder>`
   ...

:ref:`ResourceInterface::getStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceInterface::getStorage>`
   Get the storage this file is located in



ResourceStorage
===============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage`
   ...

:ref:`ResourceStorage::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::\_\_construct>`
   Constructor for a storage object.


:ref:`ResourceStorage::addFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::addFile>`
   Moves a file from the local filesystem to this storage.


:ref:`ResourceStorage::addFileAndFolderNameFilter <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::addFileAndFolderNameFilter>`
   ...

:ref:`ResourceStorage::addFileMount <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::addFileMount>`
   Adds a filemount as a "filter" for users to only work on a subset of a storage object


:ref:`ResourceStorage::addUploadedFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::addUploadedFile>`
   Adds an uploaded file into the Storage. Previously in ::file\_upload()


:ref:`ResourceStorage::assureFileAddPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileAddPermissions>`
   Checks if a file has the permission to be uploaded to a Folder/Storage. If not, throws an exception.


:ref:`ResourceStorage::assureFileCopyPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileCopyPermissions>`
   Check if a file has the permission to be copied on a File/Folder/Storage, if not throw an exception


:ref:`ResourceStorage::assureFileDeletePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileDeletePermissions>`
   Assures delete permission for given file.


:ref:`ResourceStorage::assureFileMovePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileMovePermissions>`
   Checks for permissions to move a file.


:ref:`ResourceStorage::assureFileReadPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileReadPermission>`
   Assures read permission for given file.


:ref:`ResourceStorage::assureFileRenamePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileRenamePermissions>`
   Checks for permissions to rename a file.


:ref:`ResourceStorage::assureFileUploadPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileUploadPermissions>`
   Checks if a file has the permission to be uploaded to a Folder/Storage. If not, throws an exception.


:ref:`ResourceStorage::assureFileWritePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFileWritePermissions>`
   Assures write permission for given file.


:ref:`ResourceStorage::assureFolderCopyPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFolderCopyPermissions>`
   Check if a file has the permission to be copied on a File/Folder/Storage, if not throw an exception


:ref:`ResourceStorage::assureFolderDeletePermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFolderDeletePermission>`
   Assures delete permission for given folder.


:ref:`ResourceStorage::assureFolderMovePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFolderMovePermissions>`
   Check if a file has the permission to be copied on a File/Folder/Storage, if not throw an exception


:ref:`ResourceStorage::assureFolderReadPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::assureFolderReadPermission>`
   Assures read permission for given folder.


:ref:`ResourceStorage::checkFileActionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::checkFileActionPermission>`
   Checks if a file operation (= action) is allowed on a File/Folder/Storage (= subject).


:ref:`ResourceStorage::checkFileExtensionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::checkFileExtensionPermission>`
   If the fileName is given, checks it against the TYPO3\_CONF\_VARS[BE][fileDenyPattern] + and if the file extension is allowed.


:ref:`ResourceStorage::checkFolderActionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::checkFolderActionPermission>`
   ...

:ref:`ResourceStorage::checkUserActionPermission <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::checkUserActionPermission>`
   Checks if the ACL settings allow for a certain action (is a user allowed to read a file or copy a folder).


:ref:`ResourceStorage::copyFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::copyFile>`
   Previously in ::func\_copy() copies a source file (from any location) in to the target folder, the latter has to be part of this storage


:ref:`ResourceStorage::copyFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::copyFolder>`
   Copies a folder.


:ref:`ResourceStorage::copyFolderBetweenStorages <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::copyFolderBetweenStorages>`
   Copies a folder between storages.


:ref:`ResourceStorage::createFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::createFile>`
   Creates a new file

   previously in ::func\_newfile()


:ref:`ResourceStorage::createFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::createFolder>`
   Creates a new folder.

   previously in ::func\_newfolder()


:ref:`ResourceStorage::deleteFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::deleteFile>`
   Previously in ::deleteFile()


:ref:`ResourceStorage::deleteFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::deleteFolder>`
   Previously in ::folder\_delete()


:ref:`ResourceStorage::dumpFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::dumpFileContents>`
   Outputs file Contents, clears output buffer first and sends headers accordingly.


:ref:`ResourceStorage::emitPostFileAddSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileAddSignal>`
   Emits the file post-add signal.


:ref:`ResourceStorage::emitPostFileCopySignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileCopySignal>`
   Emits the file post-copy signal.


:ref:`ResourceStorage::emitPostFileCreateSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileCreateSignal>`
   Emits the file post-create signal


:ref:`ResourceStorage::emitPostFileDeleteSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileDeleteSignal>`
   Emits the file post-deletion signal


:ref:`ResourceStorage::emitPostFileMoveSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileMoveSignal>`
   Emits the file post-move signal.


:ref:`ResourceStorage::emitPostFileRenameSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileRenameSignal>`
   Emits the file post-rename signal.


:ref:`ResourceStorage::emitPostFileReplaceSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileReplaceSignal>`
   Emits the file post-replace signal


:ref:`ResourceStorage::emitPostFileSetContentsSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFileSetContentsSignal>`
   Emits the file post-set-contents signal


:ref:`ResourceStorage::emitPostFolderAddSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFolderAddSignal>`
   Emits the folder post-add signal.


:ref:`ResourceStorage::emitPostFolderCopySignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFolderCopySignal>`
   Emits the folder post-copy signal.


:ref:`ResourceStorage::emitPostFolderDeleteSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFolderDeleteSignal>`
   Emits folder post-deletion signal..


:ref:`ResourceStorage::emitPostFolderMoveSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFolderMoveSignal>`
   Emits the folder post-move signal.


:ref:`ResourceStorage::emitPostFolderRenameSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPostFolderRenameSignal>`
   Emits the folder post-rename signal.


:ref:`ResourceStorage::emitPreFileAddSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileAddSignal>`
   Emits file pre-add signal.


:ref:`ResourceStorage::emitPreFileCopySignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileCopySignal>`
   Emits file pre-copy signal.


:ref:`ResourceStorage::emitPreFileDeleteSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileDeleteSignal>`
   Emits the file pre-deletion signal.


:ref:`ResourceStorage::emitPreFileMoveSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileMoveSignal>`
   Emits the file pre-move signal.


:ref:`ResourceStorage::emitPreFileRenameSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileRenameSignal>`
   Emits the file pre-rename signal


:ref:`ResourceStorage::emitPreFileReplaceSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFileReplaceSignal>`
   Emits the file pre-replace signal.


:ref:`ResourceStorage::emitPreFolderAddSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFolderAddSignal>`
   Emits the folder pre-add signal.


:ref:`ResourceStorage::emitPreFolderCopySignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFolderCopySignal>`
   Emits the folder pre-copy signal.


:ref:`ResourceStorage::emitPreFolderDeleteSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFolderDeleteSignal>`
   Emits the folder pre-deletion signal.


:ref:`ResourceStorage::emitPreFolderMoveSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFolderMoveSignal>`
   Emits the folder pre-move signal.


:ref:`ResourceStorage::emitPreFolderRenameSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreFolderRenameSignal>`
   Emits the folder pre-rename signal.


:ref:`ResourceStorage::emitPreGeneratePublicUrlSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::emitPreGeneratePublicUrlSignal>`
   Emits file pre-processing signal when generating a public url for a file or folder.


:ref:`ResourceStorage::fetchFolderListFromDriver <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::fetchFolderListFromDriver>`
   ...

:ref:`ResourceStorage::getCapabilities <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getCapabilities>`
   Returns the capabilities of this storage.


:ref:`ResourceStorage::getConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getConfiguration>`
   Gets the configuration.


:ref:`ResourceStorage::getDefaultFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getDefaultFolder>`
   Returns the default folder where new files are stored if no other folder is given.


:ref:`ResourceStorage::getDriver <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getDriver>`
   Returns the driver object belonging to this storage.


:ref:`ResourceStorage::getDriverType <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getDriverType>`
   ...

:ref:`ResourceStorage::getEvaluatePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getEvaluatePermissions>`
   Gets whether the permissions to access or write into this storage should be checked or not.


:ref:`ResourceStorage::getFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFile>`
   Gets a file by identifier.


:ref:`ResourceStorage::getFileAndFolderNameFilters <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileAndFolderNameFilters>`
   Returns the file and folder name filters used by this storage.


:ref:`ResourceStorage::getFileByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileByIdentifier>`
   Deprecated function, don't use it. Will be removed in some later revision.


:ref:`ResourceStorage::getFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileContents>`
   Get contents of a file object


:ref:`ResourceStorage::getFileFactory <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileFactory>`
   ...

:ref:`ResourceStorage::getFileForLocalProcessing <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileForLocalProcessing>`
   Copies a file from the storage for local processing.


:ref:`ResourceStorage::getFileIdentifiersInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileIdentifiersInFolder>`
   ...

:ref:`ResourceStorage::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileIndexRepository>`
   ...

:ref:`ResourceStorage::getFileInfo <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileInfo>`
   Gets information about a file.


:ref:`ResourceStorage::getFileInfoByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileInfoByIdentifier>`
   Gets information about a file by its identifier.


:ref:`ResourceStorage::getFileList <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileList>`
   Returns a list of files in a given path, filtered by some custom filter methods.


:ref:`ResourceStorage::getFileMounts <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileMounts>`
   Returns all file mounts that are registered with this storage.


:ref:`ResourceStorage::getFileProcessingService <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFileProcessingService>`
   ...

:ref:`ResourceStorage::getFilesInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFilesInFolder>`
   ...

:ref:`ResourceStorage::getFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFolder>`
   ...

:ref:`ResourceStorage::getFolderByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFolderByIdentifier>`
   Deprecated function, don't use it. Will be removed in some later revision.


:ref:`ResourceStorage::getFolderIdentifierFromFileIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFolderIdentifierFromFileIdentifier>`
   ...

:ref:`ResourceStorage::getFolderIdentifiersInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFolderIdentifiersInFolder>`
   ...

:ref:`ResourceStorage::getFolderList <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFolderList>`
   Returns a list of folders in a given path.


:ref:`ResourceStorage::getFoldersInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getFoldersInFolder>`
   ...

:ref:`ResourceStorage::getIndexer <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getIndexer>`
   Gets the Indexer.


:ref:`ResourceStorage::getName <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getName>`
   Returns the name of this storage.


:ref:`ResourceStorage::getObjectManager <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getObjectManager>`
   Gets the ObjectManager.


:ref:`ResourceStorage::getProcessingFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getProcessingFolder>`
   Getter function to return the folder where the files can be processed. Does not check for access rights here.


:ref:`ResourceStorage::getPublicUrl <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getPublicUrl>`
   Returns a publicly accessible URL for a file.

   WARNING: Access to the file may be restricted by further means, e.g. some web-based authentication. You have to take care of this yourself.


:ref:`ResourceStorage::getRole <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getRole>`
   Gets the role of a folder.


:ref:`ResourceStorage::getRootLevelFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getRootLevelFolder>`
   Returns the folders on the root level of the storage or the first mount point of this storage for this user if $respectFileMounts is set.


:ref:`ResourceStorage::getSignalSlotDispatcher <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getSignalSlotDispatcher>`
   Get the SignalSlot dispatcher.


:ref:`ResourceStorage::getStorageRecord <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getStorageRecord>`
   Gets the storage record.


:ref:`ResourceStorage::getUid <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getUid>`
   Returns the UID of this storage.


:ref:`ResourceStorage::getUniqueName <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::getUniqueName>`
   Returns the destination path/fileName of a unique fileName/foldername in that path. If $theFile exists in $theDest (directory) the file have numbers appended up to $this->maxNumber. Hereafter a unique string will be appended. This function is used by fx. TCEmain when files are attached to records and needs to be uniquely named in the uploads/\* folders


:ref:`ResourceStorage::hasCapability <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasCapability>`
   Returns TRUE if this storage has the given capability.


:ref:`ResourceStorage::hasChildren <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasChildren>`
   Tells whether there are children in this storage.


:ref:`ResourceStorage::hasFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasFile>`
   Returns TRUE if the specified file exists


:ref:`ResourceStorage::hasFileInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasFileInFolder>`
   Checks if the queried file in the given folder exists


:ref:`ResourceStorage::hasFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasFolder>`
   Returns TRUE if the specified folder exists.


:ref:`ResourceStorage::hasFolderInFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hasFolderInFolder>`
   Checks if the given file exists in the given folder


:ref:`ResourceStorage::hashFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hashFile>`
   Creates a (cryptographic) hash for a file.


:ref:`ResourceStorage::hashFileByIdentifier <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::hashFileByIdentifier>`
   Creates a (cryptographic) hash for a fileIdentifier.


:ref:`ResourceStorage::isBrowsable <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isBrowsable>`
   ...

:ref:`ResourceStorage::isDefault <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isDefault>`
   ...

:ref:`ResourceStorage::isOnline <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isOnline>`
   ...

:ref:`ResourceStorage::isProcessingFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isProcessingFolder>`
   Returns TRUE if folder that is in current storage is set as processing folder for one of the existing storages


:ref:`ResourceStorage::isPublic <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isPublic>`
   ...

:ref:`ResourceStorage::isWithinFileMountBoundaries <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isWithinFileMountBoundaries>`
   Checks if the given subject is within one of the registered user file mounts. If not, working with the file is not permitted for the user.


:ref:`ResourceStorage::isWithinFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isWithinFolder>`
   Checks if a resource (file or folder) is within the given folder


:ref:`ResourceStorage::isWithinProcessingFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isWithinProcessingFolder>`
   Returns TRUE if the specified file is in a folder that is set a processing for a storage


:ref:`ResourceStorage::isWritable <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::isWritable>`
   Returns TRUE if this storage is writable. This is determined by the driver and the storage configuration; user permissions are not taken into account.


:ref:`ResourceStorage::markAsPermanentlyOffline <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::markAsPermanentlyOffline>`
   Blows the "fuse" and marks the storage as offline.

   Can only be modified by an admin.

   Typically, this is only done if the configuration is wrong.


:ref:`ResourceStorage::markAsTemporaryOffline <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::markAsTemporaryOffline>`
   Marks this storage as offline for the next 5 minutes.

   Non-permanent: This typically happens for remote storages that are "flaky" and not available all the time.


:ref:`ResourceStorage::moveFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::moveFile>`
   Moves a $file into a $targetFolder the target folder has to be part of this storage

   previously in ::func\_move()


:ref:`ResourceStorage::moveFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::moveFolder>`
   Moves a folder. If you want to move a folder from this storage to another one, call this method on the target storage, otherwise you will get an exception.


:ref:`ResourceStorage::moveFolderBetweenStorages <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::moveFolderBetweenStorages>`
   Moves the given folder from a different storage to the target folder in this storage.


:ref:`ResourceStorage::processFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::processFile>`
   ...

:ref:`ResourceStorage::renameFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::renameFile>`
   Previously in ::func\_rename()


:ref:`ResourceStorage::renameFolder <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::renameFolder>`
   Previously in ::folder\_move()


:ref:`ResourceStorage::replaceFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::replaceFile>`
   Replaces a file with a local file (e.g. a freshly uploaded file)


:ref:`ResourceStorage::resetFileAndFolderNameFiltersToDefault <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::resetFileAndFolderNameFiltersToDefault>`
   ...

:ref:`ResourceStorage::setConfiguration <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setConfiguration>`
   Sets the configuration.


:ref:`ResourceStorage::setDefault <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setDefault>`
   ...

:ref:`ResourceStorage::setDriver <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setDriver>`
   Sets the storage that belongs to this storage.


:ref:`ResourceStorage::setEvaluatePermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setEvaluatePermissions>`
   Sets whether the permissions to access or write into this storage should be checked or not.


:ref:`ResourceStorage::setFileAndFolderNameFilters <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setFileAndFolderNameFilters>`
   ...

:ref:`ResourceStorage::setFileContents <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setFileContents>`
   Set contents of a file object.


:ref:`ResourceStorage::setUserPermissions <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::setUserPermissions>`
   Sets the user permissions of the storage.


:ref:`ResourceStorage::unsetFileAndFolderNameFilters <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::unsetFileAndFolderNameFilters>`
   Unsets the file and folder name filters, thus making this storage return unfiltered file lists.


:ref:`ResourceStorage::updateProcessedFile <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::updateProcessedFile>`
   Updates a processed file with a new file from the local filesystem.


:ref:`ResourceStorage::usesCaseSensitiveIdentifiers <t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorage::usesCaseSensitiveIdentifiers>`
   Returns TRUE if the identifiers used by this storage are case-sensitive.



ResourceStorageInterface
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\ResourceStorageInterface`
   ...


FileMetadataPermissionsAspect
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\FileMetadataPermissionsAspect`
   ...

:ref:`FileMetadataPermissionsAspect::checkFileWriteAccessForFileMetaData <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\FileMetadataPermissionsAspect::checkFileWriteAccessForFileMetaData>`
   Checks write access to the file belonging to a metadata entry


:ref:`FileMetadataPermissionsAspect::checkModifyAccessList <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\FileMetadataPermissionsAspect::checkModifyAccessList>`
   ...

:ref:`FileMetadataPermissionsAspect::checkRecordUpdateAccess <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\FileMetadataPermissionsAspect::checkRecordUpdateAccess>`
   This hook is called before any write operation by DataHandler


:ref:`FileMetadataPermissionsAspect::isAllowedToShowEditForm <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\FileMetadataPermissionsAspect::isAllowedToShowEditForm>`
   Deny access to the edit form. This is not mandatory, but better to show this right away that access is denied.



StoragePermissionsAspect
========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\StoragePermissionsAspect`
   ...

:ref:`StoragePermissionsAspect::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\StoragePermissionsAspect::\_\_construct>`
   ...

:ref:`StoragePermissionsAspect::addFileMountsToStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\StoragePermissionsAspect::addFileMountsToStorage>`
   Adds file mounts from the user's file mount records


:ref:`StoragePermissionsAspect::addUserPermissionsToStorage <t3api62:TYPO3\\CMS\\Core\\Resource\\Security\\StoragePermissionsAspect::addUserPermissionsToStorage>`
   ...


FileProcessingService
=====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService`
   ...

:ref:`FileProcessingService::emitPostFileProcessSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService::emitPostFileProcessSignal>`
   Emits file post-processing signal.


:ref:`FileProcessingService::emitPreFileProcessSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService::emitPreFileProcessSignal>`
   Emits file pre-processing signal.


:ref:`FileProcessingService::getSignalSlotDispatcher <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService::getSignalSlotDispatcher>`
   Get the SignalSlot dispatcher



FrontendContentAdapterService
=============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FrontendContentAdapterService`
   ...

:ref:`FrontendContentAdapterService::fieldIsInType <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FrontendContentAdapterService::fieldIsInType>`
   Check if fieldis in type


:ref:`FrontendContentAdapterService::getPageRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FrontendContentAdapterService::getPageRepository>`
   ...

:ref:`FrontendContentAdapterService::registerAdditionalTypeForMigration <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FrontendContentAdapterService::registerAdditionalTypeForMigration>`
   Registers an additional record type for an existing migration configuration.

   For use in ext\_localconf.php files.


:ref:`FrontendContentAdapterService::registerFieldForMigration <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\FrontendContentAdapterService::registerFieldForMigration>`
   Registers an additional field for migration.

   For use in ext\_localconf.php files



IndexerService
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService`
   ...

:ref:`IndexerService::__construct <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::\_\_construct>`
   empty constructor, nothing to do here yet


:ref:`IndexerService::emitPostFileIndexSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPostFileIndexSignal>`
   Signal that is called after a file object was indexed


:ref:`IndexerService::emitPostGatherFileInformationSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPostGatherFileInformationSignal>`
   Signal that is called after a file object was indexed


:ref:`IndexerService::emitPostMultipleFilesIndexSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPostMultipleFilesIndexSignal>`
   Signal that is called after multiple file objects were indexed


:ref:`IndexerService::emitPreFileIndexSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPreFileIndexSignal>`
   Signal that is called before a file object was indexed


:ref:`IndexerService::emitPreGatherFileInformationSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPreGatherFileInformationSignal>`
   Signal that is called before the file information is fetched helpful if somebody wants to preprocess the record information


:ref:`IndexerService::emitPreMultipleFilesIndexSignal <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::emitPreMultipleFilesIndexSignal>`
   Signal that is called before a bunch of file objects are indexed


:ref:`IndexerService::gatherFileInformation <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::gatherFileInformation>`
   Fetches the information for a sys\_file record based on a single file this function shouldn't be used, if someone needs to fetch the file information from a file object, should be done by getProperties etc


:ref:`IndexerService::getFactory <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getFactory>`
   Getter function for the fileFactory


:ref:`IndexerService::getFileIndexRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getFileIndexRepository>`
   ...

:ref:`IndexerService::getMetaDataRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getMetaDataRepository>`
   ...

:ref:`IndexerService::getObjectManager <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getObjectManager>`
   Get the ObjectManager


:ref:`IndexerService::getRepository <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getRepository>`
   Internal function to retrieve the file repository, if it does not exist, an instance will be created


:ref:`IndexerService::getSignalSlotDispatcher <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::getSignalSlotDispatcher>`
   Get the SignalSlot dispatcher


:ref:`IndexerService::indexFiles <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService::indexFiles>`
   Indexes an array of file objects currently this is done in a simple way, however could be changed to be more performant



MagicImageService
=================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\MagicImageService`
   ...

:ref:`MagicImageService::createMagicImage <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\MagicImageService::createMagicImage>`
   Creates a magic image


:ref:`MagicImageService::setMagicImageMaximumDimensions <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\MagicImageService::setMagicImageMaximumDimensions>`
   Set maximum dimensions of magic images based on RTE configuration



UserFileInlineLabelService
==========================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserFileInlineLabelService`
   ...

:ref:`UserFileInlineLabelService::getInlineLabel <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserFileInlineLabelService::getInlineLabel>`
   Get the user function label for the file\_reference table



UserFileMountService
====================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserFileMountService`
   ...

:ref:`UserFileMountService::getSubfoldersForOptionList <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserFileMountService::getSubfoldersForOptionList>`
   Simple function to make a hierarchical subfolder request into a "flat" option list



UserStorageCapabilityService
============================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserStorageCapabilityService`
   ...

:ref:`UserStorageCapabilityService::renderFileInformationContent <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserStorageCapabilityService::renderFileInformationContent>`
   Renders a HTML block containing the checkbox for field "is\_public".


:ref:`UserStorageCapabilityService::renderIsPublic <t3api62:TYPO3\\CMS\\Core\\Resource\\Service\\UserStorageCapabilityService::renderIsPublic>`
   UserFunc function for rendering field "is\_public". There are some edge cases where "is\_public" can never be marked as true in the BE, for instance for storage located outside the document root or for storages driven by special driver such as Flickr, ...



StorageRepository
=================

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\StorageRepository`
   ...

:ref:`StorageRepository::createDomainObject <t3api62:TYPO3\\CMS\\Core\\Resource\\StorageRepository::createDomainObject>`
   Creates an object managed by this repository.


:ref:`StorageRepository::findByUid <t3api62:TYPO3\\CMS\\Core\\Resource\\StorageRepository::findByUid>`
   ...

:ref:`StorageRepository::initializeLocalCache <t3api62:TYPO3\\CMS\\Core\\Resource\\StorageRepository::initializeLocalCache>`
   Initializes the Storage


:ref:`StorageRepository::testCaseSensitivity <t3api62:TYPO3\\CMS\\Core\\Resource\\StorageRepository::testCaseSensitivity>`
   Test if the local filesystem is case sensitive



BackendUtility
==============

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Utility\\BackendUtility`
   ...


ListUtility
===========

:ref:`t3api62:TYPO3\\CMS\\Core\\Resource\\Utility\\ListUtility`
   ...

