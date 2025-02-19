..  include:: /Includes.rst.txt
..  index:: Events; ModifyLoadedPageTsConfigEvent
..  _ModifyLoadedPageTsConfigEvent:

=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify :ref:`page TSconfig <t3tsref:pagetoplevelobjects>`
entries that can be overridden or added, based on the root line.

Example
=======

..  literalinclude:: _ModifyLoadedPageTsConfigEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/ModifyLoadedPageTsConfigEvent.rst.txt
