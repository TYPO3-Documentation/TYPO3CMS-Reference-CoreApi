..  include:: /Includes.rst.txt
..  index:: pair: File abstraction layer; File collections
..  _collections:
..  _collections-records:
..  _collections-files:

================
File collections
================

File collections are collections of
:ref:`file references <fal-architecture-components-file-references>`.
They are used by the "File links" (download) content element.

..  figure:: /Images/ManualScreenshots/Fal/FileDownloadWithCollection.png
    :alt: A file links content element
    :class: with-shadow

    A "File links" content element referencing a file collection


File collections are stored in the
:ref:`sys_file_collection <fal-architecture-database-sys-file-collection>` table.
The selected files are stored in the
:ref:`sys_file_reference <fal-architecture-database-sys-file-reference>` table.

Note that a file collection may also reference a folder, in which case
all files inside the folder will be returned when calling that collection.

..  figure:: /Images/ManualScreenshots/Fal/FolderCollection.png
    :alt: A folder collection
    :class: with-shadow

    A file collection referencing a folder


..  _collections-api:

Collections API
===============

The TYPO3 Core provides an API to enable usage of collections
inside extensions. The most important classes are:

:php:`\TYPO3\CMS\Core\Resource\FileCollectionRepository`
    Used to retrieve collections. It is not exactly an
    :ref:`Extbase repository <extbase-repository>` but works in a similar way.
    The default "find" methods refer to the
    :ref:`sys_file_collection <fal-architecture-database-sys-file-collection>`
    table and will fetch "static"-type collections.

:php:`\TYPO3\CMS\Core\Resource\Collection\StaticFileCollection`
    This class models the static file collection. It is important to note
    that collections returned by the repository (described above) are "empty".
    If you need to access their records, you need to load them first, using
    method :code:`loadContents()`. On top of some specific API methods,
    this class includes all setters and getters that you may need to access
    the collection's data. For accessing the selected files, just loop
    on the collection (see example).

:php:`\TYPO3\CMS\Core\Resource\Collection\FolderBasedFileCollection`
    Similar to the :php:`StaticFileCollection`, but for file collections based
    on a folder.

:php:`\TYPO3\CMS\Core\Resource\Collection\CategoryBasedFileCollection`
    File collection based on a single :ref:`category <categories>`.


..  _collections-example:

Example
=======

The following example demonstrates the usage of collections. Here is what
happens in the controller:

..  literalinclude:: _MyController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

All collections are fetched and passed
to the view. The one specific step is the loop over all collections to load
their referenced records. Remember that a collection is otherwise "empty".

In the view we can then either use collection member variables as usual
(like their title) or put them directly in a loop to iterate over the
record selection:

..  literalinclude:: _List.html
    :language: html
    :caption: EXT:my_extension/Resources/Private/Templates/List.html

Here is what the result may look like (the exact result will obviously
depend on the content of the selection):

..  figure:: /Images/ManualScreenshots/Frontend/Fal/CollectionsOutput.png
    :alt: Collections plugin output
    :class: with-shadow

    Typical output from the "Collections" plugin

