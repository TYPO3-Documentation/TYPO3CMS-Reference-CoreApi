..  include:: /Includes.rst.txt
..  index:: Events; AfterLinkResolvedByStringRepresentationEvent
..  _AfterLinkResolvedByStringRepresentationEvent:

==============================================
`AfterLinkResolvedByStringRepresentationEvent`
==============================================

The PSR-14 event :php:`\TYPO3\CMS\Core\LinkHandling\Event\AfterLinkResolvedByStringRepresentationEvent`
is being dispatched after the :php:`\TYPO3\CMS\Core\LinkHandling\LinkService`
has tried to resolve a given `t3://` :abbr:`URN (Uniform Resource Name)` using
defined :ref:`link handlers <linkhandler>`.

The event can not only be used to resolve custom link types, but also to modify
the link result data of existing link handlers. Additionally, it can be used to
resolve situations where no handler could be found for a `t3://` URN.

..  note::
    The event is always dispatched, even if a handler successfully resolved
    the URN and also even in cases, TYPO3 would have thrown the
    :php:`\TYPO3\CMS\Core\LinkHandling\Exception\UnknownLinkHandlerException`
    exception.



..  _after-link-resolved-by-string-representation-event-example:

Example
=======

..  literalinclude:: _AfterLinkResolvedByStringRepresentationEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/LinkHandling/EventListener/MyEventListener.php

..  _after-link-resolved-by-string-representation-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/LinkHandling/AfterLinkResolvedByStringRepresentationEvent.rst.txt
