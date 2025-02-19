..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLayoutContentEvent
..  _ModifyPageLayoutContentEvent:

============================
ModifyPageLayoutContentEvent
============================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent`
allows to modify page module content.

It is possible to add additional content, overwrite existing
content or reorder the content.

Example
=======

..  literalinclude:: _ModifyPageLayoutContentEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyPageLayoutContentEvent.rst.txt
