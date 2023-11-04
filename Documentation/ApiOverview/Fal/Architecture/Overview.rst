..   include:: /Includes.rst.txt
..  _fal-architecture-overview:

========
Overview
========

The file abstraction layer (FAL) architecture consists of three layers:

Usage layer
    This layer is comprised of the
    :ref:`file references <fal-architecture-components-file-references>`, which
    represent relations to files from any structure that may use them (pages,
    content elements or any custom structure defined by extensions).

Storage layer
    This layer is made of several parts. First of all there are the
    :ref:`files <fal-architecture-components-files-folders>`
    and their associated
    :ref:`metadata <fal-architecture-database-sys-file-metadata>`. Then each
    file is associated with
    a :ref:`storage <fal-architecture-components-storage>`.

Driver layer
    This layer is the deepest one. It consists of the
    :ref:`drivers <fal-architecture-components-drivers>`, managing
    the actual access to and manipulation of the files. It is invisible
    from both the frontend and the backend, as it works just in the
    background.

    Indeed drivers are explicitly *not* part of the public interface.
    Developers will only interact with
    :ref:`file, folder <fal-architecture-components-files-folders>`,
    :ref:`file reference <fal-architecture-components-file-references>` or
    :ref:`storage <fal-architecture-components-storage>` objects, but never with
    a driver object, unless actually developing one.

This layered architecture makes it easy to use different drivers for accessing files,
while maintaining a consistent interface for both developers (in terms of API)
and end users (via the backend).
