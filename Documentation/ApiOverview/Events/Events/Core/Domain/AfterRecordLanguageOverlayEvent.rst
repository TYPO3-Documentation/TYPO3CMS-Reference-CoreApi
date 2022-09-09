.. include:: /Includes.rst.txt
.. index:: Events; AfterRecordLanguageOverlayEvent
.. _AfterRecordLanguageOverlayEvent:

===============================
AfterRecordLanguageOverlayEvent
===============================

.. versionadded:: 12.0
   This event serves as replacement for the removed hook
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getRecordOverlay']`.

The event :php:`\TYPO3\CMS\Core\Domain\Event\AfterRecordLanguageOverlayEvent`
can be used to modify the actual translated record (if found) to add additional
information or do custom processing of the record.

API
===

.. include:: /CodeSnippets/Events/Core/AfterRecordLanguageOverlayEvent.rst.txt
