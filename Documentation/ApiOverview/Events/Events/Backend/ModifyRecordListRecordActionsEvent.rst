..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordListHeaderColumnsEvent
..  _ModifyRecordListRecordActionsEvent:


==================================
ModifyRecordListRecordActionsEvent
==================================

..  versionadded:: 11.4

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    the event changed from
    :php:`TYPO3\CMS\Recordlist\Event\ModifyRecordListRecordActionsEvent`
    to
    :php:`TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListRecordActionsEvent`.
    For TYPO3 v12 the moved class is available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

An event to modify the displayed record actions (for example
:guilabel:`edit`, :guilabel:`copy`, :guilabel:`delete`) for a table in
the record list.

Usage
=====

See :ref:`combined usage example <ModifyRecordListTableActionsEvent-usage>`.

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyRecordListRecordActionsEvent.rst.txt
