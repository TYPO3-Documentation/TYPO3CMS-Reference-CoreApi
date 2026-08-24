..  include:: /Includes.rst.txt
..  index:: Events; AfterTypoLinkDecodedEvent
..  _AfterTypoLinkDecodedEvent:

===========================
`AfterTypoLinkDecodedEvent`
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\LinkHandling\Event\AfterTypoLinkDecodedEvent`
allows developers to fully manipulate the decoding of
:ref:`TypoLinks <t3tsref:typolink>`.

A common use case for extensions is to extend the TypoLink parts to allow
editors adding additional information, for example, custom attributes can be
inserted to the link markup.

..  seealso::
    :ref:`BeforeTypoLinkEncodedEvent`

..  _after-typo-link-decoded-event-example:

Example
=======

..  literalinclude:: _AfterTypoLinkDecodedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/LinkHandling/EventListener/MyEventListener.php

..  _after-typo-link-decoded-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/LinkHandling/AfterTypoLinkDecodedEvent.rst.txt
