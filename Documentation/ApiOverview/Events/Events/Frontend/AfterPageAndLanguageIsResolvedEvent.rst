..  include:: /Includes.rst.txt
..  index:: Events; AfterPageAndLanguageIsResolvedEvent
..  _AfterPageAndLanguageIsResolvedEvent:

===================================
AfterPageAndLanguageIsResolvedEvent
===================================

..  versionchanged:: 13.0
    The event no longer receives an instance of
    :php:`TypoScriptFrontendController`, the :php:`getController()` method has
    been removed: The controller is instantiated *after* the event has been
    dispatched, event listeners can no longer work with this object.

    Instead, the event now contains an instance of the new
    :abbr:`DTO (Data Transfer Object)`
    :php:`\TYPO3\CMS\Frontend\Page\PageInformation`, which can be retrieved
    and manipulated by event listeners, if necessary.

    See :ref:`AfterPageAndLanguageIsResolvedEvent-migration`.


The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent`
is fired in the frontend process after a given page has been resolved
including its language.

This event modifies TYPO3's language resolution logic through custom additions.
It also allows sending a custom response via event listeners (for example,
a custom 403 response).

..  note::
    There are three events in the process around the resolving of a page
    and its root line or language based on the incoming request. They are
    triggered in the following order:

    #.  :ref:`BeforePageIsResolvedEvent`
    #.  :ref:`AfterPageWithRootLineIsResolvedEvent`
    #.  AfterPageAndLanguageIsResolvedEvent


Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt


API
===

..  include:: /CodeSnippets/Events/Frontend/AfterPageAndLanguageIsResolvedEvent.rst.txt


..  _AfterPageAndLanguageIsResolvedEvent-migration:

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
