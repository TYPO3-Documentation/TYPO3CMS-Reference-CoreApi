..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordPublishedEvent
..  _AfterRecordPublishedEvent:


=========================
AfterRecordPublishedEvent
=========================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent` is
fired after a record has been published in a workspace.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterRecordPublishedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterRecordPublishedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Workspaces/AfterRecordPublishedEvent.rst.txt
