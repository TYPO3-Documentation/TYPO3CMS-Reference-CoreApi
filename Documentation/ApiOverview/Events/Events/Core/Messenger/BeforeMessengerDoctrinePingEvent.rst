..  include:: /Includes.rst.txt
..  index:: Events; BeforeMessengerDoctrinePingEvent
..  _BeforeMessengerDoctrinePingEvent:

==================================
`BeforeMessengerDoctrinePingEvent`
==================================

..  versionadded:: 15.0
    :changelog: feature-110227-1784474977

The PSR-14 event
:php:`\TYPO3\CMS\Core\Messenger\Event\BeforeMessengerDoctrinePingEvent`
is dispatched for each open database connection before a Messenger worker
pings it ahead of a message. A stale connection is closed and reconnected.
Call :php:`skip()` to leave the connection untouched. See
`Database connections of a worker <https://docs.typo3.org/permalink/t3coreapi:message-bus-consume-command-database>`_.

..  _BeforeMessengerDoctrinePingEvent-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _BeforeMessengerDoctrinePingEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Messenger\Event\BeforeMessengerDoctrinePingEvent
