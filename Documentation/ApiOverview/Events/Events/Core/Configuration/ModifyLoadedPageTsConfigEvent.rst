..  include:: /Includes.rst.txt
..  index:: Events; ModifyLoadedPageTsConfigEvent
..  _ModifyLoadedPageTsConfigEvent:

=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify :ref:`page TSconfig <t3tsref:pagetoplevelobjects>`
entries that can be overridden or added, based on the root line.

..  versionchanged:: 12.2
    The event has moved its namespace from
    :php:`\TYPO3\CMS\Core\Configuration\Event\ModifyLoadedPageTsConfigEvent` to
    :php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent`.
    Apart from that no changes were made. TYPO3 v12 triggers *both* the old
    and the new event, and TYPO3 v13 stopped calling the old event.

Example
=======

..  literalinclude:: _ModifyLoadedPageTsConfigEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/ModifyLoadedPageTsConfigEvent.rst.txt
