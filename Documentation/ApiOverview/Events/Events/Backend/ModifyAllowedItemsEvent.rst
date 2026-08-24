..  include:: /Includes.rst.txt
..  index:: Events; ModifyAllowedItemsEvent
..  _ModifyAllowedItemsEvent:


=========================
`ModifyAllowedItemsEvent`
=========================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent`
allows extension authors to add or remove from the list of allowed link
types.

..  seealso::

    *   :ref:`modifyLinkHandlers`
    *   :ref:`ModifyLinkHandlersEvent`

..  _modify-allowed-items-event-example:

Example
=======

..  literalinclude:: _ModifyAllowedItemsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-allowed-items-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyAllowedItemsEvent.rst.txt
