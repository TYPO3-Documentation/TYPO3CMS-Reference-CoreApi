..  include:: /Includes.rst.txt
..  index:: Events; AfterContentHasBeenFetchedEvent
..  _AfterContentHasBeenFetchedEvent:

===============================
AfterContentHasBeenFetchedEvent
===============================

..  versionadded:: 13.4.2 / 14.0

Using the PSR-14 :php:`\TYPO3\CMS\Frontend\Event\AfterContentHasBeenFetchedEvent`,
it is possible to manipulate the page content, which has been fetched by the
`page-content data processor <https://docs.typo3.org/permalink/t3tsref:PageContentFetchingProcessor>`_,
based on the page layout and corresponding columns configuration.

..  _AfterContentHasBeenFetchedEvent-example:

Example
=======

The event listener class, using the PHP attribute :php:`#[AsEventListener]` for
registration, removes some of the fetched page content elements based on
specific field values.

..  literalinclude:: _AfterContentHasBeenFetchedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  _AfterContentHasBeenFetchedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterContentHasBeenFetchedEvent.rst.txt
