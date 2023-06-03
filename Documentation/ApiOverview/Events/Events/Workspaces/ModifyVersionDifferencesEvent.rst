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

The version differences :php:`array` contains the differences of each field,
with the following keys:

*   :php:`field`: The corresponding field name
*   :php:`label`: The corresponding field label
*   :php:`content`: The field values difference

In addition, the event provides the following methods:

*   :php:`getLiveRecordData()`: Returns the records live data (used to create
    the version difference)
*   :php:`getParameters()`: Returns meta information like current stage and
    current workspace


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyVersionDifferencesEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyVersionDifferencesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Workspaces/ModifyVersionDifferencesEvent.rst.txt
