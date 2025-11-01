..  include:: /Includes.rst.txt
..  index:: Events; BeforeRenderableIsRemovedFromFormEvent

..  _BeforeRenderableIsRemovedFromFormEvent:

======================================
BeforeRenderableIsRemovedFromFormEvent
======================================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsRemovedFromFormEvent`
    is an improved replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeRemoveFromParentRenderable']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsRemovedFromFormEvent`
is dispatched just before a renderable is deleted from a form. It is now
possible to prevent the deletion of a renderable and to add custom logic
based on the deletion.

The event is stoppable. As soon as :php:`$preventRemoval` is set to
:php:`true`, no other listener is called.


..  _BeforeRenderableIsRemovedFromFormEvent-example:

Example
=======

..  literalinclude:: _BeforeRenderableIsRemovedFromFormEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeRenderableIsRemovedFromFormEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeRenderableIsRemovedFromFormEvent.rst.txt
