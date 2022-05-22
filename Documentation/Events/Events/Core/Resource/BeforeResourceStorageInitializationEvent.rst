.. include:: /Includes.rst.txt
.. index:: Events; BeforeResourceStorageInitializationEvent
.. _BeforeResourceStorageInitializationEvent:


========================================
BeforeResourceStorageInitializationEvent
========================================

This event is fired before a resource object is actually built/created.
*Example*: A database record can be enriched to add dynamic values to each resource (file/folder) before
creation of a storage.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/BeforeResourceStorageInitializationEvent.rst.txt
