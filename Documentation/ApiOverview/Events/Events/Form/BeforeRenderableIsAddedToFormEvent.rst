..  include:: /Includes.rst.txt
..  index:: Events; BeforeRenderableIsAddedToFormEvent

..  _BeforeRenderableIsAddedToFormEvent:

==================================
BeforeRenderableIsAddedToFormEvent
==================================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsAddedToFormEvent`
    is a direct replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['initializeFormElement']`.

The event :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsAddedToFormEvent`
is dispatched before a renderable is constructed and added to a form. This
event allows a renderable to be customized after everything has been
initialized.


..  _BeforeRenderableIsAddedToFormEvent-example:

Example
=======

..  literalinclude:: _BeforeRenderableIsAddedToFormEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _BeforeRenderableIsAddedToFormEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/BeforeRenderableIsAddedToFormEvent.rst.txt
