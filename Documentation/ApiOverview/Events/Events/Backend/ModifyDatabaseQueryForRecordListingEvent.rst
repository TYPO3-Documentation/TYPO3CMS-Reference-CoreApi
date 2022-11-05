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


This event allows to alter the :ref:`QueryBuilder <database-query-builder>` SQL
statement before a list of records is rendered in record lists such as
the :guilabel:`List` module or an element browser.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\View\ModifyDatabaseQueryForRecordListingEvent:
        tags:
            - name: event.listener
              identifier: 'my-extension/backend/modify-database-query-for-record-list'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/View/ModifyDatabaseQueryForRecordListingEventListener.php

    use TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent;

    final class ModifyDatabaseQueryForRecordListingEventListener
    {
        public function __invoke(ModifyDatabaseQueryForRecordListingEvent $event): void
        {
            $queryBuilder = $event->getQueryBuilder();
            // Do something
            $event->getQueryBuilder($queryBuilder);
        }
    }

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyDatabaseQueryForRecordListingEvent.rst.txt
