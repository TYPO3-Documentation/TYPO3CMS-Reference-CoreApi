..  include:: /Includes.rst.txt
..  index:: Events; BeforeRedirectEvent
..  _BeforeRedirectEvent:


===================
BeforeRedirectEvent
===================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\BeforeRedirectEvent` is
triggered before a redirect is made.

..  versionadded:: 11.5.26/12.3
    The methods :php:`setRedirectUrl()` and :php:`getRequest()` are available.

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/BeforeRedirectEvent.rst.txt
