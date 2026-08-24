..  include:: /Includes.rst.txt
..  index:: Events; ModifyDatabaseQueryForRecordListingEvent
..  _ModifyDatabaseQueryForRecordListingEvent:

==========================================
`ModifyDatabaseQueryForRecordListingEvent`
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent`
allows to alter the :ref:`query builder <database-query-builder>` SQL
statement before a list of records is rendered in record lists, such as
the :guilabel:`List` module or an element browser.

..  _modify-database-query-for-record-listing-event-example:

Example
=======

..  literalinclude:: _ModifyDatabaseQueryForRecordListingEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-database-query-for-record-listing-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyDatabaseQueryForRecordListingEvent.rst.txt
