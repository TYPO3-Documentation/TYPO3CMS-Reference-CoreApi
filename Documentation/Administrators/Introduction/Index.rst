
.. _admin-introduction:

Introduction / Basic Concepts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The file abstraction layer (FAL) brings a number of changes relevant to
the administrator of a TYPO3 site. This chapter is trying to shed light
on these points.


.. _admin-references:

No copies: References!
""""""""""""""""""""""

The most fundamental change the introduction of FAL brings is that
files are not copied any more for each usage but referenced instead
for each time you use it on a page.

For the editors, this means that:

* Less disk space is used: If the same image is displayed in four
  different locations on the site, only one fourth of the disk space is
  needed.
* Assets can be centrally replaced: It's possible to centrally replace
  a file with an updated version without having to change it in each
  individual place where it's used.
* Tracking usages is possible: It's possible to identify for any asset
  where it is used throughout the page and display or count the
  references to it. This makes it technically possible to display
  warnings when deleting an asset to warn the user of existing
  references to it.


.. _admin-storages:

Storages
""""""""

The central concept of FAL are storages. A storage can be seen as a
"mounted directory" either local or from remote systems. Not only
additional mounts are handled as storages, but also the main
``fileadmin`` directory. The ``fileadmin`` storage will be created
automatically when you upgrade an installation to TYPO3 6.0, but from
then on it behaves just like any other storage.

To create a new storage, just create a new "Storage" record using the
List module (Web->List) on the root page (uid=0). You can now create
any number of other Storages alongside the ``fileadmin`` directory or
even remove the initial ``fileadmin`` storage altogether or change its
location easily by editing its Storage record. (Beware that this could
break relations to the files from the content records though, unless
you move the files along on the filesystem as well.)


.. _admin-irre:

Images as IRRE-Child records
""""""""""""""""""""""""""""

When attaching images to a content record, TYPO3 CMS uses an IRRE-based
inline child record for each image where settings such as the alt or
title HTML tag can be configured along with the image link and the description.
This makes the interface for an editor much cleaner.
It removes the disadvantage of older versions where e.g. such meta data
(caption text, image link, description) had to be entered newline-separated
in different fields.

The IRRE child records are records from the "sys_file_references" table
with each child record representing a single reference from a content element
(or other table) to a file. The file is also represented by a sys_file record.
For more information regarding the database structure,
see the :ref:`Database structure <architecture-database>`.
