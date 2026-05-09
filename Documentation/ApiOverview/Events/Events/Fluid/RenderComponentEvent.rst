..  include:: /Includes.rst.txt
..  index::
    Events; RenderComponentEvent
..  _RenderComponentEvent:

====================
RenderComponentEvent
====================

..  versionadded:: 14.1

The :php-short:`\TYPO3\CMS\Fluid\Event\RenderComponentEvent` can be used to alter or
replace the rendering of `Fluid components <https://docs.typo3.org/permalink/t3coreapi:using-fluid-components>`_.
There are three possible use cases:

1.  Fully take over the rendering of components by filling the :php:`$renderedContent` with
    :php:`$event->setRenderedContent()`. The first event listener that does this skips all following
    event listeners.
2.  Provide additional arguments (variables in the component template) or slots to
    the component with :php:`$event->setArguments()`/:php:`$event->setSlots()`.
3.  Execute additional code that doesn't influence the component rendering directly, for example
    adding certain frontend assets to the page automatically.

Example
=======

..  literalinclude:: _RenderComponentEvent/_RenderComponentListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/RenderComponentListener.php

API
===

..  include:: /CodeSnippets/Events/Fluid/RenderComponentEvent.rst.txt
