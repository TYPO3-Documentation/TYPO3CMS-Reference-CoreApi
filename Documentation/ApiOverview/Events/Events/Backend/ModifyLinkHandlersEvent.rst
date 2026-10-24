..  include:: /Includes.rst.txt
..  index:: Events; ModifyLinkHandlersEvent
..  _ModifyLinkHandlersEvent:

=========================
`ModifyLinkHandlersEvent`
=========================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent`
is triggered before link handlers are executed, allowing listeners
to modify the set of handlers that will be used.

..  seealso::
    *   :ref:`Events to modify link handler <modifylinkhandlers>`
    *   :ref:`ModifyAllowedItemsEvent <ModifyAllowedItemsEvent>`

..  _modify-link-handlers-event-example:

Example: Change the label of the URL link handler
=================================================

..  literalinclude:: _ModifyLinkHandlersEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php


..  _modify-link-handlers-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent
