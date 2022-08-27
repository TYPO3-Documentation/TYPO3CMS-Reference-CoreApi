.. include:: /Includes.rst.txt
.. index:: Events; AfterCacheableContentIsGeneratedEvent
.. _AfterCacheableContentIsGeneratedEvent:

=====================================
AfterCacheableContentIsGeneratedEvent
=====================================

.. versionadded:: 12.0

   This event together with :ref:`AfterCachedPageIsPersistedEvent` has
   been introduced to serve as a direct replacement for the removed hooks:

   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-cached']`
   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all']`
   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['usePageCache']`

The event :php:`AfterCacheableContentIsGeneratedEvent` can be used
to decide if a page should be stored in cache.

It is executed right after all cacheable content is generated.
It can also be used to manipulate the content before it is stored in
TYPO3's page cache. In the Core, the event is used in
:doc:`EXT:indexed_search <ext_indexed_search:Index>` to index cacheable content.

The :php:`AfterCacheableContentIsGeneratedEvent` contains the
information if a generated page is able to store in cache via the
:php:`$event->isCachingEnabled()` method. This can be used to
differentiate between the previous hooks `contentPostProc-cached` and
`contentPostProc-all`. The later hook was called regardless of whether the
cache was enabled or not.

Example
=======

Registration of the `AfterCacheableContentIsGeneratedEvent` in your
extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\Frontend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/content-modifier'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Frontend/MyEventListener.php

   use TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent;

   final class MyEventListener {

       public function __invoke(AfterCacheableContentIsGeneratedEvent $event): void
       {
           // Only do this when caching is enabled
           if (!$event->isCachingEnabled()) {
               return;
           }
           $event->getController()->content = str_replace('foo', 'bar', $event->getController()->content);
       }
   }

API
===

.. include:: /CodeSnippets/Events/Frontend/AfterCacheableContentIsGeneratedEvent.rst.txt
