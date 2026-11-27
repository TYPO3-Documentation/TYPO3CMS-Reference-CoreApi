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

*   References in fields of type `flex`.
*   References in fields of type `inline` or `file`, in all relations except
    `MM` relations:

    *   Relations with `foreign_field`.
    *   Relations that the parent field stores as a comma-separated list.
    *   Relations with the
        `relationship <https://docs.typo3.org/permalink/t3tca:confval-inline-relationship>`_
        `oneToOne` or `manyToOne`.

..  versionchanged:: 14.3.11
    :changelog: important-111339-1793809730

    Up to TYPO3 14.3.10, the Core listener did not mark relations with the
    relationship `oneToOne` or `manyToOne` as dependencies.

This event allows extensions to opt in additional custom fields, for example
those storing a parent-child relationship outside of TCA's built-in relation
types.

A listener can also get this information about the reference:

*   :php:`getFlexPointer()` returns the FlexForm field of the reference.
*   :php:`isSoftReference()` returns whether the reference is a soft
    reference, such as a link in a rich text field.
*   :php:`getSoftReferenceKey()` returns the key of the soft reference parser
    that found the reference.
*   :php:`getSoftReferenceId()` returns the identifier of the soft reference
    in the field value.
*   :php:`getDirection()` returns the direction of the lookup:

    *   `DependencyLookupDirection::Children`: The resolver collects the
        children of the record with the field.
    *   `DependencyLookupDirection::Parents`: The resolver collects the
        parents of the referenced record.

..  versionchanged:: 14.3.11
    :changelog: important-111343-1793811746

    Up to TYPO3 14.3.10, the event did not have these methods.

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
