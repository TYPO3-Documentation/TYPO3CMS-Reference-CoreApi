..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordListTableActionsEvent
..  _ModifyRecordListTableActionsEvent:


=================================
ModifyRecordListTableActionsEvent
=================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListTableActionsEvent`
allows to modify the multi record selection actions (for example
:guilabel:`edit`, :guilabel:`copy to clipboard`) for a table in the record list.

..  _ModifyRecordListTableActionsEvent-usage:

Example
=======

..  literalinclude:: _ModifyRecordListTableActionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyRecordListTableActionsEvent.rst.txt
