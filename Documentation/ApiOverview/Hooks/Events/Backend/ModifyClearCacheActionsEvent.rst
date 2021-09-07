.. include:: /Includes.rst.txt
.. index:: Events; ModifyClearCacheActionsEvent
.. _ModifyClearCacheActionsEvent:


====================================
ModifyClearCacheActionsEvent
====================================

.. versionadded:: 11.4

The :php:`ModifyClearCacheActionsEvent` is fired in the :php:`ClearCacheToolbarItem`
class and allows extensions to modify the clear cache actions, shown
in the TYPO3 backend top toolbar.

The event can be used to change or remove existing clear cache
actions, as well as to add new actions. Therefore the event also
contains, next to the usual "getter" and "setter" methods, the convenience
method :php:`add` for the :php:`cacheActions` and
:php:`cacheActionIdentifiers` arrays.

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\Toolbar\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/toolbar/my-event-listener'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;

    class MyEventListener {

        public function __invoke(ModifyClearCacheActionsEvent $event): void
        {
            // do magic here
        }

    }

The cache action array element consists of the following keys and values::

   [
       'id' => 'pages',
       'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesTitle',
       'description' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:flushPageCachesDescription',
       'href' => (string)$uriBuilder->buildUriFromRoute('tce_db', ['cacheCmd' => 'pages']),
       'iconIdentifier' => 'actions-system-cache-clear-impact-low'
   ]


API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

addCacheAction(array $cacheAction)
   :sep:`|` :aspect:`Arguments:` `$cacheAction` array
   :sep:`|` :aspect:`ReturnType:` :php:`void`
   :sep:`|`

   |nbsp|

setCacheActions(array $cacheActions)
   :sep:`|` :aspect:`Arguments:` `$cacheActions` string
   :sep:`|` :aspect:`ReturnType:` `void`
   :sep:`|`

   |nbsp|

getCacheActions()
   :sep:`|` :aspect:`ReturnType:` `array`
   :sep:`|`

   |nbsp|

addCacheActionIdentifier(string $cacheActionIdentifier)
   :sep:`|` :aspect:`Arguments:` `$cacheActionIdentifier` string
   :sep:`|` :aspect:`ReturnType:` `void`
   :sep:`|`

   |nbsp|

setCacheActionIdentifiers(array $cacheActionIdentifiers)
   :sep:`|` :aspect:`Arguments:` `$cacheActionIdentifiers` string[]
   :sep:`|` :aspect:`ReturnType:` `void`
   :sep:`|`

   |nbsp|

getCacheActionIdentifiers()
   :sep:`|` :aspect:`ReturnType:` `string[]`
   :sep:`|`

   |nbsp|
