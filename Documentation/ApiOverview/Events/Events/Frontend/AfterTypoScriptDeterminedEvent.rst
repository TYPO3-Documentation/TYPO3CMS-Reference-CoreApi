..  include:: /Includes.rst.txt
..  index:: Events; AfterTypoScriptDeterminedEvent
..  _AfterTypoScriptDeterminedEvent:

==============================
AfterTypoScriptDeterminedEvent
==============================

..  versionadded:: 13.0
    This event can be used to serve as a replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageLoadedFromCache']`
    hook. Another solution to substitute the removed hook is an own
    :ref:`middleware <request-handling>` after
    :php:`typo3/cms-frontend/prepare-tsfe-rendering`.

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterTypoScriptDeterminedEvent`
is dispatched after the :php:`\TYPO3\CMS\Core\TypoScript\FrontendTypoScript`
object has been calculated, just before it is attached to the
:ref:`request <typo3-request-attribute-frontend-typoscript>`.

The event is designed to enable listeners to act on specific TypoScript
conditions. Listeners *must not* modify TypoScript at this point, the Core will
try to actively prevent this.

This event is especially useful when "upper" middlewares that do not have the
determined TypoScript need to behave differently depending on TypoScript
:typoscript:`config` that is only created after them.
The Core uses this in the :php:`TimeTrackInitialization` and the
:php:`WorkspacePreview` middlewares, to determine debugging and preview details.

..  note::
    Both "settings" ("constants") and :typoscript:`config` are *always* set
    within the :php:`FrontendTypoScript` at this point, even in "fully cached
    page" scenarios. :typoscript:`setup` and (internal) :typoscript:`page` may
    not be set.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterTypoScriptDeterminedEvent.rst.txt
