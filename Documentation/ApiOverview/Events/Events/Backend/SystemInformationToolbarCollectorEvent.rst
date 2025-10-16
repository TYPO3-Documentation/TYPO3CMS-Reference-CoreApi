..  include:: /Includes.rst.txt
..  index:: Events; SystemInformationToolbarCollectorEvent
..  _SystemInformationToolbarCollectorEvent:

======================================
SystemInformationToolbarCollectorEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent`
allows to enrich the system information toolbar in the TYPO3 backend top toolbar
with various information.

..  _SystemInformationToolbarCollectorEvent-example:

Example: Display release information in "System Information" toolbar window
===========================================================================

The event :php-short:`\TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent`
gets you the object :php-short:`TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem`
on which you can call method `addSystemInformation()` to add system
information items or method `addSystemMessage()` to add messages.

..  literalinclude:: _SystemInformationToolbarCollectorEvent/_AddReleaseInfoToSystemInformationEventListener.php
    :caption: EXT:my_extension/Classes/EventListener/AddReleaseInfoToSystemInformationEventListener.php

The messages will then be displayed like this:

..  figure:: /Images/ManualScreenshots/Backend/ToolBarCustomSystemInformation.png
    :alt: TYPO3 Backend Screenshot with custom System Information Icons and a custom message

    The release information is now displayed in the "System Information" toolbar item

..  _SystemInformationToolbarCollectorEvent-example-api:

API
===

..  include:: /CodeSnippets/Events/Backend/SystemInformationToolbarCollectorEvent.rst.txt
