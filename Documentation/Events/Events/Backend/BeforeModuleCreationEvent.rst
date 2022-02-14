.. include:: /Includes.rst.txt
.. index:: Events; BeforeModuleCreationEvent
.. _BeforeModuleCreationEvent:

=========================
BeforeModuleCreationEvent
=========================

The PSR-14 :ref:`BeforeModuleCreationEvent` allows extension authors
to manipulate the module configuration, before it is used to create and
register the module.

Registration of an event listener in the :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\Backend\ModifyModuleIcon:
    tags:
      - name: event.listener
        identifier: 'my-package/backend/modify-module-icon'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent;

    class ModifyModuleIcon {

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


