..  include:: /Includes.rst.txt
..  index:: Events; BeforeUserLogoutEvent
..  _BeforeUserLogoutEvent:

=====================
BeforeUserLogoutEvent
=====================

..  versionadded::  12.3
    The event replaces the deprecated hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_pre_processing']`.

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Authentication\Event\BeforeUserLogoutEvent` is to trigger
any kind of action before a user will be logged out.

The event has the possibility to bypass the regular logout process by TYPO3
(removing the cookie and the user session) by calling
:php:`$event->disableRegularLogoutProcess()` in an event listener.

API
===

..  include:: /CodeSnippets/Events/Core/BeforeUserLogoutEvent.rst.txt
