..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordOverlayIconIdentifierEvent
..  _ModifyRecordOverlayIconIdentifierEvent:

======================================
ModifyRecordOverlayIconIdentifierEvent
======================================

..  versionadded:: 13.0

The PSR-14 event `ModifyRecordOverlayIconIdentifierEvent` has been introduced,
serving as a more flexible replacement for
the removed hook `TYPO3\CMS\Core\Imaging\IconFactory::overrideIconOverlay`.
This event allows extension authors to modify the overlay icon identifier of
any record icon. Extensions can listen to the
`ModifyRecordOverlayIconIdentifierEvent` and perform necessary modifications
to the overlay icon identifier based on their requirements.


Example
=======

..  literalinclude:: _ModifyRecordOverlayIconIdentifierEvent/_ModifyRecordOverlayIconIdentifierEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Core/EventListener/ModifyRecordOverlayIconIdentifierEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/ModifyRecordOverlayIconIdentifierEvent.rst.txt
