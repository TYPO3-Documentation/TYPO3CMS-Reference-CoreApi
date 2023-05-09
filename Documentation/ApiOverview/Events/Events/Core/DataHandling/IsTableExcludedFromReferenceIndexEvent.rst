..  include:: /Includes.rst.txt
..  index:: Events; IsTableExcludedFromReferenceIndexEvent
..  _IsTableExcludedFromReferenceIndexEvent:

======================================
IsTableExcludedFromReferenceIndexEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\DataHandling\Event\IsTableExcludedFromReferenceIndexEvent`
allows to intercept, if a certain table should be excluded from the
:ref:`reference index <ext_lowlevel:module-db-check-Manage-Reference-Index>`.
There is no need to add tables without a definition in :php:`$GLOBALS['TCA']`
since the reference index only handles those.

API
===

..  include:: /CodeSnippets/Events/Core/IsTableExcludedFromReferenceIndexEvent.rst.txt
