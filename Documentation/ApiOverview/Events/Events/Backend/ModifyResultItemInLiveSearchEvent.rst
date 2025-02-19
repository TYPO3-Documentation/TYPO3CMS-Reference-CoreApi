..  include:: /Includes.rst.txt
..  index:: Events; ModifyResultItemInLiveSearchEvent
..  _ModifyResultItemInLiveSearchEvent:

=================================
ModifyResultItemInLiveSearchEvent
=================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent`
allows extension developers to take control over search result
items rendered in the backend search.

Example
=======

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyResultItemInLiveSearchEvent.rst.txt
