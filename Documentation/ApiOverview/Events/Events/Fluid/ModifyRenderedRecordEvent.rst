..  include:: /Includes.rst.txt
..  index::
    Events; ModifyRenderedRecordEvent
..  _ModifyRenderedRecordEvent:

===========================
`ModifyRenderedRecordEvent`
===========================

..  versionadded:: 14.2
    :changelog: feature-108726-1769503907

The :php-short:`\TYPO3\CMS\Fluid\Event\ModifyRenderedRecordEvent` is fired
after the
:ref:`f:render.record ViewHelper <t3viewhelper:typo3-fluid-render-record>`
rendered one record, and before the result reaches the template. A listener
reads the HTML with :php:`getRenderedRecord()` and replaces it with
:php:`setRenderedRecord()`, for example to wrap a content element in markup of
its own.

The event also carries the record and the request. Whatever a listener
writes goes into the page as it is, so escape the parts that come from the
record.

To change a whole column of the backend layout instead of a single record, use
`ModifyRenderedContentAreaEvent
<https://docs.typo3.org/permalink/t3coreapi:ModifyRenderedContentAreaEvent>`_.

..  _modify-rendered-record-event-example:

Example
=======

The following listener wraps every record in an element that names its type
and uid:

..  literalinclude:: _ModifyRenderedRecordEvent/_WrapRenderedRecordListener.php
    :caption: EXT:my_extension/Classes/EventListener/WrapRenderedRecordListener.php

..  _modify-rendered-record-event-api:

API
===

..  include:: /CodeSnippets/Events/Fluid/ModifyRenderedRecordEvent.rst.txt
