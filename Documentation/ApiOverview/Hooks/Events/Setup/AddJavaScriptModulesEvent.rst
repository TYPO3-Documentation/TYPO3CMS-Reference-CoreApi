.. include:: ../../../../Includes.txt


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

         use TYPO3\CMS\SetupEvent\AddJavaScriptModulesEvent;

         class CustomUserSettingsListener
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
===

 - :Method:
         addModule(string $moduleName)
   :Arguments:
      - :php:`$moduleName`: The JavaScript module name
   :Description:
         Add a module to be loaded with RequireJS (e.g. :code:`TYPO3/CMS/MyExtension/CustomUserSettingsModule`)
   :ReturnType:
         void


 - :Method:
         getModules()
   :Description:
         Returns the list of module names to be loaded.
   :ReturnType:
         array
