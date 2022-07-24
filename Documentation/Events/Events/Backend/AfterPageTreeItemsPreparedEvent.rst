.. include:: /Includes.rst.txt
.. index:: Events; AfterPageTreeItemsPreparedEvent
.. _AfterPageTreeItemsPreparedEvent:


===============================
AfterPageTreeItemsPreparedEvent
===============================

.. versionadded:: 12.0
   This PSR-14 event replaces the following hooks:

   *  :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Workspaces\Service\WorkspaceService']['hasPageRecordVersions']`
   *  :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Workspaces\Service\WorkspaceService']['fetchPagesWithVersionsInTable']`

This event allows prepared page tree items to be modified.

It is dispatched in the :php:`TYPO3\CMS\Backend\Controller\Page\TreeController`
class after the page tree items have been resolved and prepared. The event
provides the current PSR-7 request as well as the page tree items. All items
contain the corresponding page record in the special :php:`_page` key.

Example
=======

Registration of the event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\Workspaces\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/workspaces/modify-page-tree-items'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Workspaces/MyEventListener.php

   use TYPO3\CMS\Backend\Controller\Event\AfterPageTreeItemsPreparedEvent;

   final class MyEventListener
   {
       public function __invoke(AfterPageTreeItemsPreparedEvent $event): void
       {
           $items = $event->getItems();
           foreach ($items as $item) {
               // Setting special item for page with id 123
               if ($item['_page']['uid'] === 123) {
                   $item['icon'] = 'my-special-icon';
               }
           }
           $event->setItems($items);
       }
   }

API
===

.. include:: /CodeSnippets/Events/Backend/AfterPageTreeItemsPreparedEvent.rst.txt
