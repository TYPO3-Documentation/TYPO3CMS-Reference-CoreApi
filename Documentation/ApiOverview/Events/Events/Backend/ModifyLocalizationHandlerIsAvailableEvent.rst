..  include:: /Includes.rst.txt
..  index:: Events; ModifyLocalizationHandlerIsAvailableEvent
..  _ModifyLocalizationHandlerIsAvailableEvent:

=========================================
ModifyLocalizationHandlerIsAvailableEvent
=========================================

..  versionadded:: 14.2

The PSR-14 event :php:`\TYPO3\CMS\Backend\Localization\Event\ModifyLocalizationHandlerIsAvailableEvent`
is  fired in :php-short:`\TYPO3\CMS\Backend\Localization\LocalizationHandlerRegistry`
to allow overruling the available state of any registered localization handler based
on the :php-short:`\TYPO3\CMS\Backend\Localization\LocalizationInstructions\LocalizationInstructions`.

..  _ModifyLocalizationHandlerIsAvailableEvent-example:

Example
=======

..  literalinclude:: _ModifyLocalizationHandlerIsAvailableEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _ModifyLocalizationHandlerIsAvailableEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyLocalizationHandlerIsAvailableEvent.rst.txt
