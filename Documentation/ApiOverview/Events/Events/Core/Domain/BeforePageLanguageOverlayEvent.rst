..  include:: /Includes.rst.txt
..  index:: Events; BeforePageLanguageOverlayEvent
..  _BeforePageLanguageOverlayEvent:

==============================
BeforePageLanguageOverlayEvent
==============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\BeforePageLanguageOverlayEvent`
is a special event which is fired when TYPO3 is about to do the language overlay
of one or multiple pages, which could be one full record or multiple page IDs.
This event is fired only for pages and in-between the events
:ref:`BeforeRecordLanguageOverlayEvent` and :ref:`AfterRecordLanguageOverlayEvent`.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforePageLanguageOverlayEvent.rst.txt
