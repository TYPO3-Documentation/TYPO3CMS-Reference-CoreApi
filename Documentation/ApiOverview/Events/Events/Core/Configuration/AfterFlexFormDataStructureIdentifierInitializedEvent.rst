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

This example is available in our
`examples extension <https://github.com/TYPO3-Documentation/t3docs-examples>`__.

Registration of the events in the extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:examples/Configuration/Services.yaml

    services:
       T3docs\Examples\EventListener\Core\Configuration\FlexFormParsingModifyEventListener:
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

..  include:: /CodeSnippets/Events/Core/FlexFormParsingModifyEventListener/FlexFormParsingModifyEventListener.rst.txt


API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureIdentifierInitializedEvent.rst.txt
