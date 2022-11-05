.. include:: /Includes.rst.txt
.. index:: Events; ModifyClearCacheActionsEvent
.. _ModifyClearCacheActionsEvent:


====================================
ModifyClearCacheActionsEvent
====================================

.. versionadded:: 11.4

The :php:`ModifyClearCacheActionsEvent` is fired in the :php:`ClearCacheToolbarItem`
class and allows extensions to modify the clear cache actions, shown
in the TYPO3 backend top toolbar.

The event can be used to change or remove existing clear cache
actions, as well as to add new actions. Therefore the event also
contains, next to the usual "getter" and "setter" methods, the convenience
method :php:`add` for the :php:`cacheActions` and
:php:`cacheActionIdentifiers` arrays.

Example
=======

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:some_extension/Configuration/Services.yaml

   Vendor\SomeExtension\Toolbar\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/toolbar/my-event-listener'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:some_extension/Classes/EventListener/MyEventListener.php

    use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;

    final class MyEventListener {

        public function __invoke(ModifyClearCacheActionsEvent $event): void
        {
            // do magic here
        }

    }

The cache action array element consists of the following keys and values:

.. code-block:: php
   :caption: Example cache action array

   [
       'id' => 'pages',
       'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesTitle',
       'description' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesDescription',
       'href' => (string)$uriBuilder->buildUriFromRoute('tce_db', ['cacheCmd' => 'pages']),
       'iconIdentifier' => 'actions-system-cache-clear-impact-low'
   ]


API
===

.. include:: /CodeSnippets/Events/Backend/ModifyClearCacheActionsEvent.rst.txt
