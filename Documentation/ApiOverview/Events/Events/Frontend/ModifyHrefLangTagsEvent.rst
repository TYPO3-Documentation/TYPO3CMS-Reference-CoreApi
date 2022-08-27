.. include:: /Includes.rst.txt
.. index:: Events; ModifyHrefLangTagsEvent
.. _ModifyHrefLangTagsEvent:

=======================
ModifyHrefLangTagsEvent
=======================

.. versionadded:: 10.3

Event to alter the hreflang tags just before they get rendered.

The class :php:`TYPO3\CMS\Seo\HrefLang\HrefLangGenerator` has been
refactored to be a listener (identifier 'typo3-seo/hreflangGenerator') to the
newly introduced event. This way the system extension seo still provides
hreflang tags but it is now possible to simply register after or instead
of the implementation.

Example
=======

An example implementation could look like this:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   services:
     Vendor\MyExtension\HrefLang\EventListener\OwnHrefLang:
       tags:
         - name: event.listener
           identifier: 'my-ext/ownHrefLang'
           after: 'typo3-seo/hreflangGenerator'
           event: TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent


With :yaml:`after` and :yaml:`before`, you can make sure your own listener is
executed after or before the given identifiers.

.. code-block:: php
   :caption: EXT:my_extension/Classes/HrefLang/EventListener/OwnHrefLang.php

   namespace Vendor\MyExtension\HrefLang\EventListener;

   use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

   class OwnHrefLang
   {
      public function __invoke(ModifyHrefLangTagsEvent $event): void
      {
         $hrefLangs = $event->getHrefLangs();
         $request = $event->getRequest();

         // Do anything you want with $hrefLangs
         $hrefLangs = [
            'en-US' => 'https://example.org',
            'nl-NL' => 'https://example.org/nl'
         ];

         // Override all hrefLang tags
         $event->setHrefLangs($hrefLangs);

         // Or add a single hrefLang tag
         $event->addHrefLang('de-DE', 'https://example.org/de');
       }
   }


API
---

.. include:: /CodeSnippets/Events/Frontend/ModifyHrefLangTagsEvent.rst.txt
