.. include:: /Includes.rst.txt
.. index:: Events; IsTableExcludedFromReferenceIndexEvent
.. _IsTableExcludedFromReferenceIndexEvent:

======================================
IsTableExcludedFromReferenceIndexEvent
======================================

Event to intercept if a certain table should be excluded from the Reference Index.
There is no need to add tables without a definition in $GLOBALS['TCA'] since
ReferenceIndex only handles those.

API
---

.. include:: /CodeSnippets/Events/Core/IsTableExcludedFromReferenceIndexEvent.rst.txt
