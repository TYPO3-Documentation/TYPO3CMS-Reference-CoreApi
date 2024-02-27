..  include:: /Includes.rst.txt
..  index:: Events; ModifyVersionDifferencesEvent
..  _ModifyVersionDifferencesEvent:


=============================
ModifyVersionDifferencesEvent
=============================

..  versionadded:: 12.0
    This PSR-14 event replaces the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`
    hook.

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\ModifyVersionDifferencesEvent`
can be used to modify the version differences data, used for the display in the
:guilabel:`Web > Workspaces` backend module. Those data can be accessed
with the :php:`getVersionDifferences()` method and updated using the
:php:`setVersionDifferences(array $versionDifferences)` method.


Example
=======

..  literalinclude:: _ModifyVersionDifferencesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Workspaces/ModifyVersionDifferencesEvent.rst.txt
