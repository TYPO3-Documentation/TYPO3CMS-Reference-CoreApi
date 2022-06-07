.. include:: /Includes.rst.txt
.. index:: Events; AfterPageAndLanguageIsResolvedEvent
.. _AfterPageAndLanguageIsResolvedEvent:

===================================
AfterPageAndLanguageIsResolvedEvent
===================================

.. versionadded:: 12.0
   This PSR-14 event replaces the following hooks:

   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc']`
   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['settingLanguage_postProcess']`

The event fires in the frontend process after a given page has been resolved
including its language.

This event is intended, for example, to modify TYPO3's language resolution logic
through custom additions. It also allows sending a custom response via event
listeners (e.g. a custom 403 response).

.. note::
   There are three events in the process when the main
   :php:`TypoScriptFrontendController` class resolves a page and its rootline
   based on the incoming request. They are triggered in the following order:

   * :ref:`BeforePageIsResolvedEvent`
   * :ref:`AfterPageWithRootLineIsResolvedEvent`
   * AfterPageAndLanguageIsResolvedEvent

API
===

.. include:: /CodeSnippets/Events/Frontend/AfterPageAndLanguageIsResolvedEvent.rst.txt
