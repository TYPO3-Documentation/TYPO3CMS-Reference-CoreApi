..  include:: /Includes.rst.txt
..  index:: Events; RenderAdditionalContentToRecordListEvent
..  _RenderAdditionalContentToRecordListEvent:


========================================
RenderAdditionalContentToRecordListEvent
========================================

..  versionadded:: 11.0

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    the event changed from
    :php:`TYPO3\CMS\Recordlist\Event\RenderAdditionalContentToRecordListEvent`
    to
    :php:`TYPO3\CMS\Backend\Controller\Event\RenderAdditionalContentToRecordListEvent`.
    For TYPO3 v12 the moved class is available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

Event to add content before or after the main content of the list module.


API
---

..  include:: /CodeSnippets/Events/Backend/RenderAdditionalContentToRecordListEvent.rst.txt
