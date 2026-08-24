..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLayoutContentEvent
..  _ModifyPageLayoutContentEvent:

==============================
`ModifyPageLayoutContentEvent`
==============================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent`
allows to modify page module content.

It is possible to add additional content, overwrite existing
content or reorder the content.

..  _modify-page-layout-content-event-example:

Example
=======

..  literalinclude:: _ModifyPageLayoutContentEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-page-layout-content-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyPageLayoutContentEvent.rst.txt
