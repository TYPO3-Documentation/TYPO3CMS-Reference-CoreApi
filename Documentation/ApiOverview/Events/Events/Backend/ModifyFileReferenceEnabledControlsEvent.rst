..  include:: /Includes.rst.txt
..  index:: Events; ModifyFileReferenceEnabledControlsEvent
..  _ModifyFileReferenceEnabledControlsEvent:

=======================================
ModifyFileReferenceEnabledControlsEvent
=======================================

..  versionadded:: 12.0

Listeners to this event are able to modify the state (enabled or disabled)
for the controls of a single file reference of a TCA type :php:`file` field. This
event is similar to the :ref:`ModifyInlineElementEnabledControlsEvent`, which
is only available for TCA type `inline`.

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyFileReferenceEnabledControlsEvent.rst.txt
