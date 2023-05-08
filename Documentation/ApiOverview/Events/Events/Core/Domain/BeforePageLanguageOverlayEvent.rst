..  include:: /Includes.rst.txt
..  index:: Events; BeforePageLanguageOverlayEvent
..  _BeforePageLanguageOverlayEvent:

==============================
BeforePageLanguageOverlayEvent
==============================

..  versionadded:: 12.0
    This event serves as a replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPageOverlay']`.

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\BeforePageLanguageOverlayEvent`
is a special event which is fired when TYPO3 is about to do the language overlay
of one or multiple pages, which could be one full record or multiple page IDs.
This event is fired only for pages and in-between the events
:ref:`BeforeRecordLanguageOverlayEvent` and :ref:`AfterRecordLanguageOverlayEvent`.

API
===

..  include:: /CodeSnippets/Events/Core/BeforePageLanguageOverlayEvent.rst.txt
