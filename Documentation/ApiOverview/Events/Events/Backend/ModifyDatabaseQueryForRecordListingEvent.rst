..  include:: /Includes.rst.txt
..  index:: Events; ModifyDatabaseQueryForRecordListingEvent
..  _ModifyDatabaseQueryForRecordListingEvent:

========================================
ModifyDatabaseQueryForRecordListingEvent
========================================

..  versionadded:: 12.0
    This event has been introduced to replace the following removed hooks:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/class.db_list_extra.inc']['getTable']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['modifyQuery']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['makeSearchStringConstraints']`


The PSR-14 event
:php:`\TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent`
allows to alter the :ref:`query builder <database-query-builder>` SQL
statement before a list of records is rendered in record lists, such as
the :guilabel:`List` module or an element browser.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyDatabaseQueryForRecordListingEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyDatabaseQueryForRecordListingEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyDatabaseQueryForRecordListingEvent.rst.txt
