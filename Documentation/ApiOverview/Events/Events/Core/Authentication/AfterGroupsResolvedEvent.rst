..  include:: /Includes.rst.txt
..  index:: Events; AfterGroupsResolvedEvent
..  _AfterGroupsResolvedEvent:

========================
AfterGroupsResolvedEvent
========================

When user groups are loaded, for example when a backend editor's groups and permissions
are calculated, a new PSR-14 event `AfterGroupsResolvedEvent` is fired.

This event contains a list of retrieved groups from the database which can
be modified via event listeners. For example, more groups might be added when a
particular user logs in or is seated at a special location.


..  hint::
    This event acts as a substitution for the removed TYPO3 hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['fetchGroups_postProcessing']`.


API
===

..  include:: /CodeSnippets/Events/Core/AfterGroupsResolvedEvent.rst.txt
