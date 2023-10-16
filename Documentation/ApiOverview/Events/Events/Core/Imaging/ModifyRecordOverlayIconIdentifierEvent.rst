..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordOverlayIconIdentifierEvent
..  _ModifyRecordOverlayIconIdentifierEvent:

======================================
ModifyRecordOverlayIconIdentifierEvent
======================================

..  versionadded:: 13.0
    This PSR-14 event has been introduced, serving as a more flexible
    replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\Imaging\IconFactory']['overrideIconOverlay']`.

The PSR-14 event `\TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent`
allows extension authors to modify the overlay icon identifier of any record
icon. Extensions can listen to this event and perform necessary modifications
to the overlay icon identifier based on their requirements.


Example
=======

..  literalinclude:: _ModifyRecordOverlayIconIdentifierEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Core/EventListener/ModifyRecordOverlayIconIdentifierEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/ModifyRecordOverlayIconIdentifierEvent.rst.txt
