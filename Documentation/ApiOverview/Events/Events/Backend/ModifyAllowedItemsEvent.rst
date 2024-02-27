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

..  literalinclude:: _ModifyAllowedItemsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyAllowedItemsEvent.rst.txt
