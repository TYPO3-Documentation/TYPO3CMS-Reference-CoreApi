:navigation-title: File mounts

..  include:: /Includes.rst.txt
..  index::
    Backend; File mounts
    pair: Backend; File abstraction layer
    File mounts
..  _access-filemounts-more:

======================
More about file mounts
======================

File mounts require a little more description of the concepts provided
by TYPO3. All files are handled by an application layer called
the "File Abstraction Layer" (FAL). You can find more information
about the basic concepts of :ref:`FAL <fal-concepts>`.

The FAL is comprised of the following components:

Drivers
  Drivers are what makes it possible to access a given type of media
  storage. The Core provides a driver to access the local file system.
  Extensions exist that provide a driver for remote systems, like SFTP
  or platforms like Amazon S3.

Storages
  A file storage uses a driver to connect to a given storage system.
  It is defined by a path pointing into that storage system. There can
  be several storages using the same driver and pointing to different
  "directories". The storage configuration depends on the driver it uses.

  Thanks to the storage and its driver, the user is able to browse
  files from within the TYPO3 backend as if they were stored locally.

File mounts
  As discussed before, a file mount is the element which is used to
  actually give access to users to some directories. A file mount is always
  related to a storage.

..  index::
    File mounts; create

..  _access-filemounts-create:

Create a new file mount
=======================

To create a new file mount go to the module :guilabel:`Media` and create the
folder for the mount if it didn't exist yet. Then open the context menu on that
folder and choose :guilabel:`New File mount`, then give the new file mount a name.
The entry point is already set.

It is also possible to create a file mount manually in the :guilabel:`List`
module by creating a record of type :php:`Filemount`. In this case you have
to choose the storage and folder manually.

..  _access-filemounts-file-extensions:

File extensions of a file mount
===============================

The field :guilabel:`Allowed file extensions` of a file mount takes a
comma-separated list such as `jpg,png,webp`. Users of the mount can only
add files with these extensions to its folder. Use it to split one storage
into folders for different purposes, for example :path:`/images/` and
:path:`/documents/` in :path:`fileadmin/`. An empty field allows every file
extension.

TYPO3 checks the same operations as for the
`allowed file extensions of a storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-file-extensions>`_.
Moving a folder also checks the visible files it contains.

The permissions of file mounts add up. A file extension is allowed in a
folder if any writable file mount of the user that contains this folder
allows it. A file mount without a list therefore lifts the restriction of a
file mount for one of its subfolders. If several groups mount the same folder
for a user, TYPO3 combines their lists.

File mounts apply only to backend users without admin rights. For
administrators, frontend uploads, console commands, and other code, only the
option of the storage applies.

..  versionadded:: 15.0
    :changelog: feature-103594-1791966674

..  index::
    TYPO3_CONF_VARS; BE lockRootPath
    Local driver storage
    Path: fileadmin
..  _access-filemounts-more-local-driver:

Paths for local driver storage
==============================

The file storages based on the "local file system" driver take the option
`basePath`. An absolute path starts at the root of the file system, for
example `/` on Unix systems. A relative path starts at the project path, for
example `public/fileadmin/` in a Composer-based installation. See
`Options of the Local driver <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-local>`_.

..  attention::

    If the :file:`fileadmin/` location is not changed, be aware
    that all files beneath it will be accessible via a browser,
    since this directory is located below the web root. This is
    perfectly fine in most cases, and indeed generally a desired
    behavior. Be careful what kind of files you store in that
    place, as they will be publicly accessible.

Paths outside of the project path must be explicitly declared in the global
configuration option
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath']`. Any absolute
path that you want to declare in a file storage needs to have its
first part match one of the values of
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath']`
(or the project path, which can be retrieved with
:php-short:`\TYPO3\CMS\Core\Core\Environment::getProjectPath()`).

As an example, let's say you want to define two storages, one
pointing to :file:`/home/foo/bar` and one pointing to
:file:`/home/foo/baz`. You could add `/home/foo/` to
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath']`.

..  index::
    TYPO3_CONF_VARS; BE userHomePath
    TYPO3_CONF_VARS; BE groupHomePath
    TYPO3_CONF_VARS; BE userUploadDir
    Home directories
    TSconfig; DefaultUploadFolder
..  _access-filemounts-home-directories:

Home directories
================

TYPO3 CMS also features the concept of "home directories". These are paths
that are automatically mounted if they are present at a path
configured in the global configuration. Thus they don't need to have a file
mount record representing them - they just need a properly named
directory to be present.

..  note::

    That last sentence is important. The directories need to exist.
    They are not created automatically.


The parent directory of user/group home directories is defined by
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['userHomePath']` and
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['groupHomePath']`
respectively. Let's say we define the following:

..  code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['userHomePath'] = '1:user_homes/';


The first part of the definition (before the colon `:`) is
the id of a file storage. The second part is a path relative to
that file storage. Assuming file storage with a uid of "1" is the
default one pointing to :file:`fileadmin/`, the following path
needs to exist on the server: :file:`/path/to/web/root/fileadmin/user_homes/`.

Then a directory needs to exist for each user. Again let's assume that
we have a user with a uid of "3" and a username of "editor", either
of those paths would have to exist:

- :file:`/path/to/web/root/fileadmin/user_homes/3/`
- :file:`/path/to/web/root/fileadmin/user_homes/3_editor/`

The second possibility is more explicit, but will break if the
username is changed.

The same goes for groups, but only using the uid.
Assuming a group called "editors" with a uid of "1",
and:

..  code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['groupHomePath'] = '1:groups/';

we have to create a directory :file:`/path/to/web/root/fileadmin/groups/1/`.

Having set up all these properties and folders, the user
should see the following when moving to the :guilabel:`Media`
module:

..  figure:: /Images/AutomaticScreenshots/UserManagement/AccessControl/AccessUserFileTree.png
    :alt: The file list with automatically mounted user and group directories


where only the first mount was explicitly assigned to that user.
A different icon visually distinguishes automatic file mounts.

..  note::

    If the :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['userUploadDir']` option is
    also used, it is appended to the user home directory name. Thus a value
    of `_uploads` would mean that our home directories become
    :file:`/path/to/web/root/fileadmin/user_homes/3_uploads/`
    or :file:`/path/to/web/root/fileadmin/user_homes/3_editor_uploads/`.

    This does not apply to group home directories.

The concept of home directories can be efficiently combined with
the TSconfig :ref:`defaultUploadFolder <t3tsref:useroptions>` option,
which automatically directs all files uploaded by the user to the
given directory.
