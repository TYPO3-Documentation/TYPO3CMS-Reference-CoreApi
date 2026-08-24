..  include:: /Includes.rst.txt
..  index:: Events; ModifyQueryBeforeFetchingObjectDataEvent
..  _ModifyQueryBeforeFetchingObjectDataEvent:

==========================================
`ModifyQueryBeforeFetchingObjectDataEvent`
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent`
is fired before the storage backend is asked for results from a given query.

..  _modify-query-before-fetching-object-data-event-example:

Example
=======

The example disables the respect storage page flag for the given types (models).
This can be helpful if you are using bounded contexts and therefore have multiple
repository and model classes. By using an event listener, this setting is
centralized and does not to be repeated in each repository class.

..  literalinclude:: _ModifyQueryBeforeFetchingObjectDataEvent/_DisableRespectStoragePage.php
    :caption: EXT:my_extension/Classes/Extbase/EventListener/DisableRespectStoragePage.php

..  _modify-query-before-fetching-object-data-event-api:

API
===

..  include:: /CodeSnippets/Events/Extbase/ModifyQueryBeforeFetchingObjectDataEvent.rst.txt
