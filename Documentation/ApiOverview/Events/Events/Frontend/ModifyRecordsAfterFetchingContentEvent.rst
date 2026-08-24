..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordsAfterFetchingContentEvent
..  _ModifyRecordsAfterFetchingContentEvent:

========================================
`ModifyRecordsAfterFetchingContentEvent`
========================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\ModifyRecordsAfterFetchingContentEvent`
allows to modify the fetched records next to the possibility to manipulate most
of the options, such as `slide`. Listeners are also able to set the final
content and change the whole TypoScript configuration, used for further
processing.

..  _modify-records-after-fetching-content-event-example:

Example
=======

..  literalinclude:: _ModifyRecordsAfterFetchingContentEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  _modify-records-after-fetching-content-event-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyRecordsAfterFetchingContentEvent.rst.txt
