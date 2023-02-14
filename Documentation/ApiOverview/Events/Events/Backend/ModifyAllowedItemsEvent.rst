..  include:: /Includes.rst.txt
..  index:: Events; ModifyAllowedItemsEvent
..  _ModifyAllowedItemsEvent:


=======================
ModifyAllowedItemsEvent
=======================

..  versionadded:: 12.0
    This event has been introduced together with
    :ref:`ModifyLinkHandlersEvent` to
    serve as a direct replacement for the following removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']`.
    It replaces the method :php:`modifyAllowedItems()` in this hook.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent`
allows extension authors to add or remove from the list of allowed link
types.

..  seealso::

    *   :ref:`modifyLinkHandlers`
    *   :ref:`ModifyLinkHandlersEvent`

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
        tags:
            - name: event.listener
              identifier: 'my-extension/backend/allowed-items'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent;

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

..  include:: /CodeSnippets/Events/Backend/ModifyAllowedItemsEvent.rst.txt
