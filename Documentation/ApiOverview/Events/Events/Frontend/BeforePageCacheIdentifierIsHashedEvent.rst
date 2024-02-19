..  include:: /Includes.rst.txt
..  index:: Events; BeforePageCacheIdentifierIsHashedEvent
..  _BeforePageCacheIdentifierIsHashedEvent:

======================================
BeforePageCacheIdentifierIsHashedEvent
======================================

..  versionadded:: 13.0
    This event has been introduced to serve as a direct replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['createHashBase']`
    hook.

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\BeforePageCacheIdentifierIsHashedEvent`
is dispatched just before the final page cache identifier is created, that is
used to get - and later set, if needed and allowed - the page cache row.

The event receives all current arguments that will be part of the identifier
calculation and allows to add further arguments in case page caches need
to be more specific.

This event can be helpful in various scenarios, for example to implement
proper page caching in A/B testing.

..  note::
    This event is *always* dispatched, even in fully cached page scenarios,
    if an outer middleware did not return early (for instance due to permission
    issues).

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/BeforePageCacheIdentifierIsHashedEvent.rst.txt
