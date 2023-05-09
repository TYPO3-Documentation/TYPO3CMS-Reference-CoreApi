..  include:: /Includes.rst.txt
..  index:: Events; AfterFileCreatedEvent
..  _AfterFileCreatedEvent:

=====================
AfterFileCreatedEvent
=====================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileCreatedEvent`
is fired before a file was created within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

*Example:* This allows to modify a file or check for an appropriate signature
after a file was created in TYPO3.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileCreatedEvent.rst.txt
