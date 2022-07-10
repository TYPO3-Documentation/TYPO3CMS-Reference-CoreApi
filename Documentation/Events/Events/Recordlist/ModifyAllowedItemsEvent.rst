.. include:: /Includes.rst.txt
.. index:: Events; ModifyAllowedItemsEvent
.. _ModifyAllowedItemsEvent:


========================================
ModifyAllowedItemsEvent
========================================

.. versionadded:: 12.0
   This event has been introduced together with
   :ref:`ModifyLinkHandlersEvent` to
   serve as a direct replacement for following removed hook:

   *  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']

   It replaces the method :php:`modifyAllowedItems()` in this hook.

This  allows extensions to add or remove from the list of allowed link types.

.. seealso::

   *  :ref:`modifyLinkHandlers`
   *  :ref:`ModifyLinkHandlersEvent`

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\Recordlist\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/recordlist/link-handlers'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Recordlist/MyEventListener.php

   use TYPO3\CMS\Recordlist\Event\ModifyAllowedItemsEvent;

   final class MyEventListener
   {
       public function __invoke(ModifyAllowedItemsEvent $event): void
       {
           $event->addAllowedItem('someItem');
           $event->removeAllowedItem('anotherItem');
       }
   }



API
===

.. include:: /CodeSnippets/Events/RecordList/ModifyAllowedItemsEvent.rst.txt
