.. include:: /Includes.rst.txt
.. index:: Events; ModifyNewContentElementWizardItemsEvent
.. _ModifyNewContentElementWizardItemsEvent:

=============================================
ModifyNewContentElementWizardItemsEvent
=============================================

.. versionadded:: 12.0
   This event serves as a more powerful and flexible alternative
   for the removed hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']`.

The event is called after TYPO3 has already prepared the wizard items,
defined in TSconfig (:typoscript:`mod.wizards.newContentElement.wizardItems`).

The event allows listeners to modify any available wizard item as well
as adding new ones. It's therefore possible for the listeners to e.g. change
the configuration, the position or to remove existing items altogether.

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyNewContentElementWizardItemsEvent.rst.txt

Example
=======

Registration of the Event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyPackage\Backend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/backend/modify-wizard-items'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

   use TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent;

   class MyEventListener {

       public function __invoke(ModifyNewContentElementWizardItemsEvent $event): void
       {
           // Add a new wizard item after "textpic"
           $event->setWizardItem(
               'my_element',
               [
                   'iconIdentifier' => 'icon-my-element',
                   'title' => 'My element',
                   'description' => 'My element description',
                   'tt_content_defValues' => [
                       'CType' => 'my_element'
                   ],
               ],
               ['after' => 'common_textpic']
           );
       }
   }

