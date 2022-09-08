.. include:: /Includes.rst.txt
.. index:: Events; AfterFlexFormDataStructureIdentifierInitializedEvent

.. _AfterFlexFormDataStructureIdentifierInitializedEvent:

====================================================
AfterFlexFormDataStructureIdentifierInitializedEvent
====================================================

..  versionadded:: 12.0
    This event was introduced to replace and improve the method
    :php:`parseDataStructureByIdentifierPostProcess()` ot the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`.

This event can be used to control the flex form parsing in an
object oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureParsedEvent`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`BeforeFlexFormDataStructureParsedEvent`


.. _AfterFlexFormDataStructureIdentifierInitializedEvent-Example:

Example
=======

Registration of the Events in your extensions' :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration

    Vendor\MyExtension\Backend\FlexFormParsingModifyEventListener:
      tags:
        - name: event.listener
          identifier: 'form-framework/set-data-structure'
          method: 'setDataStructure'
        - name: event.listener
          identifier: 'form-framework/modify-data-structure'
          method: 'modifyDataStructure'
        - name: event.listener
          identifier: 'form-framework/set-data-structure-identifier'
          method: 'setDataStructureIdentifier'
        - name: event.listener
          identifier: 'form-framework/modify-data-structure-identifier'
          method: 'modifyDataStructureIdentifier'

The corresponding event listener class:

..  code-block:: php

    use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent;
    use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
    use TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureIdentifierInitializedEvent;
    use TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureParsedEvent;

    final class FlexFormParsingModifyEventListener
    {
        public function setDataStructure(BeforeFlexFormDataStructureParsedEvent $event): void
        {
            $identifier = $event->getIdentifier();
            if (($identifier['type'] ?? '') === 'my_custom_type') {
                $event->setDataStructure('FILE:EXT:myext/Configuration/FlexForms/MyFlexform.xml');
            }
        }

        public function modifyDataStructure(AfterFlexFormDataStructureParsedEvent $event): void
        {
            $identifier = $event->getIdentifier();
            if (($identifier['type'] ?? '') === 'my_custom_type') {
                $parsedDataStructure = $event->getDataStructure();
                $parsedDataStructure['sheets']['sDEF']['ROOT']['TCEforms']['sheetTitle'] = 'Some dynamic custom sheet title';
                $event->setDataStructure($parsedDataStructure);
            }
        }

        public function setDataStructureIdentifier(BeforeFlexFormDataStructureIdentifierInitializedEvent $event): void
        {
            if ($event->getTableName() === 'tx_myext_sometable') {
                $event->setIdentifier([
                    'type' => 'my_custom_type',
                ]);
            }
        }

        public function modifyDataStructureIdentifier(AfterFlexFormDataStructureIdentifierInitializedEvent $event): void
        {
            $identifier = $event->getIdentifier();
            if (($identifier['type'] ?? '') !== 'my_custom_type') {
                $identifier['type'] = 'my_custom_type';
            }
            $event->setIdentifier($identifier);
        }
    }



API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureIdentifierInitializedEvent.rst.txt
