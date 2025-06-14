..  include:: /Includes.rst.txt
..  index:: Events; ModifyQueryBeforeFetchingObjectCountEvent
..  _ModifyQueryBeforeFetchingObjectCountEvent:

=========================================
ModifyQueryBeforeFetchingObjectCountEvent
=========================================

..  versionadded:: 14.0
    The event :php:`_ModifyQueryBeforeFetchingObjectCountEvent` was
    introduced

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectCountEvent`
is fired before the storage backend has asked for results count
from a given query.

API
===

..  include:: /CodeSnippets/Events/Extbase/ModifyQueryBeforeFetchingObjectCountEvent.rst.txt
