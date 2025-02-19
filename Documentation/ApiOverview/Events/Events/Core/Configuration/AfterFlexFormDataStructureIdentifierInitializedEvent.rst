..  include:: /Includes.rst.txt
..  index:: Events; AfterFlexFormDataStructureIdentifierInitializedEvent

..  _AfterFlexFormDataStructureIdentifierInitializedEvent:

====================================================
AfterFlexFormDataStructureIdentifierInitializedEvent
====================================================

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

..  literalinclude:: _AfterFlexFormDataStructureIdentifierInitializedEvent/_FlexFormParsingModifyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/FlexFormParsingModifyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/AfterFlexFormDataStructureIdentifierInitializedEvent.rst.txt
