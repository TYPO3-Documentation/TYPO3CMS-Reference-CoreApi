..  include:: /Includes.rst.txt
..  index:: Events; BeforePageIsResolvedEvent
..  _BeforePageIsResolvedEvent:

=========================
BeforePageIsResolvedEvent
=========================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\BeforePageIsResolvedEvent` is
fired before the frontend process is trying to fully resolve a given page by its
page ID and the request.

The events may not be dispatched anymore when the
:ref:`middleware <request-handling>`
:php:`TYPO3\CMS\Frontend\Middleware\TypoScriptFrontendInitialization`
creates early responses.

..  tip::
    There are three events in the process around the resolving of a page
    and its root line or language based on the incoming request. They are
    triggered in the following order:

    #.  BeforePageIsResolvedEvent
    #.  :ref:`AfterPageWithRootLineIsResolvedEvent`
    #.  :ref:`AfterPageAndLanguageIsResolvedEvent`


Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt


API
===

..  include:: /CodeSnippets/Events/Frontend/BeforePageIsResolvedEvent.rst.txt
