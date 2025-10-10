..  include:: /Includes.rst.txt
..  index:: Events; IsTableExcludedFromReferenceIndexEvent
..  _IsTableExcludedFromReferenceIndexEvent:

======================================
IsTableExcludedFromReferenceIndexEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\DataHandling\Event\IsTableExcludedFromReferenceIndexEvent`
allows to intercept, if a certain table should be excluded from the
`Reference Index <https://docs.typo3.org/permalink/t3coreapi:db-reference-index>`_.
There is no need to add tables without a definition in :php:`$GLOBALS['TCA']`
since the reference index only handles those.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/IsTableExcludedFromReferenceIndexEvent.rst.txt
