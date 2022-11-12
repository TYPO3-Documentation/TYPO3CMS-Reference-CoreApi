.. include:: /Includes.rst.txt
.. index:: Events; BeforeSearchInDatabaseRecordProviderEvent
.. _BeforeSearchInDatabaseRecordProviderEvent:

=========================================
BeforeSearchInDatabaseRecordProviderEvent
=========================================

.. versionadded:: 12.1

The TYPO3 backend search (also known as "Live Search") uses the
:php:`\TYPO3\CMS\Backend\Search\LiveSearch\DatabaseRecordProvider` to search
for records in database tables, having :php:`searchFields` configured in TCA.

In some individual cases it may not be desirable to search in a specific table.
Therefore, the :php:`\TYPO3\CMS\Backend\Search\Event\BeforeSearchInDatabaseRecordProviderEvent`
event is available, which allows to exclude / ignore such tables by adding them
to a deny list. Additionally, the PSR-14 event can be used to restrict the
search result on certain page IDs or to modify the search query altogether.


Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\EventListener\BeforeSearchInDatabaseRecordProviderEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/before-search-in-database-record-provider-event-listener'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/BeforeSearchInDatabaseRecordProviderEventListener.php

    use TYPO3\CMS\Backend\Search\Event\BeforeSearchInDatabaseRecordProviderEvent;

    final class ModifyEditFileFormDataEventListener
    {
        public function __invoke(BeforeSearchInDatabaseRecordProviderEvent $event): void
        {
            $event->ignoreTable('my_custom_table');
        }
    }


API
===

.. include:: /CodeSnippets/Events/Backend/BeforeSearchInDatabaseRecordProviderEvent.rst.txt
