..  include:: /Includes.rst.txt
..  index:: Events; BeforeModuleCreationEvent
..  _BeforeModuleCreationEvent:

=========================
BeforeModuleCreationEvent
=========================

The PSR-14 event :ref:`\TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent`
allows extension authors to manipulate the :ref:`module configuration
<backend-modules-configuration>`, before it is used to create and register the
module.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/modify-module-icon'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    use TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent;

    final class MyEventListener {
        public function __invoke(BeforeModuleCreationEvent $event): void
        {
            // Change module icon of page module
            if ($event->getIdentifier() === 'web_layout') {
                $event->setConfigurationValue('iconIdentifier', 'my-custom-icon-identifier');
            }
        }
    }

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeModuleCreationEvent.rst.txt
