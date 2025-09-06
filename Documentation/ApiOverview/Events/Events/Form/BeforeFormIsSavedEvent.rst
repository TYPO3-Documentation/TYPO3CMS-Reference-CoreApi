..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormIsSavedEvent

..  _BeforeFormIsSavedEvent:

======================
BeforeFormIsSavedEvent
======================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsSavedEvent`
    serves as a direct replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeFormSave']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsSavedEvent` allows a
to modify a form definition as well as the form persistence identifier before
it gets saved. It is dispatched just right before a form is saved in the backend.

..  seealso::
    *   `BeforeFormIsCreatedEvent <https://docs.typo3.org/permalink/t3coreapi:beforeformiscreatedevent>`_
        is called right before a form is created in the backend form editor.
    *   The backend form editor is described in detail in the `TYPO3 Form manual
        - Form editor <https://docs.typo3.org/permalink/typo3/cms-form:apireference-formeditor>`_.

..  _BeforeFormIsSavedEvent-example:

Example
=======

..  literalinclude:: _BeforeFormIsSavedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

..  _BeforeFormIsSavedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeFormIsSavedEvent.rst.txt
