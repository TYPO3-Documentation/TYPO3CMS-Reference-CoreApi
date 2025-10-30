..  include:: /Includes.rst.txt
..  index:: Events; BeforeRenderableIsRenderedEvent

..  _BeforeRenderableIsRenderedEvent:

==================================
BeforeRenderableIsRenderedEvent
==================================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsRenderedEvent`
    is a replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeRendering']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsRenderedEvent`
is dispatched before a renderable is rendered. This event allows a renderable to
be modified before it is rendered or a form can be modified at runtime.


..  _BeforeRenderableIsRenderedEvent-example:

Example
=======

..  literalinclude:: _BeforeRenderableIsRenderedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeRenderableIsRenderedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeRenderableIsRenderedEvent.rst.txt
