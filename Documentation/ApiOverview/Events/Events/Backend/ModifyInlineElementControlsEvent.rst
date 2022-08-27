.. include:: /Includes.rst.txt
.. index:: Events; ModifyInlineElementControlsEvent
.. _ModifyInlineElementControlsEvent:

====================================
ModifyInlineElementControlsEvent
====================================

.. versionadded:: 12.0
   This event, together with :ref:`ModifyInlineElementEnabledControlsEvent`
   serves as a more powerful and flexible replacement
   for the removed hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms_inline.php']['tceformsInlineHook']`

This event
is called after the markup for all enabled controls has been generated. It
can be used to either change the markup of a control, to add a new control
or to completely remove a control.

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyInlineElementControlsEvent.rst.txt

.. _ModifyInlineElementControlsEvent_example:

Example
=======

Registration of the Event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: my_extension/Configuration/Services.yaml

   MyVendor\MyPackage\Backend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/backend/modify-enabled-controls'
         method: 'modifyEnabledControls'
       - name: event.listener
         identifier: 'my-package/backend/modify-controls'
         method: 'modifyControls'

The corresponding event listener class:

.. code-block:: php

   use TYPO3\CMS\Backend\Form\Event\ModifyInlineElementEnabledControlsEvent;
   use TYPO3\CMS\Backend\Form\Event\ModifyInlineElementControlsEvent;
   use TYPO3\CMS\Core\Imaging\Icon;
   use TYPO3\CMS\Core\Imaging\IconFactory;
   use TYPO3\CMS\Core\Utility\GeneralUtility;

   class MyEventListener {

       public function modifyEnabledControls(ModifyInlineElementEnabledControlsEvent $event): void
       {
           // Enable a control depending on the foreign table
           if ($event->getForeignTable() === 'sys_file_reference' && $event->isControlEnabled('sort')) {
               $event->enableControl('sort');
           }
       }

       public function modifyControls(ModifyInlineElementControlsEvent $event): void
       {
           // Add a custom control depending on the parent table
           if ($event->getElementData()['inlineParentTableName'] === 'tt_content') {
               $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
               $event->setControl(
                   'tx_my_control',
                   '<a href="/some/url" class="btn btn-default t3js-modal-trigger">' . $iconFactory->getIcon('my-icon-identifier', Icon::SIZE_SMALL)->render() . '</a>'
               );
           }
       }

   }
