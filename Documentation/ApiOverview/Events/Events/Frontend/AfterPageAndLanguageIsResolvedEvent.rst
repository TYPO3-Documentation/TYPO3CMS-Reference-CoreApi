..  include:: /Includes.rst.txt
..  index:: Events; AfterPageAndLanguageIsResolvedEvent
..  _AfterPageAndLanguageIsResolvedEvent:

===================================
AfterPageAndLanguageIsResolvedEvent
===================================

..  versionadded:: 12.0
    This PSR-14 event replaces the following hooks:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['settingLanguage_postProcess']`

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent`
is fired in the frontend process after a given page has been resolved
including its language.

This event modifies TYPO3's language resolution logic through custom additions.
It also allows sending a custom response via event listeners (for example,
a custom 403 response).

..  note::
    There are three events in the process when the main
    :php:`TypoScriptFrontendController` class resolves a page and its root line
    based on the incoming request. They are triggered in the following order:

    *   :ref:`BeforePageIsResolvedEvent`
    *   :ref:`AfterPageWithRootLineIsResolvedEvent`
    *   AfterPageAndLanguageIsResolvedEvent

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterPageAndLanguageIsResolvedEvent.rst.txt
