.. include:: /Includes.rst.txt
.. index:: Events; ModifyInlineElementEnabledControlsEvent
.. _ModifyInlineElementEnabledControlsEvent:

=======================================
ModifyInlineElementEnabledControlsEvent
=======================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Form\Event\ModifyInlineElementEnabledControlsEvent`
is called before any control markup is generated. It can be used to
enable or disable each control. With this event it is therefore possible
to enable a control, which is disabled in TCA, only for some use case.

See the
:ref:`ModifyInlineElementControlsEvent example <ModifyInlineElementControlsEvent_example>`
for details.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyInlineElementEnabledControlsEvent.rst.txt
