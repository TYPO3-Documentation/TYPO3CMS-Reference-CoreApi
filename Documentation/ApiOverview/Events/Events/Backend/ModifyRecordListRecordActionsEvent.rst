..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordListHeaderColumnsEvent
..  _ModifyRecordListRecordActionsEvent:


====================================
`ModifyRecordListRecordActionsEvent`
====================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListRecordActionsEvent`
allows to modify the displayed record actions (for example
:guilabel:`edit`, :guilabel:`copy`, :guilabel:`delete`) for a table in
the record list.

..  _modify-record-list-record-actions-event-usage:

Usage
=====

See :ref:`combined usage example <ModifyRecordListTableActionsEvent-usage>`.

..  _modify-record-list-record-actions-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyRecordListRecordActionsEvent.rst.txt
