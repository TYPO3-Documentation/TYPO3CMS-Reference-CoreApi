..  include:: /Includes.rst.txt
..  index:: Events; AfterBackendUserListConstraintsAssembledFromDemandEvent
..  _AfterBackendUserListConstraintsAssembledFromDemandEvent:

=========================================================
`AfterBackendUserListConstraintsAssembledFromDemandEvent`
=========================================================

..  versionadded:: 14.0

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\AfterBackendUserListConstraintsAssembledFromDemandEvent`
is dispatched when the backend user repository fetches a list of
filtered backend users (itself called when displaying the list of users
in the backend module). It makes it possible to modify query constraints
based on currently active filtering.

..  note::
    This is a sensitive area in terms of security. Please ensure that you
    are not introducing any breach of security when using this event, for example,
    by revealing restricted information.

..  _after-backend-user-list-constraints-assembled-from-demand-event-example:

Example
=======

..  literalinclude:: _AfterBackendUserListConstraintsAssembledFromDemandEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _after-backend-user-list-constraints-assembled-from-demand-event-api:

API
===

..  include:: /CodeSnippets/Events/BackendUsers/AfterBackendUserListConstraintsAssembledFromDemandEvent.txt
