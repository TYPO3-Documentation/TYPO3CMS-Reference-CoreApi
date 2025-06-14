..  include:: /Includes.rst.txt
..  index:: Events; ModifyResultAfterFetchingObjectCountEvent
..  _ModifyResultAfterFetchingObjectCountEvent:

=========================================
ModifyResultAfterFetchingObjectCountEvent
=========================================

..  versionadded:: 14.0
    The event :php:`ModifyResultAfterFetchingObjectCountEvent` was
    introduced

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\ModifyResultAfterFetchingObjectCountEvent`
is fired after the storage backend has counted the results from a given query.

API
===

..  include:: /CodeSnippets/Events/Extbase/ModifyResultAfterFetchingObjectCountEvent.rst.txt
