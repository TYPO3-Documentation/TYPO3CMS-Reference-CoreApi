.. include:: /Includes.rst.txt
.. index:: Events; AddJavaScriptModulesEvent
.. _AddJavaScriptModulesEvent:


=========================
AddJavaScriptModulesEvent
=========================

JavaScript events in custom User Settings Configuration options should no longer be placed as inline JavaScript. Instead, use a dedicated JavaScript module to handle custom events.


Example
=======

A listener using mentioned PSR-14 event could look like the following.

.. rst-class:: bignums

   1. Register listener

      :file:`typo3conf/my-extension/Configuration/Services.yaml`

      .. code-block:: yaml

         services:
            MyVendor\MyExtension\EventListener\CustomUserSettingsListener:
             tags:
               - name: event.listener
                 identifier: 'myExtension/CustomUserSettingsListener'
                 event: TYPO3\CMS\SetupEvent\AddJavaScriptModulesEvent


   2. Implement Listener to load JavaScript module `TYPO3/CMS/MyExtension/CustomUserSettingsModule`

      .. code-block:: php

         namespace MyVendor\MyExtension\EventListener;

         use TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent;

         final class CustomUserSettingsListener
         {
             // name of JavaScript module to be loaded
             private const MODULE_NAME = 'TYPO3/CMS/MyExtension/CustomUserSettingsModule';

             public function __invoke(AddJavaScriptModulesEvent $event): void
             {
                 $javaScriptModuleName = 'TYPO3/CMS/MyExtension/CustomUserSettings';
                 if (in_array(self::MODULE_NAME, $event->getModules(), true)) {
                     return;
                 }
                 $event->addModule(self::MODULE_NAME);
             }
         }

API
---

.. include:: /CodeSnippets/Events/Setup/AddJavaScriptModulesEvent.rst.txt
