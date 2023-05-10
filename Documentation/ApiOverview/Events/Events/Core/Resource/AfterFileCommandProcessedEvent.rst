..  include:: /Includes.rst.txt
..  index:: Events; AfterFileCommandProcessedEvent
..  _AfterFileCommandProcessedEvent:

==============================
AfterFileCommandProcessedEvent
==============================

..  versionadded:: 11.4

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileCommandProcessedEvent` can be used
to perform additional tasks for specific file commands. For example, trigger a
custom indexer after a file has been uploaded.

This event is fired in the
:php:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility` class.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterFileCommandProcessedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterFileCommandProcessedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileCommandProcessedEvent.rst.txt
