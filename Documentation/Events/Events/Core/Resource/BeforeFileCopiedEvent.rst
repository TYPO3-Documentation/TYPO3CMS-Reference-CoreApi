.. include:: /Includes.rst.txt
.. index:: Events; BeforeFileCopiedEvent
.. _BeforeFileCopiedEvent:


=====================
BeforeFileCopiedEvent
=====================

This event is fired before a file is about to be copied within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or metadata before it is written by the driver.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/BeforeFileCopiedEvent.rst.txt
