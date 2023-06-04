..  include:: /Includes.rst.txt
..  index:: Events; ModifyClearCacheActionsEvent
..  _ModifyClearCacheActionsEvent:


============================
ModifyClearCacheActionsEvent
============================

..  versionadded:: 11.4

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

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyClearCacheActionsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _ModifyClearCacheActionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

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
