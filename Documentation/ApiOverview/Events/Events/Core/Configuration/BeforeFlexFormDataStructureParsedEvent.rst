..  include:: /Includes.rst.txt
..  index:: Events; BeforeFlexFormDataStructureParsedEvent

..  _BeforeFlexFormDataStructureParsedEvent:

======================================
BeforeFlexFormDataStructureParsedEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureParsedEvent`
can be used to control the :ref:`FlexForm <flexforms>` parsing in an
object-oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`AfterFlexFormDataStructureParsedEvent`
    *   :ref:`BeforeFlexFormDataStructureIdentifierInitializedEvent`

Example
=======

Have a look at the :ref:`combined example <AfterFlexFormDataStructureIdentifierInitializedEvent-Example>`.

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
