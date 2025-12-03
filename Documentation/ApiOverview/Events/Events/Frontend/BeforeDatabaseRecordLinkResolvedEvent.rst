..  include:: /Includes.rst.txt
..  index:: Events; BeforeDatabaseRecordLinkResolvedEvent
..  _BeforeDatabaseRecordLinkResolvedEvent:

=====================================
BeforeDatabaseRecordLinkResolvedEvent
=====================================

..  versionadded:: 14.0
    The event :php-short:`TYPO3\CMS\Frontend\Event\BeforeDatabaseRecordLinkResolvedEvent`
    has been introduced to retrieve records via custom code in
    :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`.

The PSR-14 event :php:`TYPO3\CMS\Frontend\Event\BeforeDatabaseRecordLinkResolvedEvent`
is dispatched immediately before database record lookup is done
for a link by the DatabaseRecordLinkBuilder and therefore allows
custom functionality to be attached to record retrieval. The event is stoppable,
which means that as soon as a listener returns a record, no further listener
gets called and the core does no further lookup.

The event is dispatched with :php:`$record` set to :php:`null`. If an event
listener retrieves a record from the database, it should set the :php:`$record`
property to the record as an array. This will stop the event propagation and
cause the default record retrieval logic in
:php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder` to be skipped.

..  important::

    The event is stoppable: Setting the :php:`$record` property to a non-null
    value stops event propagation and skips the default record retrieval logic.

Note that the custom code needs to take care - if relevant - of all aspects
normally handled by :php:`TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder`,
such as record visibility, language overlay or version overlay.

The event provides access to the following public properties:

* :php:`$linkDetails`: Information about the link being processed
* :php:`$databaseTable`: The name of the database the record belongs to
* :php:`$typoscriptConfiguration`: The full TypoScript link handler configuration
* :php:`$tsConfig`: The full TSconfig link handler configuration
* :php:`$request`: The current request object
* :php:`$record`: The database record as an array (initially :php:`null`)

..  _BeforeDatabaseRecordLinkResolvedEvent-example:

Example
=======

..  literalinclude:: _BeforeDatabaseRecordLinkResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  _BeforeDatabaseRecordLinkResolvedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/BeforeDatabaseRecordLinkResolvedEvent.rst.txt
