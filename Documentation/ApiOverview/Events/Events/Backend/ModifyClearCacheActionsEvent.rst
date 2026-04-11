..  include:: /Includes.rst.txt
..  index:: Events; ModifyClearCacheActionsEvent
..  _ModifyClearCacheActionsEvent:

============================
ModifyClearCacheActionsEvent
============================

..  versionchanged:: 14.3
    The `CacheAction` array key `href` used in cache action definitions
    provided via the :php-short:`\TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent`
    has been deprecated in favor of `endpoint`. The new key name better reflects
    the purpose of this field, which is used as an AJAX endpoint URL. The value
    must be a :php:`string`. See :ref:`Migration <ModifyClearCacheActionsEvent-migration-v14>`.

The PSR-14 event :php:`\TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent`
is fired in the :php-short:`\TYPO3\CMS\Backend\Backend\ToolbarItems\ClearCacheToolbarItem`
class and allows extension authors to modify the clear cache actions, shown
in the TYPO3 backend top toolbar.

The event can be used to change or remove existing clear cache
actions, as well as to add new actions. Therefore, the event also
contains, next to the usual "getter" and "setter" methods, the convenience
method :php:`add()` for the :php:`cacheActions` and
:php:`cacheActionIdentifiers` arrays.

..  contents::

..  _ModifyClearCacheActionsEvent-example:

Example
=======

..  literalinclude:: _ModifyClearCacheActionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

The response returned by the AJAX endpoint should look like this:

.. code-block:: php

   use TYPO3\CMS\Core\Http\JsonResponse;

   // Success
   return new JsonResponse([
       'success' => true,
       'title'   => $languageService->sL('myext.messages:notification.success.title'),
       'message' => $languageService->sL('myext.messages:notification.success.message'),
   ]);

   // Failure
   return new JsonResponse([
       'success' => false,
       'title'   => $languageService->sL('myext.messages:notification.error.title'),
       'message' => $languageService->sL('myext.messages:notification.error.message'),
   ]);

..  _ModifyClearCacheActionsEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyClearCacheActionsEvent.rst.txt

..  _ModifyClearCacheActionsEvent-api-add-cache-action:

addCacheAction
--------------

The cache action array element consists of the following keys and values:

..  confval:: id
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-id
    :required: true
    :type: string

    Contains an existing cache id like `pages` or `all` or one registered via
    the :ref:`addCacheActionIdentifier <ModifyClearCacheActionsEvent-api-add-cache-identifier>`.

..  confval:: title
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-title
    :required: true
    :type: string or LLL reference

    The title displayed in the clear cache menu.

..  confval:: endpoint
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-endpoint
    :required: true
    :type: string

    The AJAX endpoint. AJAX endpoints registered as custom cache actions via
    :php:`ModifyClearCacheActionsEvent` should return a JSON response containing
    `success`, `title`, and `message` fields.

    The clear-cache toolbar treats a missing or non-:php:`false` :php:`success`
    value as a successful operation and falls back to generic notification labels
    when :php:`title` or :php:`message` are absent. Providing explicit values,
    however, gives users meaningful, context-specific feedback and ensures error
    conditions are surfaced correctly.

..  confval:: iconIdentifier
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-iconIdentifier
    :required: true
    :type: string

    An icon to be displayed in the clear cache menu

..  confval:: description
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-description
    :type: string or LLL reference

    The description displayed in the clear cache menu.

..  confval:: severity
    :name: ModifyClearCacheActionsEvent-api-add-cache-action-severity
    :type: string or LLL reference

    The key :php:`severity` can contain one of these strings: `notice`, `info`,
    `success`, `warning`, `error`.

..  code-block:: php
    :caption: Example cache action array

    $event->addCacheAction([
        // Required keys:
        'id' => 'pages',
        'title' => 'core.cache:group.pages.label',
        'endpoint' => (string)$uriBuilder->buildUriFromRoute('tce_db', ['cacheCmd' => 'pages']),
        'iconIdentifier' => 'actions-system-cache-clear-impact-low',
        // Optional, recommended keys:
        'description' => 'core.cache:group.pages.description',
        'severity' => 'success',
    ]);

..  _ModifyClearCacheActionsEvent-api-add-cache-identifier:

addCacheActionIdentifier
------------------------

The cache identifier array is a numerical array in which the array value
corresponds to the registered `id` of the cache action array.
Here is an example of how to use it for a custom cache action:

..  code-block:: php
    :caption: Example cache action array combined with a cache identifier array

    $myIdentifier = 'myExtensionCustomStorageCache';
    $event->addCacheAction([
        'id' => $myIdentifier,
        'title' => 'my_extension.cache:label',
        // Note to register your own route, this is an example
        'endpoint' => (string)$uriBuilder->buildUriFromRoute('ajax_' . $myIdentifier . '_purge'),
        'iconIdentifier' => 'actions-system-cache-clear-impact-low',
        'description' => 'my_extension.cache:description',
        'severity' => 'notice',
    ]);
    $event->addCacheActionIdentifier($myIdentifier);

..  _ModifyClearCacheActionsEvent-migration-v14:

Migration: replace key `href` with key `endpoint`
=================================================

When dropping TYPO3 v13 support replace the :php:`href` key with :php:`endpoint`
in any `CacheAction` array returned from a
:php-short:`\TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent`
listener:

.. code-block:: diff

    $event->addCacheAction([
        'id' => 'my_custom_cache',
    -   'href' => $uriBuilder->buildUriFromRoute('ajax_my_cache_clear'),
    +   'endpoint' => (string)$uriBuilder->buildUriFromRoute('ajax_my_cache_clear'),
        'iconIdentifier' => 'actions-system-cache-clear',
        'title' => 'Clear my cache',
        'description' => 'Optional description',
        'severity' => 'notice',
    ]);
