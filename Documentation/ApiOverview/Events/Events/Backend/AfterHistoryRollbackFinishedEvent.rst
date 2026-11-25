..  include:: /Includes.rst.txt
..  index:: Events; AfterHistoryRollbackFinishedEvent
..  _AfterHistoryRollbackFinishedEvent:

===================================
`AfterHistoryRollbackFinishedEvent`
===================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\History\Event\AfterHistoryRollbackFinishedEvent`
is fired after a history record rollback finished.

When an editor undoes a whole
`operation <https://docs.typo3.org/permalink/t3coreapi:using-datahandler-undo-in-one-step>`_,
TYPO3 fires the event once for all its records. The diff then holds the
changes of several records, also from different tables.

..  _after-history-rollback-finished-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-history-rollback-finished-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Backend\History\Event\AfterHistoryRollbackFinishedEvent
