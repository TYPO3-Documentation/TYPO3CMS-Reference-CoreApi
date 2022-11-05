..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordSummaryForLocalizationEvent
..  _AfterRecordSummaryForLocalizationEvent:

======================================
AfterRecordSummaryForLocalizationEvent
======================================

..  versionadded:: 12.0

The event is fired in the
:php:`\TYPO3\CMS\Backend\Controller\Page\RecordSummaryForLocalization` class
and allows extensions to modify the payload of the :php:`JsonResponse`.


Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    Vendor\MyExtension\EventListener\Backend\MyEventListener:
        tags:
            - name: event.listener
              identifier: 'my-extension/backend/after-record-summary-for-localization'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    use TYPO3\CMS\Backend\Controller\Event\AfterRecordSummaryForLocalizationEvent;

    final class MyEventListener
    {
        public function __invoke(AfterRecordSummaryForLocalizationEvent $event): void
        {
            // Get current records
            $records = $event->getRecords();

            // ... do something with $records

            // Set new records
            $event->setRecords($records);

            // Get current columns
            $columns = $event->getColumns();

            // ... do something with $columns

            // Set new columns
            $event->setColumns($columns);
        }
    }

API
===

.. include:: /CodeSnippets/Events/Backend/AfterRecordSummaryForLocalizationEvent.rst.txt
