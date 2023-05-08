..  include:: /Includes.rst.txt
..  index:: Events; RecordAccessGrantedEvent
..  _RecordAccessGrantedEvent:

========================
RecordAccessGrantedEvent
========================

..  versionadded:: 12.0
    This event serves as replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_checkEnableFields']`.

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent`
can be used to either define whether a record access is granted
for a user, or to modify the record in question. In case the :php:`$accessGranted`
property is set (either :php:`true` or :php:`false`), the defined settings are
directly used, skipping any further event listener as well as any further
evaluation.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _RecordAccessGrantedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _RecordAccessGrantedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Access/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/RecordAccessGrantedEvent.rst.txt
