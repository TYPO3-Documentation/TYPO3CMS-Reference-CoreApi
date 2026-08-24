..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordOverlayIconIdentifierEvent
..  _ModifyRecordOverlayIconIdentifierEvent:

========================================
`ModifyRecordOverlayIconIdentifierEvent`
========================================

The PSR-14 event `\TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent`
allows extension authors to modify the overlay icon identifier of any record
icon. Extensions can listen to this event and perform necessary modifications
to the overlay icon identifier based on their requirements.


..  _modify-record-overlay-icon-identifier-event-example:

Example
=======

..  literalinclude:: _ModifyRecordOverlayIconIdentifierEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Core/EventListener/ModifyRecordOverlayIconIdentifierEventListener.php

..  _modify-record-overlay-icon-identifier-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/ModifyRecordOverlayIconIdentifierEvent.rst.txt
