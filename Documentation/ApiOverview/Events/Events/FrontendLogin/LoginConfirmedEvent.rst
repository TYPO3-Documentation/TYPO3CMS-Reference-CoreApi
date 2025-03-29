..  include:: /Includes.rst.txt
..  index:: Events; LoginConfirmedEvent
..  _LoginConfirmedEvent:


===================
LoginConfirmedEvent
===================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\LoginConfirmedEvent` is
triggered when a login was successful.

..  versionchanged:: 14.0
    This event is now correctly dispatched, when a
    logout redirect is configured. Previously the `actionUri` was used for
    redirects after logout in which case the `LogoutConfirmedEvent` was not
    triggered on logout.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/LoginConfirmedEvent.rst.txt
