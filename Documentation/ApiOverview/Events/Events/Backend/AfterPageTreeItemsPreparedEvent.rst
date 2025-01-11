..  include:: /Includes.rst.txt
..  index:: Events; AfterPageTreeItemsPreparedEvent
..  _AfterPageTreeItemsPreparedEvent:

===============================
AfterPageTreeItemsPreparedEvent
===============================

..  versionadded:: 12.0
    This PSR-14 event replaces the following hooks:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Workspaces\Service\WorkspaceService']['hasPageRecordVersions']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Workspaces\Service\WorkspaceService']['fetchPagesWithVersionsInTable']`

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterPageTreeItemsPreparedEvent`
allows prepared page tree items to be modified.

It is dispatched in the :php:`\TYPO3\CMS\Backend\Controller\Page\TreeController`
class after the page tree items have been resolved and prepared. The event
provides the current PSR-7 request object as well as the page tree items. All
items contain the corresponding page record in the special :php:`_page` key.

..  _AfterPageTreeItemsPreparedEvent-example:

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterPageTreeItemsPreparedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _AfterPageTreeItemsPreparedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _AfterPageTreeItemsPreparedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AfterPageTreeItemsPreparedEvent.rst.txt
