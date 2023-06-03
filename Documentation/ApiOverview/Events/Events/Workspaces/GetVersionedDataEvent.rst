..  include:: /Includes.rst.txt
..  index:: Events; GetVersionedDataEvent
..  _GetVersionedDataEvent:


=====================
GetVersionedDataEvent
=====================

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\GetVersionedDataEvent`
is used in the :guilabel:`Web > Workspaces` module to find all data of versions
of a workspace. In comparison to :ref:`AfterDataGeneratedForWorkspaceEvent`,
this one contains the cleaned / prepared data with an optional limit applied
depending on the view.

API
===

..  include:: /CodeSnippets/Events/Workspaces/GetVersionedDataEvent.rst.txt
