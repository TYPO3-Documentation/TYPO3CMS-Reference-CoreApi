..  include:: /Includes.rst.txt
..  index:: Events; AfterPageWithRootLineIsResolvedEvent
..  _AfterPageWithRootLineIsResolvedEvent:

====================================
AfterPageWithRootLineIsResolvedEvent
====================================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterPageWithRootLineIsResolvedEvent`
fires in the frontend process after a given page has been resolved with
permissions, root line, etc.

This is useful for modifying the page and root (but before resolving the
language), to direct or load content from another page, or for modifying the
page response if additional permissions should be checked.

..  tip::
    There are three events in the process around the resolving of a page
    and its root line or language based on the incoming request. They are
    triggered in the following order:

    #.  :ref:`BeforePageIsResolvedEvent`
    #.  AfterPageWithRootLineIsResolvedEvent
    #.  :ref:`AfterPageAndLanguageIsResolvedEvent`


Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt


API
===

..  include:: /CodeSnippets/Events/Frontend/AfterPageWithRootLineIsResolvedEvent.rst.txt
