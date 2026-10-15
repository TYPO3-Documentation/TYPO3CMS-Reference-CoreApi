..  include:: /Includes.rst.txt
..  index:: Events; ModifyQueryBeforeFetchingObjectCountEvent
..  _ModifyQueryBeforeFetchingObjectCountEvent:

===========================================
`ModifyQueryBeforeFetchingObjectCountEvent`
===========================================

..  versionadded:: 14.0

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectCountEvent`
is fired before the storage backend has asked for results count
from a given query.

..  _ModifyQueryBeforeFetchingObjectCountEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectCountEvent
