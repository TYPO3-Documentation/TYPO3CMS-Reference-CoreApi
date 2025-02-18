..  include:: /Includes.rst.txt
..  index:: Events; BeforeRedirectMatchDomainEvent
..  _BeforeRedirectMatchDomainEvent:


==============================
BeforeRedirectMatchDomainEvent
==============================

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\BeforeRedirectMatchDomainEvent`
allows extensions to implement a custom redirect matching upon the loaded
redirects or return the matched redirect record from other sources.

..  note::
    The full :sql:`sys_redirect` record must be set using the
    :php:`setMatchedRedirect()` method. Otherwise the Core code would fail
    later, as it expects, for example, the uid of the record to set the
    `X-Redirect-By` response header. Therefore, the :php:`getMatchedRedirect()`
    method returns null or a full :sql:`sys_redirect` record.

..  note::
    The :php:`BeforeRedirectMatchDomainEvent` is dispatched before cached
    redirects are retrieved. That means, that the event does not contain any
    :sql:`sys_redirect` records. The internal redirect cache may vanish
    eventually, if possible. Therefore, it is left out to avoid a longer bound
    state to the event by properly deprecate it.


Example
=======

..  literalinclude:: _BeforeRedirectMatchDomainEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Redirects/BeforeRedirectMatchDomainEvent.rst.txt
