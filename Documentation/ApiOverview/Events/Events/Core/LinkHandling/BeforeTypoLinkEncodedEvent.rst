..  include:: /Includes.rst.txt
..  index:: Events; BeforeTypoLinkEncodedEvent
..  _BeforeTypoLinkEncodedEvent:

============================
`BeforeTypoLinkEncodedEvent`
============================

The PSR-14 event :php:`\TYPO3\CMS\Core\LinkHandling\Event\BeforeTypoLinkEncodedEvent`
allows developers to fully manipulate the encoding of
:ref:`TypoLinks <t3tsref:typolink>`.

A common use case for extensions is to extend the TypoLink parts to allow
editors adding additional information, for example, custom attributes can be
inserted to the link markup.

..  seealso::
    :ref:`AfterTypoLinkDecodedEvent`

..  _before-typo-link-encoded-event-example:

Example
=======

..  literalinclude:: _BeforeTypoLinkEncodedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/LinkHandling/EventListener/MyEventListener.php

..  _before-typo-link-encoded-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/LinkHandling/BeforeTypoLinkEncodedEvent.rst.txt
