.. include:: /Includes.rst.txt
.. index:: Events; GetVersionedDataEvent
.. _GetVersionedDataEvent:


=====================
GetVersionedDataEvent
=====================

Used in the workspaces module to find all data of versions of a workspace.
In comparison to AfterDataGeneratedForWorkspaceEvent, this one contains the
cleaned / prepared data with an optional limit applied depending on the view.

API
---

.. include:: /CodeSnippets/Events/Workspaces/GetVersionedDataEvent.rst.txt
