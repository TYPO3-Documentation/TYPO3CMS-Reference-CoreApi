..  include:: /Includes.rst.txt
..  index:: Events; ModifyLoadedPageTsConfigEvent
..  _ModifyLoadedPageTsConfigEvent:

=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify :ref:`page TSconfig <t3tsconfig:pagetoplevelobjects>`
entries that can be overridden or added, based on the root line.

..  versionchanged:: 12.2
    The event has moved its namespace from
    :php:`\TYPO3\CMS\Core\Configuration\Event\ModifyLoadedPageTsConfigEvent` to
    :php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent`.
    Apart from that no changes were made. TYPO3 v12 triggers *both* the old
    and the new event, and TYPO3 v13 will stop calling the old event.

    Extension that want to stay compatible with both TYPO3 v11 and v12 should
    continue to listen for the old event only. This will *not* raise a
    deprecation level log entry in v12, but it will stop working with TYPO3 v13.
    Extensions with compatibility for TYPO3 v12 and above should switch to the
    new event.


API
===

..  include:: /CodeSnippets/Events/Core/ModifyLoadedPageTsConfigEvent.rst.txt
