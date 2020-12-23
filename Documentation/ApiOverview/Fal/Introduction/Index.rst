.. include:: /Includes.rst.txt
.. _fal_introduction:

============
Introduction
============

This part of the `Core`:pn: API document contains details about the file abstraction layer (FAL),
`TYPO3 CMS`:pn:' toolbox for handling media. It explains its architecture and
concepts and details what a web site administrator should know about
FAL maintenance and permissions.

Content related assets - mostly videos and images - are accessible through
a *file abstraction layer* API and never referenced directly throughout
the system.

The API abstracts physical file assets storage within the system. It allows to
store, manipulate and access assets with different *Digital Assets Management Systems*
transparently within the system, allows high availability cloud storages
and assets providers. Assets can be enriched with meta data like description information,
authors, and copyright. This information is stored in local database tables.
All access to files used in content elements should use the FAL API.

This manual provides a number of examples showing how to use the
file abstraction layer in your own code.
