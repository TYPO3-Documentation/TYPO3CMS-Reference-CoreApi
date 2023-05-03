.. include:: /Includes.rst.txt
.. index:: Events; ModifyHrefLangTagsEvent
.. _ModifyHrefLangTagsEvent:

=======================
ModifyHrefLangTagsEvent
=======================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent` is available to alter
the :html:`hreflang` tags just before they get rendered.

The class :php:`\TYPO3\CMS\Seo\HrefLang\HrefLangGenerator` (identifier
:yaml:`typo3-seo/hreflangGenerator`) is also available as an event. Its purpose
is to provide the default :html:`hreflang` tags. This way it is possible to
register a custom event listener after or instead of this implementation.

Example
=======

An example implementation could look like this:

..  literalinclude:: _ModifyHrefLangTagsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

With :yaml:`after` and :yaml:`before`, you can make sure your own listener is
executed after or before the given identifiers.

..  literalinclude:: _ModifyHrefLangTagsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyHrefLangTagsEvent.rst.txt
