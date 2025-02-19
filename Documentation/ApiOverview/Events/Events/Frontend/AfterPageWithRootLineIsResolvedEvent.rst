..  include:: /Includes.rst.txt
..  index:: Events; AfterPageWithRootLineIsResolvedEvent
..  _AfterPageWithRootLineIsResolvedEvent:

====================================
AfterPageWithRootLineIsResolvedEvent
====================================

..  versionchanged:: 13.0
    The event no longer receives an instance of
    :php:`TypoScriptFrontendController`, the :php:`getController()` method has
    been removed: The controller is instantiated *after* the event has been
    dispatched, event listeners can no longer work with this object.

    Instead, the event now contains an instance of the new
    :abbr:`DTO (Data Transfer Object)`
    :php:`\TYPO3\CMS\Frontend\Page\PageInformation`, which can be retrieved
    and manipulated by event listeners, if necessary.

    See :ref:`AfterPageWithRootLineIsResolvedEvent-migration`.

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


..  _AfterPageWithRootLineIsResolvedEvent-migration:

Migration
=========

Use the method :php:`getPageInformation()` to retrieve the calculated page state
at this point in the frontend rendering chain. Event listeners that manipulate
that object should set it again within the event using
:php:`setPageInformation()`.

In case the middleware :php:`TypoScriptFrontendInitialization` no longer
dispatches an event when it created an early response on its own, a custom
middleware can be added around that middleware to retrieve and further
manipulate a response if needed.
