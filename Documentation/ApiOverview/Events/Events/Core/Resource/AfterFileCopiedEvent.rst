..  include:: /Includes.rst.txt
..  index:: Events; AfterFileCopiedEvent
..  _AfterFileCopiedEvent:

====================
AfterFileCopiedEvent
====================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileCopiedEvent`
is fired after a file was copied within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

*Example:* Listeners can sign up for listing duplicates using this event.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileCopiedEvent.rst.txt
