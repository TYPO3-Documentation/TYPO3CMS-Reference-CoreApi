..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormIsDuplicatedEvent

..  _BeforeFormIsDuplicatedEvent:

===========================
BeforeFormIsDuplicatedEvent
===========================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsDuplicatedEvent`
    is a replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeFormDuplicate']`.

The :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsDuplicatedEvent` event is
dispatched just before a new form is duplicated in the backend.

..  _BeforeFormIsDuplicatedEvent-example:

Example
=======

..  literalinclude:: _BeforeFormIsDuplicatedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeFormIsDuplicatedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeFormIsDuplicatedEvent.rst.txt
