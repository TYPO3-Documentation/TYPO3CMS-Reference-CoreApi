.. include:: ../../Includes.txt


.. _architecture-overview:

Overview
^^^^^^^^

The FAL architecture consists of three layers:

Usage Layer
  This layer is comprised of the File References, which represent
  relations to files from any structure that may use them (pages,
  content elements or any custom structure defined by extensions).

Storage Layer
  This layer is made of several parts. First of all come the Files
  and their associated metadata. Then each File is associated with
  a Storage.

Driver Layer
  This layer is the deepest one. It consists of the Drivers, managing
  the actual access to and manipulation of the files. It is invisible
  from both the frontend and the backend, as it works just in the
  background.

  Indeed Drivers are explicitly *not* part of the public interface.
  Developers will only interact with File, Folder, FileReference or
  Storage objects, but never with a Driver object, unless actually
  developing one.

This layered architecture makes it easy to use different drivers for accessing files,
while maintaining a consistent interface for both delvopers (in terms of API)
and end users (via the backend).


.. _architecture-references:

File references
~~~~~~~~~~~~~~~

A file reference represents a concrete usage of a file inside some content element or other database record.
Additionally, it enables users to supply custom titles, captions etc. to that particular instance of the file.

In the database, each FileReference is represented by a record in the ``sys_file_references``
table. The table has a foreign key field pointing to the ``sys_file`` table and other fields
for the specific properties this file has in this particular usage, such as the caption text or
overlays for the title and description texts.

Creating a reference to a file requires the file to be indexed first, as the reference is done through
the normal record relation handling of TYPO3 CMS.

.. note::

   Technically, the FileReference implements the same interface as the File itself.
   So you have all the methods and properties of a File available in the FileReference
   as well. This makes it possible to use both files and references to them

   Additionally, there is a property "originalFile" on the FileReference which
   lets you get information about the underlying file (e.g.
   ``$fileReference->getOriginalFile()->getName()``).

