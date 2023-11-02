..  include:: /Includes.rst.txt
..  index::
    ! File abstraction layer
    FAL
    Digital assets management
    see: Digital assets management; FAL
    see: File abstraction layer; FAL
..  _fal:
..  _fal_introduction:

============================
File abstraction layer (FAL)
============================

The file abstraction layer (FAL) is TYPO3's toolbox for handling media. This
chapter explains its :ref:`architecture <fal-architecture>`,
:ref:`concepts <fal-concepts>` and details what a
:ref:`web site administrator <fal-administration>` should know
about FAL :ref:`maintenance <fal-administration-maintenance>` and
:ref:`permissions <fal-administration-permissions>`.

Content related assets - mostly videos and images - are accessible through
a *file abstraction layer* API and never referenced directly throughout
the system.

The :ref:`API <using-fal>` abstracts physical file assets storage within the system. It allows to
store, manipulate and access assets with different *Digital Assets Management Systems*
transparently within the system, allows high availability cloud storages
and assets providers. Assets can be enriched with meta data like description information,
authors, and copyright. This information is stored in local database tables.
All access to files used in content elements should use the FAL API.

This chapter provides a number of examples showing how to use the
file abstraction layer in your own code.


**Contents:**

..  toctree::
    :titlesonly:

    Concepts/Index
    Architecture/Index
    Administration/Index
    UsingFal/Index
    Collections/Index
