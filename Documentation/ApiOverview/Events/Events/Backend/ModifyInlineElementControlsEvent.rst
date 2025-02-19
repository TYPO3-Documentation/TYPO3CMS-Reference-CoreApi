..  include:: /Includes.rst.txt
..  index:: Events; ModifyInlineElementControlsEvent
..  _ModifyInlineElementControlsEvent:

================================
ModifyInlineElementControlsEvent
================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Form\Event\ModifyInlineElementControlsEvent`
is called after the markup for all enabled controls has been generated. It
can be used to either change the markup of a control, to add a new control
or to completely remove a control.

.. _ModifyInlineElementControlsEvent_example:

Example
=======

..  literalinclude:: _ModifyInlineElementControlsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyInlineElementControlsEvent.rst.txt
