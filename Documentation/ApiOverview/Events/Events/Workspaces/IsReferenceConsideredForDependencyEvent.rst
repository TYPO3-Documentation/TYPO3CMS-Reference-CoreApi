..  include:: /Includes.rst.txt
..  index:: Events; IsReferenceConsideredForDependencyEvent
..  _IsReferenceConsideredForDependencyEvent:

=========================================
`IsReferenceConsideredForDependencyEvent`
=========================================

..  versionadded:: 14.2
    See `Feature: #108992 - New PSR-14 event for workspace dependency resolution <https://docs.typo3.org/permalink/changelog:feature-108992-1739706000>`_.

The PSR-14 event
:php:`\TYPO3\CMS\Workspaces\Event\IsReferenceConsideredForDependencyEvent`
is dispatched per :sql:`sys_refindex` row when the workspace dependency
resolver evaluates which references constitute structural dependencies
during publish, stage change, discard, or display operations.

References are opt-in: a reference is not considered a dependency unless a
listener explicitly marks it as one via :php:`setDependency()`. TYPO3 Core
registers a listener that marks `type=inline`, `type=file` (with
`foreign_field`), and `type=flex` fields as dependencies; this
event allows extensions to opt in additional custom fields, for example
those storing a parent-child relationship outside of TCA's built-in
relation types.

..  _IsReferenceConsideredForDependencyEvent-example:

Example: Treat a custom parent-reference field as a dependency
==============================================================

The following listener marks a custom `tx_container_parent` field on
the :sql:`tt_content` table as a workspace dependency, so that publishing,
staging, or discarding a child record also considers its parent:

..  literalinclude:: _IsReferenceConsideredForDependencyEvent/_MarkContainerParentAsWorkspaceDependencyListener.php
    :caption: EXT:my_extension/Classes/EventListener/MarkContainerParentAsWorkspaceDependencyListener.php

..  _IsReferenceConsideredForDependencyEvent-api:

API
===

..  include:: /CodeSnippets/Events/Workspaces/IsReferenceConsideredForDependencyEvent.rst.txt
