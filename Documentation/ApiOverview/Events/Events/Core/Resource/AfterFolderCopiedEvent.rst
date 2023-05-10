..  include:: /Includes.rst.txt
..  index:: Events; AfterFolderCopiedEvent
..  _AfterFolderCopiedEvent:

======================
AfterFolderCopiedEvent
======================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFolderCopiedEvent`
is fired after a folder was copied to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.

*Example*: Custom listeners can analyze contents of a file or add custom
permissions to a folder automatically.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFolderCopiedEvent.rst.txt
