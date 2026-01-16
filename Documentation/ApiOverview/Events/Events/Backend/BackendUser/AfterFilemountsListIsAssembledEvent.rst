..  include:: /Includes.rst.txt
..  index:: Events; AfterFilemountsListIsAssembledEvent
..  _AfterFilemountsListIsAssembledEvent:

===================================
AfterFilemountsListIsAssembledEvent
===================================

..  versionadded:: 14.0

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterFilemountsListIsAssembledEvent`
is dispatched when the file mounts list is fetched to be displayed
in the backend module. It makes it possible to modify this list.

..  note::
    This is a sensitive area in terms of security. Please ensure that you
    are not introducing any breach of security when using this event, for example,
    by revealing restricted information.

Example
=======

..  literalinclude:: _AfterFilemountsListIsAssembledEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/BackendUsers/AfterFilemountsListIsAssembledEvent.txt


