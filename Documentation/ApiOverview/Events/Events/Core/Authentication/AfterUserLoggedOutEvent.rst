..  include:: /Includes.rst.txt
..  index:: Events; AfterUserLoggedOutEvent
..  _AfterUserLoggedOutEvent:

=======================
AfterUserLoggedOutEvent
=======================

..  versionadded::  12.3
    The event replaces the deprecated hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_post_processing']`.

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedOutEvent`
is to trigger any kind of action when a user has been successfully logged out.

API
===

..  include:: /CodeSnippets/Events/Core/AfterUserLoggedOutEvent.rst.txt
