.. include:: /Includes.rst.txt
.. index:: Events; AfterCachedPageIsPersistedEvent
.. _AfterCachedPageIsPersistedEvent:

===============================
AfterCachedPageIsPersistedEvent
===============================

.. versionadded:: 12.0

   This event together with :ref:`AfterCacheableContentIsGeneratedEvent` has
   been introduced to serve as a direct replacement for the removed hook:

   * :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['insertPageIncache']`

The :php:`AfterCachedPageIsPersistedEvent` is commonly used to
generate a static file cache. This event is only called if the
page was actually stored in TYPO3's page cache.

Example
=======

Registration of the `AfterCacheableContentIsGeneratedEvent` in your
extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\Frontend\AfterCachedPageIsPersistedEvent:
     tags:
       - name: event.listener
         identifier: 'my-extension/content-modifier'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Frontend/MyEventListener.php

   use TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent;

   final class MyEventListener {

       public function __invoke(AfterCachedPageIsPersistedEvent $event): void
       {
           // generate static file cache
       }
   }

API
===

.. include:: /CodeSnippets/Events/Frontend/AfterCachedPageIsPersistedEvent.rst.txt
