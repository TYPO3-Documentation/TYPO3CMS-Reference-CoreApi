.. include:: /Includes.rst.txt
.. index:: Events; BeforeFlexFormDataStructureIdentifierInitializedEvent

.. _BeforeFlexFormDataStructureIdentifierInitializedEvent:

=====================================================
BeforeFlexFormDataStructureIdentifierInitializedEvent
=====================================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureIdentifierInitializedEvent`
can be used to control the :ref:`FlexForm <flexforms>` parsing in an
object-oriented approach.

..  seealso::

    *   :ref:`AfterFlexFormDataStructureIdentifierInitializedEvent`
    *   :ref:`AfterFlexFormDataStructureParsedEvent`
    *   :ref:`BeforeFlexFormDataStructureParsedEvent`

Example
=======

Have a look at the :ref:`combined example <AfterFlexFormDataStructureIdentifierInitializedEvent-Example>`.

API
===

..  include:: /CodeSnippets/Events/Core/BeforeFlexFormDataStructureIdentifierInitializedEvent.rst.txt

Migration
=========

Using the removed hook method :php:`getDataStructureIdentifierPreProcess()` of
the hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`
previously required implementations to always return an :php:`array`.

This means, implementations returned an empty :php:`array` in case they did
not want to set an identifier, allowing further implementations to be
called.

This behaviour has now changed. As soon as a listener sets the identifier
using the :php:`setIdentifier()` method, the event propagation is stopped
immediately and no further listeners are being called. Therefore, listeners
should avoid setting an empty :php:`array` but should just "return" without
any change to the :php:`$event` object in such a case.
