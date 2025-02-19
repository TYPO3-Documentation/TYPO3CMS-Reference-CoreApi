..  include:: /Includes.rst.txt
..  index:: Events; ModifyCacheLifetimeForPageEvent
..  _ModifyCacheLifetimeForPageEvent:

===============================
ModifyCacheLifetimeForPageEvent
===============================

This event allows to modify the lifetime of how long a rendered page of a
frontend call should be stored in the "pages" cache.

Example
=======

The following listener limits the cache lifetime to 30 seconds in development
context:

..  literalinclude:: _ModifyCacheLifetimeForPageEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyCacheLifetimeForPageEvent.rst.txt
