.. include:: /Includes.rst.txt
.. index:: Events; ModifyQueryForLiveSearchEvent
.. _ModifyQueryForLiveSearchEvent:

=============================
ModifyQueryForLiveSearchEvent
=============================

.. versionadded:: 12.0

This event can be used to modify the live search queries in the backend.

This can be used to adjust the limit for a specific
table or to change the result order.

This event is fired in the
:php:`\TYPO3\CMS\Backend\Search\LiveSearch\LiveSearch` class
and allows extensions to modify the :php:`QueryBuilder` instance
before execution.

Example
=======

Registration of the event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\HrefLang\EventListener\ModifyQueryForLiveSearchEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/modify-query-for-live-search-event-listener'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/HrefLang/EventListener/MyEventListener.php

   namespace Vendor\MyExtension\HrefLang\EventListener;

   use TYPO3\CMS\Backend\Search\Event\ModifyQueryForLiveSearchEvent;

   final class ModifyQueryForLiveSearchEventListener
   {
       public function __invoke(ModifyQueryForLiveSearchEvent $event): void
       {
           // Get the current instance
           $queryBuilder = $event->getQueryBuilder();

           // Change limit depending on the table
           if ($event->getTableName() === 'pages') {
               $queryBuilder->setMaxResults(2);
           }

           // Reset the orderBy part
           $queryBuilder->resetQueryPart('orderBy');
       }
   }


API
===

.. include:: /CodeSnippets/Events/Backend/ModifyQueryForLiveSearchEvent.rst.txt
