.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


--------
Overview
--------


The central FAL architecture consists of three layers::

                   ..........................
   Usage Layer     |      FileReference     |
                   ..........................
  Storage Layer    |      File | Folder     |
                   |         Storage        |
                   ..........................
  Driver Layer     |         Driver         |
                   ..........................

.. todo: improve this diagram

This layered architecture makes it easy to use different drivers for accessing files, while still having a consistent
interface on top of this. Having this was one of the main reasons the FAL project was initially started.

Requests will usually be sent to a File/Folder/FileReference object, be forwarded to the Storage, which in turn
then calls the driver to do the actual operations on the physical files.

The public interface of FAL (the one you should use in your extensions) consists of the File and Folder objects, the
Storage and the Services (not mentioned here). The Drivers are explicitly *not* part of the public interface, as
using them would mean to bypass all security and plausibility checks performed by the Storage.

In addition to the mentioned components, there is more inside FAL: FIXME


File references
---------------

A file reference represents a concrete usage of a file inside some content element or other database record.
Additionally, it enables users to supply custom titles, captions etc. to that particular instance of the file.

In the database, each FileReference is represented by a record in the ``sys_file_references``
table. The table has a foreign key field field pointing to the ``sys_file`` table and other fields
for the specific properties this file has in this particular usage, such as the caption text or
overlays for the title and description texts.

Creating a reference to a file requires the file to be indexed first, as the reference is done through
the normal record relation handling of TYPO3, which requires

.. note::
  Technically, the FileReference implements the same interface as the File itself,
  so you have all the methods and properties of a File available in the FileReference
  as well. This makes it possible to use both files and references to them

  Additionally, there is a property "originalFile" on the FileReference which
  lets you get information about the underlying file (e.g. ``$fileReference->getOriginalFile()->getName()``).

