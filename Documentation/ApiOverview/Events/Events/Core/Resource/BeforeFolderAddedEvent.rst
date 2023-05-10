..  include:: /Includes.rst.txt
..  index:: Events; BeforeFolderAddedEvent
..  _BeforeFolderAddedEvent:

======================
BeforeFolderAddedEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFolderAddedEvent` is
fired before a folder is about to be added to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
This allows to further specify folder names according to regulations for a
specific project.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFolderAddedEvent.rst.txt
