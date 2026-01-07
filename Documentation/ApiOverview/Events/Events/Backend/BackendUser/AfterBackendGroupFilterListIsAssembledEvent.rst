..  include:: /Includes.rst.txt
..  index:: Events; AfterBackendGroupFilterListIsAssembledEvent
..  _AfterBackendGroupFilterListIsAssembledEvent:

===========================================
AfterBackendGroupFilterListIsAssembledEvent
===========================================

..  versionadded:: 14.0

A list of user groups can be used to filter the users list in the backend module.
The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterBackendGroupFilterListIsAssembledEvent`
is dispatched right after this list is assembled and makes it possible to modify it.

..  note::
    This is a sensitive area in terms of security. Please ensure that you
    are not introducing any breach of security when using this event, for example,
    by revealing restricted information.

Example
=======

..  literalinclude:: _AfterBackendGroupFilterListIsAssembledEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/BackendUsers/AfterBackendGroupFilterListIsAssembledEvent.txt


