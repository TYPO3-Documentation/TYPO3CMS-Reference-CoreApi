.. include:: /Includes.rst.txt
.. index:: Events; BeforeModuleCreationEvent
.. _BeforeModuleCreationEvent:

=========================
BeforeModuleCreationEvent
=========================

The PSR-14 event :ref:`BeforeModuleCreationEvent` allows extension authors
to manipulate the module configuration, before it is used to create and
register the module.

Registration of an event listener in the :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\Backend\ModifyModuleIcon:
     tags:
       - name: event.listener
         identifier: 'my-extension/backend/modify-module-icon'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Backend/ModifyModuleIcon.php

   use TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent;

   final class ModifyModuleIcon {

       public function __invoke(BeforeModuleCreationEvent $event): void
       {
           // Change module icon of page module
           if ($event->getIdentifier() === 'web_layout') {
               $event->setConfigurationValue('iconIdentifider', 'my-custom-icon-identifier');
           }
       }
   }

API
===

.. include:: /CodeSnippets/Events/Backend/BeforeModuleCreationEvent.rst.txt
