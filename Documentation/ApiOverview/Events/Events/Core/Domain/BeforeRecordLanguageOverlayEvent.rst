.. include:: /Includes.rst.txt
.. index:: Events; BeforeRecordLanguageOverlayEvent
.. _BeforeRecordLanguageOverlayEvent:

================================
BeforeRecordLanguageOverlayEvent
================================

.. versionadded:: 12.0
   This event serves as replacement for the removed hook
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getRecordOverlay']`.

The event :php:`\TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent`
can be used to modify information (such as the :php:`LanguageAspect`
or the actual incoming record from the database) before the database
is queried.

API
===

.. include:: /CodeSnippets/Events/Core/BeforeRecordLanguageOverlayEvent.rst.txt
