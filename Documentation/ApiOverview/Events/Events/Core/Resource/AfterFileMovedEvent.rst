..  include:: /Includes.rst.txt
..  index:: Events; AfterFileMovedEvent
..  _AfterFileMovedEvent:

===================
AfterFileMovedEvent
===================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileMovedEvent`
is fired after a file was moved within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

*Example*: Use this to update custom third-party handlers that rely on specific
paths.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileMovedEvent.rst.txt
