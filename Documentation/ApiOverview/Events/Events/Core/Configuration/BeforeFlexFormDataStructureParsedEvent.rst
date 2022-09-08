.. include:: /Includes.rst.txt
.. index:: Events; BeforeFlexFormDataStructureParsedEvent

.. _BeforeFlexFormDataStructureParsedEvent:

======================================
BeforeFlexFormDataStructureParsedEvent
======================================

..  versionadded:: 12.0
    This event was introduced to replace and improve the method
    :php:`parseDataStructureByIdentifierPreProcess()` ot the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`.

This event can be used to control the flex form parsing in an
object oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`AfterFlexFormDataStructureParsedEvent`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`combined Example <AfterFlexFormDataStructureIdentifierInitializedEvent-Example>`

API
===

..  include:: /CodeSnippets/Events/Core/BeforeFlexFormDataStructureParsedEvent.rst.txt

Migration
=========

Using the removed hook method :php:`parseDataStructureByIdentifierPreProcess()`
of hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`
previously required implementations to always return an :php:`array` or
:php:`string`. Implementations returned an empty :php:`array` or empty
:php:`string` in case they did not want to set a data structure.

This behaviour has now changed. As soon as a listener sets a data structure
using the :php:`setDataStructure()` method, the event propagation is stopped
immediately and no further listeners are called.

Therefore, listeners should avoid setting an empty :php:`array` or an empty
:php:`string` but should just "return" without any change to the
:php:`$event` object in such a case.
