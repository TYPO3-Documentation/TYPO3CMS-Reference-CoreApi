.. include:: /Includes.rst.txt
.. index:: Events; RecordAccessGrantedEvent
.. _RecordAccessGrantedEvent:

========================
RecordAccessGrantedEvent
========================

.. versionadded:: 12.0
   This event serves as replacement for the removed hook
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_checkEnableFields']`.

This event can be used to either define whether record access is granted
for a user, or to modify the record in question. In case the `$accessGranted`
property is set (either :php:`true` or :php:`false`), the defined settings is
directly used, skipping any further event listener as well as any further
evaluation.

API
===

.. include:: /CodeSnippets/Manual/Core/RecordAccessGrantedEvent.rst.txt


Example
=======

Registration of the Event in your extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/set-access-granted'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/MyEventListener.php

   use TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent;

   class MyEventListener {

       public function __invoke(RecordAccessGrantedEvent $event): void
       {
           // Manually set access granted
           if ($event->getTable() === 'my_table' && ($event->getRecord()['custom_access_field'] ?? false)) {
               $event->setAccessGranted(true);
           }

           // Update the record to be checked
           $record = $event->getRecord();
           $record['some_field'] = true;
           $event->updateRecord($record);
       }
   }
