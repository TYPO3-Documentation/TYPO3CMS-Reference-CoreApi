..  include:: /Includes.rst.txt
..  index:: Events; BeforeHistoryRollbackStartEvent
..  _BeforeHistoryRollbackStartEvent:

=================================
`BeforeHistoryRollbackStartEvent`
=================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\History\Event\BeforeHistoryRollbackStartEvent`
is fired before a history record rollback starts.

When an editor undoes a whole
`operation <https://docs.typo3.org/permalink/t3coreapi:using-datahandler-undo-in-one-step>`_,
TYPO3 fires the event once for all its records. The diff then holds the
changes of several records, also from different tables.

..  _before-history-rollback-start-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-history-rollback-start-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Backend\History\Event\BeforeHistoryRollbackStartEvent
