..  include:: /Includes.rst.txt
..  index:: Events; RecordAccessGrantedEvent
..  _RecordAccessGrantedEvent:

========================
RecordAccessGrantedEvent
========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent`
can be used to either define whether a record access is granted
for a user, or to modify the record in question. In case the :php:`$accessGranted`
property is set (either :php:`true` or :php:`false`), the defined settings are
directly used, skipping any further event listener as well as any further
evaluation.

Example
=======

..  literalinclude:: _RecordAccessGrantedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Access/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/RecordAccessGrantedEvent.rst.txt
