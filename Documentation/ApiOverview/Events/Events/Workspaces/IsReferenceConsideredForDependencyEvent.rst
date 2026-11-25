..  include:: /Includes.rst.txt
..  index:: Events; IsReferenceConsideredForDependencyEvent
..  _IsReferenceConsideredForDependencyEvent:

=========================================
`IsReferenceConsideredForDependencyEvent`
=========================================

..  versionadded:: 14.2
    :changelog: feature-108992-1739706000

The PSR-14 event
:php:`\TYPO3\CMS\Workspaces\Event\IsReferenceConsideredForDependencyEvent`
is dispatched per :sql:`sys_refindex` row when the workspace dependency
resolver evaluates which references constitute structural dependencies
during publish, stage change, discard, or display operations.

References are opt-in: a reference is not considered a dependency unless a
listener explicitly marks it as one via :php:`setDependency()`. TYPO3 Core
registers a listener that marks these references as dependencies:

*   References of fields of type `flex`.
*   References of fields of type `inline` or `file`, unless the relation is
    stored in an `MM` table. This includes relations with `foreign_field`,
    relations stored as a comma-separated list in the parent field, and
    relations with the
    `relationship <https://docs.typo3.org/permalink/t3tca:confval-inline-relationship>`_
    `oneToOne` or `manyToOne`.

..  versionchanged:: 14.3.11
    :changelog: important-111339-1793809730

    Before, the Core listener did not mark references of `inline` and `file`
    fields with the relationship `oneToOne` or `manyToOne` as dependencies.

This event allows extensions to opt in additional custom fields, for example
those storing a parent-child relationship outside of TCA's built-in relation
types.

..  versionchanged:: 14.3.11
    :changelog: important-111343-1793811746

    Before, the event did not provide the FlexForm field, the soft reference,
    and the direction of the lookup.

Besides the table, the field, and the referenced record, the event tells a
listener more about the reference:

*   :php:`getFlexPointer()` returns the FlexForm field of the reference.
*   :php:`getSoftReferenceKey()`, :php:`getSoftReferenceId()`, and
    :php:`isSoftReference()` describe a soft reference, such as a link in a
    rich text field.
*   :php:`getDirection()` returns whether the resolver collects the parents or
    the children of a record, as `DependencyLookupDirection::Parents` or
    `DependencyLookupDirection::Children`.

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

..  typo3:api-class:: \TYPO3\CMS\Workspaces\Event\IsReferenceConsideredForDependencyEvent
