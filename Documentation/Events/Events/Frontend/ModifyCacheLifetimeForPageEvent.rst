.. include:: /Includes.rst.txt
.. index:: Events; ModifyCacheLifetimeForPageEvent
.. _ModifyCacheLifetimeForPageEvent:

====================
ModifyCacheLifetimeForPageEvent
====================

.. versionadded:: 12.0
   This event serves as a successor for the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['get_cache_timeout']`
   hook.

This event allows to modify the lifetime of how long a rendered page of a
frontend call should be stored in the "pages" cache.

API
===

.. include:: /CodeSnippets/Manual/Frontend/ModifyCacheLifetimeForPageEvent.rst.txt

Example
=======

Register the listener:

.. code-block:: yaml
   :caption: my_extension/Configuration/Services.yaml

   services:
     MyCompany\MyPackage\EventListener\ChangeCacheTimeout:
       tags:
         - name: event.listener
           identifier: 'mycompany/myextension/cache-timeout'

The following listener limits the cache lifetime to 30 seconds in development
context:

.. code-block:: php
   :caption: my_extension/EventListener/ChangeCacheTimeout.php

   namespace MyCompany\MyExtension\EventListener;
   use TYPO3\CMS\Frontend\Event\ModifyCacheLifetimeForPageEvent;

   class ChangeCacheTimeout
   {
       public function __invoke(ModifyCacheLifetimeForPageEvent $event): void
       {
           // Only cache all pages for 30 seconds when in development context
           if (Environment::getContext()->isDevelopment()) {
               $event->setCacheLifetime(30);
           }
       }
   }
