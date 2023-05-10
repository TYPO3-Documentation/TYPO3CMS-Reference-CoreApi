..  include:: /Includes.rst.txt
..  index:: Events; BeforeFolderCopiedEvent
..  _BeforeFolderCopiedEvent:

=======================
BeforeFolderCopiedEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFolderCopiedEvent`
is fired before a folder is about to be copied to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
Listeners could add deferred processing / queuing of large folders.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFolderCopiedEvent.rst.txt
