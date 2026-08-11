..  include:: /Includes.rst.txt
..  index:: Events; EntityAddedToPersistenceEvent
..  _EntityAddedToPersistenceEvent:

===============================
`EntityAddedToPersistenceEvent`
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Persistence\EntityAddedToPersistenceEvent`
is dispatched after persisting the object, but before updating the reference
index and adding the object to the persistence session.

..  _entity-added-to-persistence-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _entity-added-to-persistence-event-api:

API
===

..  include:: /CodeSnippets/Events/Extbase/EntityAddedToPersistenceEvent.rst.txt
