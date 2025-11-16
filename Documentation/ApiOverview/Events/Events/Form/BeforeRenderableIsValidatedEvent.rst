..  include:: /Includes.rst.txt
..  index:: Events; BeforeRenderableIsValidatedEvent

..  _BeforeRenderableIsValidatedEvent:

==================================
BeforeRenderableIsValidatedEvent
==================================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsValidatedEvent`
    is a replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterSubmit']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsValidatedEvent`
is dispatched just before a renderable is validated. This event allows a renderable
to add custom logic before it is validated.


..  _BeforeRenderableIsValidatedEvent-example:

Example
=======

..  literalinclude:: _BeforeRenderableIsValidatedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeRenderableIsValidatedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeRenderableIsValidatedEvent.rst.txt
