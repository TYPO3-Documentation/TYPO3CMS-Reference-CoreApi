..  include:: /Includes.rst.txt
..  index:: Events; ModifyLinkHandlersEvent
..  _ModifyLinkHandlersEvent:

=======================
ModifyLinkHandlersEvent
=======================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent`
is triggered before link handlers are executed, allowing listeners
to modify the set of handlers that will be used.

..  seealso::
    *   :ref:`modifyLinkHandlers`
    *   :ref:`ModifyAllowedItemsEvent`

Example
=======

..  literalinclude:: _ModifyLinkHandlersEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

.. include:: /CodeSnippets/Events/Backend/ModifyLinkHandlersEvent.rst.txt
