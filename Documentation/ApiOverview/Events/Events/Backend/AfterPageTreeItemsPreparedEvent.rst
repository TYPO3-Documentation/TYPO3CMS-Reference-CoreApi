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

..  versionadded:: 13.1

You can also define tree node labels. These labels not only offer customizable
color markings for tree nodes, but also require an associated label for improved
accessibility. Each node can support multiple labels, sorted by priority, with
the highest priority label taking precedence over others. A label can also be
assigned to a node via :ref:`user TSconfig <t3tsconfig:useroptions-pageTree-label>`.
Please note that only the marker for the label with the highest priority is
rendered. All additional labels will only be added to the title of the node.


Example
=======

..  literalinclude:: _AfterPageTreeItemsPreparedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/AfterPageTreeItemsPreparedEvent.rst.txt
