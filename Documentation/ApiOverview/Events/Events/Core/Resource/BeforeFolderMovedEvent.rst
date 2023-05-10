..  include:: /Includes.rst.txt
..  index:: Events; BeforeFolderMovedEvent
..  _BeforeFolderMovedEvent:

======================
BeforeFolderMovedEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFolderMovedEvent` is
fired before a folder is about to be moved to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
Listeners can be used to modify a folder name before it is actually moved or to
ensure consistency or specific rules when moving folders.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFolderMovedEvent.rst.txt
