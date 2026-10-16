..  include:: /Includes.rst.txt
..  index::
    Events; ModifyRenderedContentAreaEvent
..  _ModifyRenderedContentAreaEvent:

================================
`ModifyRenderedContentAreaEvent`
================================

..  versionadded:: 14.2
    :changelog: feature-108726-1769073579

The :php-short:`\TYPO3\CMS\Fluid\Event\ModifyRenderedContentAreaEvent` is
fired after the
:ref:`f:render.contentArea ViewHelper <t3viewhelper:typo3-fluid-render-contentarea>`
rendered a content area, which is the HTML of every record in one column of
the backend layout. A listener reads the HTML with
:php:`getRenderedContentArea()` and replaces it with
:php:`setRenderedContentArea()`.

:php:`getContentArea()` returns the
:php-short:`\TYPO3\CMS\Core\Page\ContentArea`, which answers the name and the
identifier of the area, its `colPos`, its slide mode, and the records it
collected. Whatever a listener writes goes into the page as it is, so escape
the parts that come from a record.

To change a single record instead of a whole area, use
`ModifyRenderedRecordEvent
<https://docs.typo3.org/permalink/t3coreapi:ModifyRenderedRecordEvent>`_.

..  _modify-rendered-content-area-event-example:

Example
=======

The following listener marks an area that rendered no record, which makes a
gap in a layout visible during development:

..  literalinclude:: _ModifyRenderedContentAreaEvent/_WrapRenderedContentAreaListener.php
    :caption: EXT:my_extension/Classes/EventListener/WrapRenderedContentAreaListener.php

..  _modify-rendered-content-area-event-api:

API
===

..  include:: /CodeSnippets/Events/Fluid/ModifyRenderedContentAreaEvent.rst.txt
