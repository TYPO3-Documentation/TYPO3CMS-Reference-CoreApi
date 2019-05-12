.. include:: ../../../Includes.txt


.. _fal_introduction:

============
Introduction
============

This part of the Core API document contains details about the File Abstraction Layer (FAL),
TYPO3 CMS' toolbox for handling media. It explains its architecture and
concepts and details what a web site administrator should know about
FAL maintenance and permissions.

Content related assets - mostly videos and images - are accessible through
a *file abstraction layer* API and never referenced directly throughout
the system.

The API abstracts physical file assets storage within the system. It allows to
store, manipulate and access assets with different *Digital Assets Management Systems*
transparently within the system, allows high availability cloud storages
and assets providers. Assets can be enriched with meta data like description information,
authors, and copyright. This information is stored in local database tables
and all access to assets used for instance in content elements or managed
through the backend uses the FAL API.

Finally this manual provides a number of examples showing how to use the
File Abstraction Layer in your own code.
