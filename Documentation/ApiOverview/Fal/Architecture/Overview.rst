.. include:: ../../../Includes.txt


.. _fal-architecture-overview:

Overview
^^^^^^^^

The FAL architecture consists of three layers:

Usage Layer
  This layer is comprised of the File References, which represent
  relations to files from any structure that may use them (pages,
  content elements or any custom structure defined by extensions).

Storage Layer
  This layer is made of several parts. First of all there are the files
  and their associated metadata. Then each file is associated with
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

This layered architecture makes it easy to use different Drivers for accessing files,
while maintaining a consistent interface for both developers (in terms of API)
and end users (via the backend).
