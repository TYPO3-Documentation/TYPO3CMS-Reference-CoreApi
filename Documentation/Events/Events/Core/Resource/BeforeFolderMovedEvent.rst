.. include:: /Includes.rst.txt
.. index:: Events; BeforeFolderMovedEvent
.. _BeforeFolderMovedEvent:


======================
BeforeFolderMovedEvent
======================

This event is fired before a folder is about to be moved to the Resource Storage / Driver.
Listeners can be used to modify a folder name before it is actually moved or to ensure consistency
or specific rules when moving folders.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/BeforeFolderMovedEvent.rst.txt
