.. include:: /Includes.rst.txt
.. index:: Events; BeforeFolderDeletedEvent
.. _BeforeFolderDeletedEvent:


========================
BeforeFolderDeletedEvent
========================

This event is fired before a folder is about to be deleted.

Listeners can use this event to clean up further external references
to a folder / files in this folder.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/BeforeFolderDeletedEvent.rst.txt
