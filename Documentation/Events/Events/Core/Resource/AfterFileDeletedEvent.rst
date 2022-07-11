.. include:: /Includes.rst.txt


.. _AfterFileDeletedEvent:


======================
AfterFileDeletedEvent
======================

This event is fired after a file was deleted.

*Example*: If an extension provides additional functionality (e.g. variants),
this event allows listener to also clean
up their custom handling. This can also be used for versioning of files.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/AfterFileDeletedEvent.rst.txt
