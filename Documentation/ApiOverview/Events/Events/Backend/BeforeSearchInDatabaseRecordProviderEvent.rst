..  include:: /Includes.rst.txt
..  index:: Events; BeforeSearchInDatabaseRecordProviderEvent
..  _BeforeSearchInDatabaseRecordProviderEvent:

=========================================
BeforeSearchInDatabaseRecordProviderEvent
=========================================

In some individual cases it may not be desirable to search in a specific table.
Therefore, the PSR-14 event
:php:`\TYPO3\CMS\Backend\Search\Event\BeforeSearchInDatabaseRecordProviderEvent`
is available, which allows to exclude / ignore such tables by adding them
to a deny list. Additionally, the PSR-14 event can be used to restrict the
search result on certain page IDs or to modify the search query altogether.


Example
=======

..  literalinclude:: _BeforeSearchInDatabaseRecordProviderEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Backend/BeforeSearchInDatabaseRecordProviderEvent.rst.txt
