..  include:: /Includes.rst.txt
..  index:: Events; ModifyDatabaseQueryForContentEvent
..  _ModifyDatabaseQueryForContentEvent:

====================================
`ModifyDatabaseQueryForContentEvent`
====================================

Use the PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForContentEvent`
to filter out certain content elements from being shown in the
:guilabel:`Content > Layout` module.

..  _modify-database-query-for-content-event-example:

Example
=======

..  literalinclude:: _ModifyDatabaseQueryForContentEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-database-query-for-content-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyDatabaseQueryForContentEvent.rst.txt
