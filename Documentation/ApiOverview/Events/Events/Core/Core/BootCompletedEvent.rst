..  include:: /Includes.rst.txt
..  index:: Events; BootCompletedEvent
..  _BootCompletedEvent:

==================
BootCompletedEvent
==================

The PSR-14 event :php:`\TYPO3\CMS\Core\Core\Event\BootCompletedEvent` is fired
on every request when TYPO3 has been fully booted, right after all configuration
files have been added.

This event complements the :ref:`AfterTcaCompilationEvent` which is executed
after TCA configuration has been assembled.

Use cases for this event include running extension's code which needs to be
executed at any time and needs TYPO3's full configuration including all loaded
extensions.

Example
=======

..  literalinclude:: _BootCompletedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Bootstrap/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BootCompletedEvent.rst.txt
