.. include:: /Includes.rst.txt
.. index:: Events; AfterFlexFormDataStructureParsedEvent

.. _AfterFlexFormDataStructureParsedEvent:

=====================================
AfterFlexFormDataStructureParsedEvent
=====================================

..  versionadded:: 12.0
    This event was introduced to replace and improve the method
    :php:`getDataStructureIdentifierPostProcess()` ot the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`.

This event can be used to control the flex form parsing in an
object oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`AfterFlexFormDataStructureParsedEvent`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`BeforeFlexFormDataStructureParsedEvent`
    *   :ref:`combined Example <AfterFlexFormDataStructureIdentifierInitializedEvent-Example>`

API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureParsedEvent.rst.txt
