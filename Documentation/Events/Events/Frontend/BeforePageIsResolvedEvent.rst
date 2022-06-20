.. include:: /Includes.rst.txt
.. index:: Events; BeforePageIsResolvedEvent
.. _BeforePageIsResolvedEvent:

=========================
BeforePageIsResolvedEvent
=========================

.. versionadded:: 12.0
   This PSR-14 event replaces the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PreProcessing']`
   hook.

Three new PSR-14 events have been added in the process when the main class
:php:`TypoScriptFrontendController` is resolving a page and its rootline,
based on the incoming request.

The event fires before the frontend process attempts to fully resolve a given
page based on its page ID and request. Event listeners can modify incoming
parameters (such as :php:`$controller->id`) or the context for resolving a page.

.. note::
   There are three events in the process when the main
   :php:`TypoScriptFrontendController` class resolves a page and its rootline
   based on the incoming request. They are triggered in the following order:

   * BeforePageIsResolvedEvent
   * :ref:`AfterPageWithRootLineIsResolvedEvent`
   * :ref:`AfterPageAndLanguageIsResolvedEvent`

API
===

.. include:: /CodeSnippets/Events/Frontend/BeforePageIsResolvedEvent.rst.txt
