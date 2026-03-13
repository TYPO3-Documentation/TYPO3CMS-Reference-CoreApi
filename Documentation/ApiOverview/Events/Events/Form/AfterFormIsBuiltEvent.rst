..  include:: /Includes.rst.txt
..  index:: Events; AfterFormIsBuiltEvent

..  _AfterFormIsBuiltEvent:

=====================
AfterFormIsBuiltEvent
=====================

..  versionadded:: 14.0
    The events :php-short:`TYPO3\CMS\Form\Event\AfterFormIsBuiltEvent`
    and :php-short:`TYPO3\CMS\Form\Event\BeforeRenderableIsAddedToFormEvent`
    provide an improved replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterBuildingFinished']`.

The event :php-short:`TYPO3\CMS\Form\Event\AfterFormIsBuiltEvent`
allows the form definition to be modified after a form has been created.


..  _AfterFormIsBuiltEvent-example:

Example
=======

..  literalinclude:: _AfterFormIsBuiltEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

..  _AfterFormIsBuiltEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/AfterFormIsBuiltEvent.rst.txt
