..  include:: /Includes.rst.txt
..  index:: Events; AfterRichtextConfigurationPreparedEvent

..  _AfterRichtextConfigurationPreparedEvent:

=======================================
AfterRichtextConfigurationPreparedEvent
=======================================

..  versionadded:: 14.0

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\AfterRichtextConfigurationPreparedEvent`
allows to modify the richtext configuration after it has been fetched and prepared.

..  _AfterRichtextConfigurationPreparedEvent-example:

Example: Enable debugging in the rich text editor
=================================================

The following event listener enables debugging in the rich text editor:

..  literalinclude:: _AfterRichtextConfigurationPreparedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/EnableDebugRichTextEditorEventListener.php

..  _AfterRichtextConfigurationPreparedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/AfterRichtextConfigurationPreparedEvent.rst.txt
