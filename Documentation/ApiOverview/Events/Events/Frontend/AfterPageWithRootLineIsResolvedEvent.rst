..  include:: /Includes.rst.txt
..  index:: Events; AfterPageWithRootLineIsResolvedEvent
..  _AfterPageWithRootLineIsResolvedEvent:

====================================
AfterPageWithRootLineIsResolvedEvent
====================================

..  versionadded:: 12.0
    This PSR-14 event replaces the following hooks:

    * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['fetchPageId-PostProcessing']`
    * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['settingLanguage_preProcess']`

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterPageWithRootLineIsResolvedEvent`
fires in the frontend process after a given page has been resolved with
permissions, root line, etc.

This is useful for modifying the page and root (but before resolving the
language), to direct or load content from another page, or for modifying the
page response if additional permissions should be checked.

..  note::
    There are three events in the process when the main
    :php:`TypoScriptFrontendController` class resolves a page and its root line
    based on the incoming request. They are triggered in the following order:

    *   :ref:`BeforePageIsResolvedEvent`
    *   AfterPageWithRootLineIsResolvedEvent
    *   :ref:`AfterPageAndLanguageIsResolvedEvent`

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterPageWithRootLineIsResolvedEvent.rst.txt