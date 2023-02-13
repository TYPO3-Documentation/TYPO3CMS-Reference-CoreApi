..  include:: /Includes.rst.txt
..  index:: Events; ModifyGenericBackendMessagesEvent
..  _ModifyGenericBackendMessagesEvent:

=================================
ModifyGenericBackendMessagesEvent
=================================

..  versionadded:: 12.0
    This event serves as direct replacement for the now removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['displayWarningMessages']`.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent`
allows to add or alter messages that are displayed in the :guilabel:`About`
module (default start module of the TYPO3 backend).

Extensions such as the :doc:`EXT:reports <ext_reports:Index>` system extension
use this event to display custom messages based on the system status:

..  include:: /Images/ManualScreenshots/Backend/GenericBackendMessage.rst.txt

Example
=======

Registration of an event listener in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/add-message'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent;
    use TYPO3\CMS\Core\Messaging\FlashMessage;

    final class MyEventListener {
        public function __invoke(ModifyGenericBackendMessagesEvent $event): void
        {
            // Add a custom message
            $event->addMessage(new FlashMessage('My custom message'));
        }
    }

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyGenericBackendMessagesEvent.rst.txt
