..  include:: /Includes.rst.txt
..  index:: Events; GetVersionedDataEvent
..  _GetVersionedDataEvent:


=====================
GetVersionedDataEvent
=====================

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\GetVersionedDataEvent`
is used in the :guilabel:`Content > Workspaces` module to find all data of versions
of a workspace. In comparison to :ref:`AfterDataGeneratedForWorkspaceEvent`,
this one contains the cleaned / prepared data with an optional limit applied
depending on the view.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Workspaces/GetVersionedDataEvent.rst.txt
