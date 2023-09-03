..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordOverlayIconIdentifierEvent
..  _ModifyRecordOverlayIconIdentifierEvent:

======================================
ModifyRecordOverlayIconIdentifierEvent
======================================
..  versionadded:: 13.0

    The PSR-14 event :php:`ModifyRecordOverlayIconIdentifierEvent` has
    been introduced which serves as a more flexible replacement for the
    removed hook:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Core\Imaging\IconFactory']['overrideIconOverlay']`

The PSR-14 event
:php:`\TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent` allows
extension authors to modify the overlay icon identifier of any record icon.

Extensions can listen to the :php:`ModifyRecordOverlayIconIdentifierEvent`
and perform necessary modifications to the overlay icon identifier
based on their requirements.

Example
=======

The corresponding event listener class:

..  literalinclude:: _ModifyRecordOverlayIconIdentifierEvent/_ModifyRecordOverlayIconIdentifierEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Core/EventListener/ModifyRecordOverlayIconIdentifierEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/ModifyRecordOverlayIconIdentifierEvent.rst.txt
