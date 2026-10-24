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

Example: Add a history action to content element results
========================================================

The following listener adds an action to every content element in the
search results. The action opens the history of the record:

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_ShowHistoryActionListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/ShowHistoryActionListener.php

..  _modify-result-item-in-live-search-event-property:

Example: Show a property in the detail panel of a search result
===============================================================

..  versionadded:: 14.3
    :changelog: important-109787-1730981200

A search result can show a thumbnail and a list of properties in its detail
panel. Call
:php-short:`\TYPO3\CMS\Backend\Search\LiveSearch\ResultItem::addProperty()`
with a label and a value to add a property. Call
:php-short:`\TYPO3\CMS\Backend\Search\LiveSearch\ResultItem::setThumbnailUrl()`
with the URL of a preview image to show a thumbnail instead of the icon.

The following listener shows the UID of every content element in the detail
panel:

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_RecordUidPropertyListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/RecordUidPropertyListener.php

..  _modify-result-item-in-live-search-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent
