..  include:: /Includes.rst.txt
..  index:: Events; AfterFileRemovedFromIndexEvent
..  _AfterFileRemovedFromIndexEvent:

==============================
AfterFileRemovedFromIndexEvent
==============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileRemovedFromIndexEvent`
is fired once a file was just removed in the database (table :sql:`sys_file`).

*Example*: A listener can further handle files and manage them separately
outside of TYPO3's index.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileRemovedFromIndexEvent.rst.txt
