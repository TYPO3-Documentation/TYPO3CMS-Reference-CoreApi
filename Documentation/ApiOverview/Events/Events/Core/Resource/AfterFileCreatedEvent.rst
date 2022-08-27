.. include:: /Includes.rst.txt


.. _AfterFileCreatedEvent:


=====================
AfterFileCreatedEvent
=====================

This event is fired before a file was created within a Resource Storage / Driver.
The folder represents the "target folder".

*Example*: This allows to modify a file or check for an appropriate signature after a file was created in TYPO3.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/AfterFileCreatedEvent.rst.txt
