..  include:: /Includes.rst.txt
..  index:: Events; IsContentUsedOnPageLayoutEvent
..  _IsContentUsedOnPageLayoutEvent:

==============================
IsContentUsedOnPageLayoutEvent
==============================

..  versionadded:: 12.0
    The PSR-14 event :php:`TYPO3\CMS\Backend\View\Event\IsContentUsedOnPageLayoutEvent`
    has been introduced which serves as a drop-in replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['record_is_used']`
    hook.

Use this event to identify if content has been used in a column that is not in
a backend layout.

API
===

.. include:: /CodeSnippets/Events/Backend/IsContentUsedOnPageLayoutEvent.rst.txt
