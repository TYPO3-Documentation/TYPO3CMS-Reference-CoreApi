.. include:: /Includes.rst.txt
.. index:: Events; CustomFileSelectorsEvent
.. _CustomFileSelectorsEvent:

==========================
`CustomFileSelectorsEvent`
==========================

..  versionadded:: 14.2

The PSR-14 event :php:`\TYPO3\CMS\Backend\Form\Event\CustomFileSelectorsEvent`
is dispatched in :php:`\TYPO3\CMS\Backend\Form\Container\FilesControlContainer`
during rendering of the selectors of relations to `sys_file_reference`.

The event was introduced to add additional file controls and make it easier for
extension developers to integrate :abbr:`DAM (Digital Asset Management)` systems.

..  _custom-file-selectors-event-example:

Example
=======

..  literalinclude:: _CustomFileSelectorsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _custom-file-selectors-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/CustomFileSelectorsEvent.rst.txt
