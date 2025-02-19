..  include:: /Includes.rst.txt
..  index:: Events; ModifyClearCacheActionsEvent
..  _ModifyClearCacheActionsEvent:


============================
ModifyClearCacheActionsEvent
============================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent`
is fired in the :php:`\TYPO3\CMS\Backend\Backend\ToolbarItems\ClearCacheToolbarItem`
class and allows extension authors to modify the clear cache actions, shown
in the TYPO3 backend top toolbar.

The event can be used to change or remove existing clear cache
actions, as well as to add new actions. Therefore, the event also
contains, next to the usual "getter" and "setter" methods, the convenience
method :php:`add()` for the :php:`cacheActions` and
:php:`cacheActionIdentifiers` arrays.

Example
=======

..  literalinclude:: _ModifyClearCacheActionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

The cache action array element consists of the following keys and values:

..  code-block:: php
    :caption: Example cache action array

    [
        'id' => 'pages',
        'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesTitle',
        'description' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesDescription',
        'href' => (string)$uriBuilder->buildUriFromRoute('tce_db', ['cacheCmd' => 'pages']),
        'iconIdentifier' => 'actions-system-cache-clear-impact-low'
    ]


API
===

..  include:: /CodeSnippets/Events/Backend/ModifyClearCacheActionsEvent.rst.txt
