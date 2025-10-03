..  include:: /Includes.rst.txt
..  index:: Events; AfterCacheableContentIsGeneratedEvent
..  _AfterCacheableContentIsGeneratedEvent:

=====================================
AfterCacheableContentIsGeneratedEvent
=====================================

..  important::
    ..  versionchanged:: 14.0
        Method :php:`getController()` is removed and substituted with methods :php:`getContent()`
        and :php:`setContent()`. See also
        `Breaking: #107578 - Event AfterCacheableContentIsGeneratedEvent changed <https://docs.typo3.org/permalink/changelog:breaking-107578-1759400756>`_´.

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent` can be
used to decide if a page should be stored in cache.

It is executed right after all cacheable content is generated.
It can also be used to manipulate the content before it is stored in
TYPO3's page cache. In the Core, the event is used in
:doc:`EXT:indexed_search <ext_indexed_search:Index>` to index cacheable content.

The :php-short:`\TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent` contains the
information if a generated page is able to store in cache via the
:php:`$event->isCachingEnabled()` method.

..  _AfterCacheableContentIsGeneratedEvent-example:

Example
=======

..  literalinclude:: _AfterCacheableContentIsGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _AfterCacheableContentIsGeneratedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterCacheableContentIsGeneratedEvent.rst.txt

..  _AfterCacheableContentIsGeneratedEvent-migration-getcontroller:

Migration from `AfterCacheableContentIsGeneratedEvent::getController()`
=======================================================================

In most cases, method :php:`AfterCacheableContentIsGeneratedEvent->getController()`
was used in event listeners to get and/or set
:php:`TypoScriptFrontendController->content` at a late point within the frontend
rendering chain.

The event has been changed by removing :php:`getController()` and adding
:php:`getContent()` and :php:`setContent()` instead.

..  code-block:: diff

     #[AsEventListener('my-extension')]
     public function indexPageContent(AfterCacheableContentIsGeneratedEvent $event): void
     {
    -    $tsfe = $event->getController();
    -    $content = $tsfe->content;
    *    $content = $event->getContent();
         // ... $content is manipulated here
    -    $tsfe->content = $content;
    *    $event->setContent($content);
     }

Extensions aiming for TYPO3 v13 and v14 compatibility in a single version can use a version
check gate:

.. code-block:: php

    #[AsEventListener('my-extension')]
    public function indexPageContent(AfterCacheableContentIsGeneratedEvent $event): void
    {
        if ((new Typo3Version)->getMajorVersion() < 14) {
            // @todo: Remove if() when TYPO3 v13 compatibility is dropped, keep else body only
            $tsfe = $event->getController();
            $content = $tsfe->content;
        } else {
            $content = $event->getContent();
        }
        // ... $content is manipulated here
        if ((new Typo3Version)->getMajorVersion() < 14) {
            // @todo: Remove if() when TYPO3 v13 compatibility is dropped, keep else body only
            $tsfe = $event->getController();
            $tsfe->content = $content;
        } else {
            $event->setContent($content);
        }
    }
