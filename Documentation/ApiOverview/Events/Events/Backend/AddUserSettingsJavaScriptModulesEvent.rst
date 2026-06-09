..  include:: /Includes.rst.txt
..  index:: Events; AddUserSettingsJavaScriptModulesEvent
..  _AddUserSettingsJavaScriptModulesEvent:

=====================================
AddUserSettingsJavaScriptModulesEvent
=====================================

JavaScript events in custom user settings configuration options should not be
placed as inline JavaScript. Instead, use a dedicated JavaScript module to
handle custom events.

..  _AddUserSettingsJavaScriptModulesEvent-example:

Example
=======

..  literalinclude:: _AddUserSettingsJavaScriptModulesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/UserSettings/EventListener/MyEventListener.php


..  _AddUserSettingsJavaScriptModulesEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AddUserSettingsJavaScriptModulesEvent.rst.txt
