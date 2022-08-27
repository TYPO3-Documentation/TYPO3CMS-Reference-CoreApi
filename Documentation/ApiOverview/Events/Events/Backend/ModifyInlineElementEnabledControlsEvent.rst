.. include:: /Includes.rst.txt
.. index:: Events; ModifyInlineElementEnabledControlsEvent
.. _ModifyInlineElementEnabledControlsEvent:

=======================================
ModifyInlineElementEnabledControlsEvent
=======================================

.. versionadded:: 12.0
   This event, together with :ref:`ModifyInlineElementControlsEvent`
   serves as a more powerful and flexible replacement
   for the removed hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms_inline.php']['tceformsInlineHook']`

This event
is called before any control markup is generated. It can be used to
enable or disable each control. With this event it is therefore possible
to enable a control, which is disabled in TCA, only for some use case.

For an example see
:ref:`ModifyInlineElementControlsEvent Example <ModifyInlineElementControlsEvent_example>`.

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyInlineElementEnabledControlsEvent.rst.txt
