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
    hooks, which have been deprecated with TYPO3 v13.2.

The event :php:`TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadIsExecutedEvent`
can be used to modify the result of a download / export initiated via
the :guilabel:`Content > Records` module.

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
