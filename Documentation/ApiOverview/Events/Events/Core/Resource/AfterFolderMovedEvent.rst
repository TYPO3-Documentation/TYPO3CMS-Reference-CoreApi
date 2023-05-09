..  include:: /Includes.rst.txt
..  index:: Events; AfterFolderMovedEvent
..  _AfterFolderMovedEvent:

=====================
AfterFolderMovedEvent
=====================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFolderMovedEvent`
is fired after a folder was moved within the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
Custom references can be updated via listeners of this event.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFolderMovedEvent.rst.txt
