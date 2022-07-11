.. include:: /Includes.rst.txt


.. _AfterFileAddedEvent:


===================
AfterFileAddedEvent
===================

This event is fired after a file was added to the Resource Storage / Driver.

Use case: Using listeners for this event allows to e.g. post-check permissions or
specific analysis of files like additional metadata analysis after adding them to TYPO3.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/AfterFileAddedEvent.rst.txt
