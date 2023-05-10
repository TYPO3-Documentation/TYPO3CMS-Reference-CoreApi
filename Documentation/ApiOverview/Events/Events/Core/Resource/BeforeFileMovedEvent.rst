..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileMovedEvent
..  _BeforeFileMovedEvent:

====================
BeforeFileMovedEvent
====================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileMovedEvent`
is fired before a file is about to be moved within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileMovedEvent.rst.txt
