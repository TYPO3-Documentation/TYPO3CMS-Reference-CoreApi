.. include:: /Includes.rst.txt
.. index:: Events; ModifyGenericBackendMessagesEvent
.. _ModifyGenericBackendMessagesEvent:

====================================
ModifyGenericBackendMessagesEvent
====================================

.. versionadded:: 12.0
   This event serves as direct replacement for the now removed hook
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['displayWarningMessages']`.

This Event allows to add or alter messages that are displayed
in the "About" module (default start module of the TYPO3 Backend).

Extensions such as the system extension EXT:reports use this Event to display
custom messages based on the status of the system:

.. include:: /Images/ManualScreenshots/Backend/GenericBackendMessage.rst.txt

API
===

.. include:: /CodeSnippets/Manual/Backend/ModifyGenericBackendMessagesEvent.rst.txt

Example
=======

Registration of an event listener in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\Backend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/backend/add-message'

The corresponding event listener class:

.. code-block:: php
   :caption: my_extension/Classes/Backend/MyEventListener.php

   use TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent;
   use TYPO3\CMS\Core\Messaging\FlashMessage;

   class MyEventListener {

       public function __invoke(ModifyGenericBackendMessagesEvent $event): void
       {
           // Add a custom message
           $event->addMessage(new FlashMessage('My custom message'));
       }
   }
