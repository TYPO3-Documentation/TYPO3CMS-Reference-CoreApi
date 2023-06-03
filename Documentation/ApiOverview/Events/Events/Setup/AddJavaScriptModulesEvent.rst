..  include:: /Includes.rst.txt
..  index:: Events; AddJavaScriptModulesEvent
..  _AddJavaScriptModulesEvent:


=========================
AddJavaScriptModulesEvent
=========================

JavaScript events in custom user settings configuration options should not be
placed as inline JavaScript. Instead, use a dedicated JavaScript module to
handle custom events.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AddJavaScriptModulesEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AddJavaScriptModulesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/UserSettings/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Setup/AddJavaScriptModulesEvent.rst.txt
