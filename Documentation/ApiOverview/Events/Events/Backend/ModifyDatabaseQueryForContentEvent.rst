..  include:: /Includes.rst.txt
..  index:: Events; ModifyDatabaseQueryForContentEvent
..  _ModifyDatabaseQueryForContentEvent:

==================================
ModifyDatabaseQueryForContentEvent
==================================

..  versionadded:: 12.0
    This event has been introduced which serves as a drop-in replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][PageLayoutView::class]['modifyQuery']`
    hook.

Use the PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForContentEvent`
to filter out certain content elements from being shown in the
:guilabel:`Page` module.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyDatabaseQueryForContentEvent.rst.txt
