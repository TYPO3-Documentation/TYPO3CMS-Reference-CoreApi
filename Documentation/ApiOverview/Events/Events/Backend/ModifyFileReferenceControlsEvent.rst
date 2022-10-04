..  include:: /Includes.rst.txt
..  index:: Events; ModifyFileReferenceControlsEvent
..  _ModifyFileReferenceControlsEvent:

================================
ModifyFileReferenceControlsEvent
================================

..  versionadded:: 12.0

Listeners to this event are able to modify the controls of a single
file reference of a TCA type :php:`file` field. This event is similar to the
:ref:`ModifyInlineElementControlsEvent`, which is only available for TCA
type :php:`inline`.

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyFileReferenceControlsEvent.rst.txt
