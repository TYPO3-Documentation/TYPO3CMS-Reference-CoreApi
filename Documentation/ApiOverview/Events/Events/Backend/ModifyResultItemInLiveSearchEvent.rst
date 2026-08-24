..  include:: /Includes.rst.txt
..  index:: Events; ModifyResultItemInLiveSearchEvent
..  _ModifyResultItemInLiveSearchEvent:

===================================
`ModifyResultItemInLiveSearchEvent`
===================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent`
allows extension developers to take control over search result
items rendered in the backend search.

..  _modify-result-item-in-live-search-event-example:

Example
=======

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-result-item-in-live-search-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyResultItemInLiveSearchEvent.rst.txt
