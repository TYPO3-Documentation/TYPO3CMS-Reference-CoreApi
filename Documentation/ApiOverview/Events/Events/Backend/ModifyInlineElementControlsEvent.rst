..  include:: /Includes.rst.txt
..  index:: Events; ModifyInlineElementControlsEvent
..  _ModifyInlineElementControlsEvent:

================================
ModifyInlineElementControlsEvent
================================

..  versionadded:: 12.0
    This event, together with :ref:`ModifyInlineElementEnabledControlsEvent`,
    serves as a more powerful and flexible replacement
    for the removed hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms_inline.php']['tceformsInlineHook']`

The PSR-14 event :php:`\TYPO3\CMS\Backend\Form\Event\ModifyInlineElementControlsEvent`
is called after the markup for all enabled controls has been generated. It
can be used to either change the markup of a control, to add a new control
or to completely remove a control.

.. _ModifyInlineElementControlsEvent_example:

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyInlineElementControlsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyInlineElementControlsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyInlineElementControlsEvent.rst.txt
