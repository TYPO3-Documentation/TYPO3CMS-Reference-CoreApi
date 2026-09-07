..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordPublishedEvent
..  _AfterRecordPublishedEvent:


===========================
`AfterRecordPublishedEvent`
===========================

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent` is
fired after a record has been published in a workspace.

..  _after-record-published-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-record-published-event-example-2:

Example
=======

..  literalinclude:: _AfterRecordPublishedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/MyEventListener.php

..  _after-record-published-event-api:

API
===

..  include:: /CodeSnippets/Events/Workspaces/AfterRecordPublishedEvent.rst.txt
