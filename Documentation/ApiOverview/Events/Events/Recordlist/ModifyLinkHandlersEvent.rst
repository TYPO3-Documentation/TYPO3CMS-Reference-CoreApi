.. include:: /Includes.rst.txt
.. index:: Events; ModifyLinkHandlersEvent
.. _ModifyLinkHandlersEvent:


=======================
ModifyLinkHandlersEvent
=======================

.. versionadded:: 12.0
   This event has been introduced together with
   :ref:`ModifyAllowedItemsEvent` to
   serve as a direct replacement for the following removed hook:

   *  :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']`

   It replaces the method :php:`modifyLinkHandlers()` in this hook.

This event is triggered before link handlers are executed, allowing listeners
to modify the set of handlers that will be used.

.. seealso::
   *  :ref:`modifyLinkHandlers`
   *  :ref:`ModifyAllowedItemsEvent`

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

   use TYPO3\CMS\Recordlist\Event\ModifyLinkHandlersEvent;

   final class MyEventListener
   {
       public function __invoke(ModifyLinkHandlersEvent $event): void
       {
           $handler = $event->getHandler('url.');
           $handler['label'] = 'My custom label';
           $event->setHandler('url.', $handler);
       }
   }


API
===

.. include:: /CodeSnippets/Events/RecordList/ModifyLinkHandlersEvent.rst.txt
