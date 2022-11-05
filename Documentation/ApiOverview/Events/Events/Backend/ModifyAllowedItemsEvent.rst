..  include:: /Includes.rst.txt
..  index:: Events; ModifyAllowedItemsEvent
..  _ModifyAllowedItemsEvent:


=======================
ModifyAllowedItemsEvent
=======================

..  versionadded:: 12.0
    This event has been introduced together with
    :ref:`ModifyLinkHandlersEvent` to
    serve as a direct replacement for the following removed hook:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']`

    It replaces the method :php:`modifyAllowedItems()` in this hook.

The event allows extensions to add or remove from the list of allowed link
types.

..  seealso::

    *   :ref:`modifyLinkHandlers`
    *   :ref:`ModifyLinkHandlersEvent`

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    Vendor\MyExtension\Backend\MyEventListener:
        tags:
            - name: event.listener
              identifier: 'my-extension/backend/allowed-items'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent;

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

.. include:: /CodeSnippets/Events/Backend/ModifyAllowedItemsEvent.rst.txt
