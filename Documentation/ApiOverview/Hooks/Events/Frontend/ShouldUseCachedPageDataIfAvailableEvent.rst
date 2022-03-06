.. include:: /Includes.rst.txt
.. index:: Events; ShouldUseCachedPageDataIfAvailableEvent
.. _ShouldUseCachedPageDataIfAvailableEvent:

=======================================
ShouldUseCachedPageDataIfAvailableEvent
=======================================

.. versionadded:: 12.0
   This event was introduced.

This event allows TYPO3 extensions to register event listeners to modify if a
page should be read from cache (if it has been created in store already), or
if it should be re-built completely ignoring the cache entry for the request.

This event can be used to avoid loading from the cache when indexing via
CLI happens from an external source, or if the cache should be ignored when
logged in from a certain IP address.

API
===

.. include:: /CodeSnippets/Manual/Frontend/ShouldUseCachedPageDataIfAvailableEvent.rst.txt

Example
=======

Registration of the Event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\Frontend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/avoid-cache-loading'

The corresponding event listener class:

.. code-block:: php
   :caption: my_extension/Classes/Frontend/MyEventListener.php

   use TYPO3\CMS\Frontend\Event\ShouldUseCachedPageDataIfAvailableEvent;

   class MyEventListener {

       public function __invoke(ShouldUseCachedPageDataIfAvailableEvent $event): void
       {
           if (!($event->getRequest()->getServerParams()['X-SolR-API'] ?? null)) {
               return;
           }
           $event->setShouldUseCachedPageData(false);
       }
   }
