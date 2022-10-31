.. include:: /Includes.rst.txt
.. index:: Events; RenderAdditionalContentToRecordListEvent
.. _RenderAdditionalContentToRecordListEvent:


========================================
RenderAdditionalContentToRecordListEvent
========================================

..  versionadded:: 11.0
    This event supersedes the hooks

    -   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['recordlist/Modules/Recordlist/index.php']['drawHeaderHook']`
    -   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['recordlist/Modules/Recordlist/index.php']['drawFooterHook']`

    The hooks are removed in TYPO3 v12.

Event to add content before or after the main content of the list module.


API
===


.. include:: /CodeSnippets/Events/RecordList/RenderAdditionalContentToRecordListEvent.rst.txt
