
.. include:: ../../Includes.txt

.. _Admin-Basic-Concepts:

==============
Basic Concepts
==============

The file abstraction layer (FAL) brings a number of changes relevant to
the administrator of a TYPO3 site. This chapter is trying to shed light
on these points.


.. _Admin-References:

References
==========

No copies - but references!

The most fundamental change the File Abstraction Layer brings is that
files are not copied any more for each usage but referenced instead
each time you use it.

For the editors, this means that:

- Less disk space is used. If the same image is displayed in four
  different locations on the site, only one fourth of disk space is
  needed for this.

- Assets can be replaced centrally: It's possible to centrally replace
  a file with an updated version without having to change each
  individual place where it's used.

- Tracking of usage is possible. It's possible to identify for any asset
  where it is used throughout the page and display or count the
  references to it. This makes it technically possible to display
  warnings when deleting an asset to warn the user of existing
  references to it.


.. _Admin-Storages:

Storages
========

One more central concept of FAL is "storages". A storage can be seen as a
"mounted directory" either local or from remote systems. Not only
additional mounts are handled as storages, but also the main
:file:`fileadmin/` directory. The 'fileadmin' storage will be created
automatically when you upgrade an installation to TYPO3 6.0 or later. From
then on it behaves just like any other storage.

To create a new storage, just create a new "Storage" record in the
List module (Web->List) on the root page (uid=0). That way you can create
any number of storages besides the :file:`fileadmin` directory or
even remove the initial "fileadmin" storage altogether or change its
location easily by editing its storage record.

Beware that simply changing the storage path can break relations to the files
if you don't move the files in the filesystem as well.

Technically a storage is a record in table :ref:`DB-table-sys_file_storage`.


.. _Admin-IRRE:

Images as IRRE-Child records
============================

IRRE stands for "Inline Relational Record Editing".

When attaching images to a content record, TYPO3 CMS uses an IRRE-based
inline child record for each image where settings such as the ALT or
TITLE HTML tag can be configured along with the image link and the description.
This makes the interface for an editor much cleaner.
It removes the disadvantage of older versions where for example such meta data
like caption text, image link, and description had to be entered
newline-separated in different fields.

The IRRE child records are records from the :ref:`DB-table-sys_file_reference` table
with each child record represents a single reference from a content element
to a file. This is the same from other tables as well.

The file itself is represented by a :ref:`DB-table-sys_file` record.
