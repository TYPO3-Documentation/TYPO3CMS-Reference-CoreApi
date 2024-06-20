..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordDownloadIsExecutedEvent
..  _BeforeRecordDownloadIsExecutedEvent:

===================================
BeforeRecordDownloadIsExecutedEvent
===================================

..  versionadded:: 13.2
    This PSR-14 event replaces the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['customizeCsvHeader']`
    and
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['customizeCsvRow']`,
    hooks, which have been deprecated with TYPO3 v13.2. See also
    :ref:`BeforeRecordDownloadIsExecutedEvent-migration`.

The event :php:`TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadIsExecutedEvent`
can be used to modify the result of a download / export initiated via
the :guilabel:`Web > List` module.

The event lets you change both the main part and the header of the data file.
You can use it to edit data to follow GDPR rules, change or translate data,
create backups or web hooks, record who accesses the data, and more.

..  contents:: Table of contents

..  _BeforeRecordDownloadIsExecutedEvent-example:

Example: Redact columns with private content in exports
=======================================================

..  literalinclude:: _BeforeRecordDownloadIsExecutedEvent/_DataListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/DataListener.php

..  _BeforeRecordDownloadIsExecutedEvent-api:

API of BeforeRecordDownloadIsExecutedEvent
==========================================

..  include:: /CodeSnippets/Events/Backend/BeforeRecordDownloadIsExecutedEvent.rst.txt

..  _BeforeRecordDownloadIsExecutedEvent-migration:

Migration
=========

..  deprecated:: 13.2
    The previously used hooks
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['customizeCsvHeader']`
    and
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['customizeCsvRow']`,
    used to manipulate the download / export configuration of records, triggered
    in the :guilabel:`Web > List` backend module, have been deprecated in favor of a
    new PSR-14 event :php:`TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadIsExecutedEvent`.

..  _BeforeRecordDownloadIsExecutedEvent-migration-customizeCsvHeader:

Migrating :php:`customizeCsvHeader`
-----------------------------------

The prior hook parameter/variable :php:`fields` is now available via
:php:`$event->getColumnsToRender()`. The actual record data
(previously :php:`$this->recordList`, submitted to the hook as its object
reference) is accessible via :php:`$event->getHeaderRow()`.

..  _BeforeRecordDownloadIsExecutedEvent-migration-customizeCsvRow:

Migrating :php:`customizeCsvRow`
--------------------------------

The following prior hook parameters/variables have these substitutes:

:php:`databaseRow`
    is now available via :php:`$event->getRecords()` (see note below).
:php:`tableName`
    is now available via :php:`$event->getTable()`.
:php:`pageId`
    is now available via :php:`$event->getId()`.

The actual record data
(previously :php:`$this->recordList`, submitted to the hook as its object
reference) is accessible via :php:`$event->getRecords()`.

Please note that the hook was previously executed once per row retrieved
from the database. The PSR-14 event however - due to performance reasons -
is only executed for the full record list after database retrieval,
thus allows post-processing on this whole dataset.
