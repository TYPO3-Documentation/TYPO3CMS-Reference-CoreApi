..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileDeletedEvent
..  _BeforeFileDeletedEvent:

======================
BeforeFileDeletedEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileDeletedEvent`
is fired before a file is about to be deleted.

Event listeners can clean up third-party references with this event.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileDeletedEvent.rst.txt
