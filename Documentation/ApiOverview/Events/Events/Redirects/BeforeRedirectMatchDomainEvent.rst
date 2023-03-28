..  include:: /Includes.rst.txt
..  index:: Events; BeforeRedirectMatchDomainEvent
..  _BeforeRedirectMatchDomainEvent:


==============================
BeforeRedirectMatchDomainEvent
==============================

..  versionadded:: 12.3

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

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _BeforeRedirectMatchDomainEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _BeforeRedirectMatchDomainEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Redirects/BeforeRedirectMatchDomainEvent.rst.txt
