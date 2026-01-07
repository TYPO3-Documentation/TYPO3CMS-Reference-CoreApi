..  include:: /Includes.rst.txt
..  index:: Events; AfterBackendGroupListConstraintsAssembledFromDemandEvent
..  _AfterBackendGroupListConstraintsAssembledFromDemandEvent:

========================================================
AfterBackendGroupListConstraintsAssembledFromDemandEvent
========================================================

..  versionadded:: 14.0

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\AfterBackendGroupListConstraintsAssembledFromDemandEvent`
is dispatched when the backend user repository fetches a list of
filtered backend groups (itself called when displaying the list of groups
in the backend module). It makes it possible to modify query constraints
based on currently active filtering.

..  note::
    This is a sensitive area in terms of security. Please ensure that you
    are not introducing any breach of security when using this event, for example,
    by revealing restricted information.

Example
=======

..  literalinclude:: _AfterBackendGroupListConstraintsAssembledFromDemandEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/BackendUsers/AfterBackendGroupListConstraintsAssembledFromDemandEvent.txt


