..  include:: /Includes.rst.txt
..  index:: Events; AfterFlexFormDataStructureParsedEvent

..  _AfterFlexFormDataStructureParsedEvent:

=====================================
AfterFlexFormDataStructureParsedEvent
=====================================

..  versionadded:: 12.0
    This event was introduced to replace and improve the method
    :php:`getDataStructureIdentifierPostProcess()` of the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent`
can be used to control the :ref:`FlexForm <flexforms>` parsing in an
object-oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`BeforeFlexFormDataStructureParsedEvent`
    *   :ref:`combined example <AfterFlexFormDataStructureIdentifierInitializedEvent-Example>`

API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureParsedEvent.rst.txt
