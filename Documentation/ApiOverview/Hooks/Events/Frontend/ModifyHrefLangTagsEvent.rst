.. include:: ../../../../Includes.txt


.. _ModifyHrefLangTagsEvent:


=======================
ModifyHrefLangTagsEvent
=======================

.. versionadded:: 10.3

Event:
    :php:`TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent`

Description:
    Event to alter the hreflang tags just before they get rendered.


The class :php:`TYPO3\CMS\Seo\HrefLang\HrefLangGenerator` has been
refactored to be a listener (identifier 'typo3-seo/hreflangGenerator') to the
newly introduced event. This way the system extension seo still provides
hreflang tags but it is now possible to simply register after or instead
of the implementation.

Example
=======

An example implementation could look like this:

:file:`EXT:my_extension/Configuration/Services.yaml`

.. code-block:: yaml

   services:
     Vendor\MyExtension\HrefLang\EventListener\OwnHrefLang:
       tags:
         - name: event.listener
           identifier: 'my-ext/ownHrefLang'
           after: 'typo3-seo/hreflangGenerator'
           event: TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent

With :yaml:`after` and :yaml:`before`, you can make sure your own listener is
executed after or before the given identifiers.

:file:`EXT:my_extension/Classes/HrefLang/EventListener/OwnHrefLang.php`

.. code-block:: php

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
            'en-US' => 'https://example.com',
            'nl-NL' => 'https://example.com/nl'
         ];

         // Override all hrefLang tags
         $event->setHrefLangs($hrefLangs);

         // Or add a single hrefLang tag
         $event->addHrefLang('de-DE', 'https://example.com/de');
       }
   }


API
===

 - :Method:
         getHrefLangs()
   :Description:
         Returns the hreflang tags.
   :ReturnType:
         array


 - :Method:
         setHrefLangs()
   :Description:
         Set the hreflang tags.
   :Arguments:
         array $hrefLangs
   :ReturnType:
         void

 - :Method:
         addHrefLang()
   :Description:
         Add a hreflang tag to the current list of hreflang tags.
   :Arguments:
         * string $languageCode The language of the hreflang tag you would like to add. For example: nl-NL
         * string $url The URL of the translation. For example: https://example.com/nl
   :ReturnType:
         void


 - :Method:
         getRequest()
   :Description:
         Returns the current request.
   :ReturnType:
         \Psr\Http\Message\ServerRequestInterface



