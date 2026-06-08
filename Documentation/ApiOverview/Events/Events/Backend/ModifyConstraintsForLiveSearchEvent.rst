..  include:: /Includes.rst.txt
..  index:: Events; ModifyConstraintsForLiveSearchEvent
..  _ModifyConstraintsForLiveSearchEvent:

===================================
ModifyConstraintsForLiveSearchEvent
===================================

..  versionadded:: 14.2
The PSR-14 event :php-short:`\TYPO3\CMS\Backend\Search\Event\ModifyConstraintsForLiveSearchEvent`
is fired in the :php:`\TYPO3\CMS\Backend\Search\LiveSearch\LiveSearch` class
and allows search constraints to be added or removed before a search is executed.

This event allows extensions to modify the :php:`CompositeExpression` OR-combined constraints
by adding or removing constraints from an array.
This event was necessary because the main
query modifícation event :php:`\TYPO3\CMS\Backend\Search\Event\ModifyQueryForLiveSearchEvent`
cannot access query constraints.

..  _ModifyConstraintsForLiveSearchEvent-example:

Example
=======

..  literalinclude:: _ModifyConstraintsForLiveSearchEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _ModifyConstraintsForLiveSearchEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyConstraintsForLiveSearchEvent.rst.txt

..  hint::

    Constraints are only intended to be added to this event so that there is
    no negative impact on security-related mandatory constraints added by Core/extensions.
    This means that constraints cannot be removed after they have been added.
