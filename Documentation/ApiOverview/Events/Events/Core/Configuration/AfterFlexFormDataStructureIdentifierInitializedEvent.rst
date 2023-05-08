..  include:: /Includes.rst.txt
..  index:: Events; AfterFlexFormDataStructureIdentifierInitializedEvent

..  _AfterFlexFormDataStructureIdentifierInitializedEvent:

====================================================
AfterFlexFormDataStructureIdentifierInitializedEvent
====================================================

..  versionadded:: 12.0
    This event was introduced to replace and improve the method
    :php:`parseDataStructureByIdentifierPostProcess()` of the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent`
can be used to control the :ref:`FlexForm <flexforms>` parsing in an
object-oriented approach.

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

..  literalinclude:: _AfterFlexFormDataStructureIdentifierInitializedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:examples/Configuration/Services.yaml

The corresponding event listener class:

..  include:: /CodeSnippets/Events/Core/FlexFormParsingModifyEventListener/FlexFormParsingModifyEventListener.rst.txt


API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureIdentifierInitializedEvent.rst.txt
