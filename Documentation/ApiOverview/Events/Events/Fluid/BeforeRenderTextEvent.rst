..  include:: /Includes.rst.txt
..  index::
    Events; BeforeRenderTextEvent
..  _BeforeRenderTextEvent:

=======================
`BeforeRenderTextEvent`
=======================

..  versionadded:: 14.3.10
    :changelog: feature-111159-render-text-event

The :php-short:`\TYPO3\CMS\Fluid\Event\BeforeRenderTextEvent` is dispatched
by the
`f:render.text ViewHelper <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-render-text>`_
before it escapes a text field or processes it as rich text. A listener can
take over the rendering, for example to add controls for inline editing,
without overriding the ViewHelper.

The ViewHelper dispatches the event after it has validated the record, the
value, and the type of the field. The event carries the record, the table,
the full record type, the field name and its schema, the value, and the
request, if there is one.

A listener provides the complete result with :php:`setRenderedText()`. The
ViewHelper returns this result unchanged and skips its default rendering.
Later listeners are not called. The ViewHelper does not escape the result, so
the listener escapes or sanitizes the HTML itself. If no listener provides a
result, the ViewHelper renders the field as before.

With the argument `optional`, a field that does not exist renders as `null`,
and the event is not dispatched.

..  _BeforeRenderTextEvent-example:

Example: Wrap text fields in an editable element in edit mode
=============================================================

The following listener wraps each single-line text field in an element for
inline editing, if the request has the attribute `my_extension.edit_mode`.
All other fields and requests render as before:

..  literalinclude:: _BeforeRenderTextEvent/_EditableTextListener.php
    :caption: EXT:my_extension/Classes/EventListener/EditableTextListener.php

..  _BeforeRenderTextEvent-api:

API of `BeforeRenderTextEvent`
==============================

..  typo3:api-class:: \TYPO3\CMS\Fluid\Event\BeforeRenderTextEvent
