..  include:: /Includes.rst.txt
..  index:: Events; AfterFileCommandProcessedEvent
..  _AfterFileCommandProcessedEvent:

==============================
AfterFileCommandProcessedEvent
==============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileCommandProcessedEvent` can be used
to perform additional tasks for specific file commands. For example, trigger a
custom indexer after a file has been uploaded.

This event is fired in the
:php:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility` class.

Example
=======

..  literalinclude:: _AfterFileCommandProcessedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileCommandProcessedEvent.rst.txt
