..  include:: /Includes.rst.txt
..  index:: Events; ModifyQueryForLiveSearchEvent
..  _ModifyQueryForLiveSearchEvent:

=============================
ModifyQueryForLiveSearchEvent
=============================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Search\Event\ModifyQueryForLiveSearchEvent`
can be used to modify the live search queries in the backend.

This can be used to adjust the limit for a specific table or to change the
result order.

This event is fired in the
:php:`\TYPO3\CMS\Backend\Search\LiveSearch\LiveSearch` class
and allows extensions to modify the :ref:`query builder <database-query-builder>`
instance before execution.

Example
=======

..  literalinclude:: _ModifyQueryForLiveSearchEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Backend/ModifyQueryForLiveSearchEvent.rst.txt
