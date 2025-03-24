..  include:: /Includes.rst.txt
..  index:: Events; ModifyQueryBeforeFetchingObjectDataEvent
..  _ModifyQueryBeforeFetchingObjectDataEvent:

========================================
ModifyQueryBeforeFetchingObjectDataEvent
========================================

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent`
is fired before the storage backend is asked for results from a given query.

Example
=======

The example disables the respect storage page flag for the given types (models).
This can be helpful if you are using bounded contexts and therefore have multiple
repository and model classes. By using an event listener, this setting is
centralized and does not to be repeated in each repository class.

..  literalinclude:: _ModifyQueryBeforeFetchingObjectDataEvent/_DisableRespectStoragePage.php
    :language: php
    :caption: EXT:my_extension/Classes/Extbase/EventListener/DisableRespectStoragePage.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Extbase/ModifyQueryBeforeFetchingObjectDataEvent.rst.txt
