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

..  literalinclude:: _ModifyAllowedItemsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyAllowedItemsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyAllowedItemsEvent.rst.txt
