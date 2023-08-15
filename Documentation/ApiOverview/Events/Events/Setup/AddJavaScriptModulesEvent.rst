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

..  todo: \TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent->addModule and
    \TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent->getModules was removed
    with TYPO3 v13.0, please update the example.


..  literalinclude:: _AddJavaScriptModulesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/UserSettings/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Setup/AddJavaScriptModulesEvent.rst.txt
