..  include:: /Includes.rst.txt
..  index:: Events; AfterFlexFormDataStructureIdentifierInitializedEvent

..  _AfterFlexFormDataStructureIdentifierInitializedEvent:

======================================================
`AfterFlexFormDataStructureIdentifierInitializedEvent`
======================================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent`
can be used to control the :ref:`FlexForm <flexforms>` parsing in an
object-oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureParsedEvent <AfterFlexFormDataStructureParsedEvent>`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent <BeforeFlexFormDataStructureIdentifierInitializedEvent>`
    *   :ref:`BeforeFlexFormDataStructureParsedEvent <BeforeFlexFormDataStructureParsedEvent>`


..  _AfterFlexFormDataStructureIdentifierInitializedEvent-Example:

Example: Load and change a FlexForm data structure
==================================================

..  literalinclude:: _AfterFlexFormDataStructureIdentifierInitializedEvent/_FlexFormParsingModifyEventListener.php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/FlexFormParsingModifyEventListener.php

..  _after-flex-form-data-structure-identifier-initialized-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent
