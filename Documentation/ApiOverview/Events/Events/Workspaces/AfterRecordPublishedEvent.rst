..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordPublishedEvent
..  _AfterRecordPublishedEvent:


=========================
AfterRecordPublishedEvent
=========================

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent` is
fired after a record has been published in a workspace.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

Example
=======

..  literalinclude:: _AfterRecordPublishedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Workspaces/AfterRecordPublishedEvent.rst.txt
