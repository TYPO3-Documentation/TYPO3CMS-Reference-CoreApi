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

    $event->addCacheAction([
        // Required keys:
        'id' => 'pages',
        'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesTitle',
        'href' => (string)$uriBuilder->buildUriFromRoute('tce_db', ['cacheCmd' => 'pages']),
        'iconIdentifier' => 'actions-system-cache-clear-impact-low',
        // Optional, recommended keys:
        'description' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesDescription',
        'severity' => 'success',
    ]);

The key :php:`severity` can contain one of these strings: `notice, info, success, warning, error`.

The cache identifier array is a numerical array in which the array value corresponds to the registered `id` of the cache action array.
Here is an example on how to utilize it for a custom cache action:

..  code-block:: php
    :caption: Example cache action array combined with a cache identifier array

    $myIdentifier = 'myExtensionCustomStorageCache';
    $event->addCacheAction([
        'id' => 'customStorageCache',
        'title' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:CacheActionTitle',
        // Note to register your own route, this is an example
        'href' => (string)$uriBuilder->buildUriFromRoute('ajax_' . $myIdentifier . '_purge'),
        'iconIdentifier' => 'actions-system-cache-clear-impact-low',
        'description' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:CacheActionDescription',
        'severity' => 'notice',
    ]);
    $event->addCacheActionIdentifier($myIdentifier);

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyClearCacheActionsEvent.rst.txt
