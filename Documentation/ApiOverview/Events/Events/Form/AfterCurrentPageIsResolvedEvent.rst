..  include:: /Includes.rst.txt
..  index:: Events; AfterCurrentPageIsResolvedEvent

..  _AfterCurrentPageIsResolvedEvent:

===============================
AfterCurrentPageIsResolvedEvent
===============================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\AfterCurrentPageIsResolvedEvent`
    serves as an improved replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterInitializeCurrentPage']`.

The event :php-short:`TYPO3\CMS\Form\Event\AfterCurrentPageIsResolvedEvent`
allows the current page to be manipulated after it has been resolved.

..  _AfterCurrentPageIsResolvedEvent-example:

Example
=======

..  literalinclude:: _AfterCurrentPageIsResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _AfterCurrentPageIsResolvedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/AfterCurrentPageIsResolvedEvent.rst.txt
