.. include:: /Includes.rst.txt


.. _BeforeFileCreatedEvent:


======================
BeforeFileCreatedEvent
======================

This event is fired before a file is about to be created within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or filename before it is written by the driver.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/BeforeFileCreatedEvent.rst.txt
