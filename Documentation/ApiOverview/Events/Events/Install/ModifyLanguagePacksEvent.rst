..  include:: /Includes.rst.txt
..  index:: Events; ModifyLanguagePacksEvent
..  _ModifyLanguagePacksEvent:


========================
ModifyLanguagePacksEvent
========================

The PSR-14 event :php:`\TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent`
allows to ignore extensions or individual language packs for extensions when
downloading language packs.

The options of the :bash:`language:update` command can be used to further
restrict the download (ignore additional extensions or download only certain
languages), but not to ignore decisions made by the event.

Example
=======

..  literalinclude:: _ModifyLanguagePacksEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Install/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Install/ModifyLanguagePacksEvent.rst.txt
