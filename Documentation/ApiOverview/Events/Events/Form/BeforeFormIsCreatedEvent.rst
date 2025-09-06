..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormIsCreatedEvent

..  _BeforeFormIsCreatedEvent:

========================
BeforeFormIsCreatedEvent
========================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsCreatedEvent`
    serves as a direct replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeFormCreate']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsCreatedEvent` allows a
to modify a form before it gets created. The event is dispatched just right
before a new form is created in the backend.

..  seealso::
    *   `BeforeFormIsSavedEvent <https://docs.typo3.org/permalink/t3coreapi:beforeformissavedevent>`_
        is called right before a form is saved in the backend form editor.
    *   The backend form editor is described in detail in the `TYPO3 Form manual
        - Form editor <https://docs.typo3.org/permalink/typo3/cms-form:apireference-formeditor>`_.

..  _BeforeFormIsCreatedEvent-example:

Example
=======

..  literalinclude:: _BeforeFormIsCreatedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

..  _BeforeFormIsCreatedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeFormIsCreatedEvent.rst.txt
