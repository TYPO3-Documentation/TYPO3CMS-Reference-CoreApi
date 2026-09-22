..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordListHeaderColumnsEvent
..  _ModifyRecordListRecordActionsEvent:


====================================
`ModifyRecordListRecordActionsEvent`
====================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListRecordActionsEvent`
allows the displayed record actions (for example
:guilabel:`edit`, :guilabel:`copy`, :guilabel:`delete`) to be modified for a
table in the record list.

..  versionchanged:: 14.0
    Actions are now button components instead of HTML strings, and
    primary and secondary actions are set by the
    :php-short:`\TYPO3\CMS\Backend\Template\Components\ActionGroup` enum. See
    `Breaking: #107884 - Rework actions to use Buttons API with Components
    <https://docs.typo3.org/permalink/changelog:breaking-107884-1730135000>`_.

..  _modify-record-list-record-actions-event-usage:

Usage
=====

See :ref:`combined usage example <ModifyRecordListTableActionsEvent-usage>`.

..  _modify-record-list-record-actions-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyRecordListRecordActionsEvent.rst.txt
