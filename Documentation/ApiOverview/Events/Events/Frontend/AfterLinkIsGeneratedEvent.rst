.. include:: /Includes.rst.txt
.. index:: Events; AfterLinkIsGeneratedEvent
.. _AfterLinkIsGeneratedEvent:

=========================
AfterLinkIsGeneratedEvent
=========================

.. versionadded:: 12.0
   This PSR-14 event supersedes the :php:`UrlProcessorInterface` logic
   which allowed to modify mail URNs or external URLs, but not the
   full anchor tag.

   In addition, this PSR-14 event also replaces the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typoLink_PostProc']`
   hook which was not executed at all times, and had a cumbersome API
   to modify values.

   It is also recommended to use the PSR-14 event instead of the global
   getATagParams hook (:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['getATagParamsPostProc']`)
   to add additional attributes (see example below) to links.

This event allows PHP developers to modify any kind of link generated
by TYPO3's mighty :php:`typolink()` functionality.

By using this event, it is possible to add attributes to links to
internal pages, or links to files, as the event contains the actual information
of the link type with it.

As this event works with the :php:`LinkResultInterface` object it is possible
to modify or replace the LinkResult information instead of working with string
replacement functionality for adding, changing or removing attributes.

Example
=======

To register an event listener to the new event, use the following code in your
:file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   services:
     Vendor\MyExtension\TypoLink\LinkModifier:
       tags:
         - name: event.listener
           identifier: 'myLoadedListener'


The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/TypoLink/LinkModifier.php

   use TYPO3\CMS\Frontend\Event\AfterLinkIsGeneratedEvent;

   final class LinkModifier
   {
       public function __invoke(AfterLinkIsGeneratedEvent $event): void
       {
           $linkResult = $event->getLinkResult()->withAttribute('data-enable-lightbox', true);
           $event->setLinkResult($linkResult);
       }
   }


API
===

.. include:: /CodeSnippets/Events/Frontend/AfterLinkIsGeneratedEvent.rst.txt
