..  include:: /Includes.rst.txt
..  index:: Events; ModifyLanguagePacksEvent
..  _ModifyLanguagePacksEvent:

========================
ModifyLanguagePacksEvent
========================

..  deprecated:: 14.2
    The event :php:`ModifyLanguagePacksEvent`
    have been moved to :composer:`typo3/cms-core`. Therefore the namespace
    changed from `\TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent`
    to :php:`\TYPO3\CMS\Core\Localization\Event\ModifyLanguagePacksEvent`.

    There is a class alias that will be removed with TYPO3 v15.0.

    See `Deprecation: #109027 - Move language:update command and events to EXT:core <https://docs.typo3.org/permalink/changelog:deprecation-109027-1771514240>`_.


The PSR-14 event :php:`\TYPO3\CMS\Core\Localization\Event\ModifyLanguagePacksEvent`
allows to ignore extensions or individual language packs for extensions when
downloading language packs.

The options of the :bash:`language:update` command can be used to further
restrict the download (ignore additional extensions or download only certain
languages), but not to ignore decisions made by the event.

..  _ModifyLanguagePacksEvent-example:

Example
=======

..  literalinclude:: _ModifyLanguagePacksEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Install/EventListener/MyEventListener.php

..  _ModifyLanguagePacksEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/ModifyLanguagePacksEvent.rst.txt
