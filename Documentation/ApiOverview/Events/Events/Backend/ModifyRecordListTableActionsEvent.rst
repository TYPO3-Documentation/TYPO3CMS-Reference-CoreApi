..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordListTableActionsEvent
..  _ModifyRecordListTableActionsEvent:


=================================
ModifyRecordListTableActionsEvent
=================================

..  versionadded:: 11.4

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    the event changed from
    :php:`\TYPO3\CMS\Recordlist\Event\ModifyRecordListTableActionsEvent`
    to
    :php:`\TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListTableActionsEvent`.
    For TYPO3 v12 the moved class is available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListTableActionsEvent`
allows to modify the multi record selection actions (for example
:guilabel:`edit`, :guilabel:`copy to clipboard`) for a table in the record list.

..  _ModifyRecordListTableActionsEvent-usage:

Usage
=====

An example registration of the events in your extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyRecordListTableActionsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyRecordListTableActionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyRecordListTableActionsEvent.rst.txt
