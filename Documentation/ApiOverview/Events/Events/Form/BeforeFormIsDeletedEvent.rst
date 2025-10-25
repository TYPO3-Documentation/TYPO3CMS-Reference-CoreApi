..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormIsDeletedEvent

..  _BeforeFormIsDeletedEvent:

========================
BeforeFormIsDeletedEvent
========================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsDeletedEvent`
    is a more powerful replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeFormDelete']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeFormIsDeletedEvent`
can prevent the deletion of a form and add custom logic based on the delete
action. The event is dispatched just before a form is deleted in the backend.

Setting :php:`$preventDeletion` to
:php:`true`, stops the event and no further listener is called.

..  seealso::
    *   The backend form editor is described in detail in the `TYPO3 Form manual
        - Form editor <https://docs.typo3.org/permalink/typo3/cms-form:apireference-formeditor>`_.

..  _BeforeFormIsDeletedEvent-example:

Example
=======

..  literalinclude:: _BeforeFormIsDeletedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeFormIsDeletedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeFormIsDeletedEvent.rst.txt
