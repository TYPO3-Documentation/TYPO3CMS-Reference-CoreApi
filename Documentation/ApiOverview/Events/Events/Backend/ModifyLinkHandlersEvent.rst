..  include:: /Includes.rst.txt
..  index:: Events; ModifyLinkHandlersEvent
..  _ModifyLinkHandlersEvent:


=======================
ModifyLinkHandlersEvent
=======================

..  versionadded:: 12.0
    This event has been introduced together with
    :ref:`ModifyAllowedItemsEvent` to
    serve as a direct replacement for the following removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']`.
    It replaces the method :php:`modifyLinkHandlers()` in this hook.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent`
is triggered before link handlers are executed, allowing listeners
to modify the set of handlers that will be used.

..  seealso::
    *   :ref:`modifyLinkHandlers`
    *   :ref:`ModifyAllowedItemsEvent`

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
        tags:
            - name: event.listener
              identifier: 'my-extension/backend/link-handlers'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent;

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

.. include:: /CodeSnippets/Events/Backend/ModifyLinkHandlersEvent.rst.txt
