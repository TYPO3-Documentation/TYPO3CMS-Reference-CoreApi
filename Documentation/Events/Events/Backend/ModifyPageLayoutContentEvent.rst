.. include:: /Includes.rst.txt
.. index:: Events; ModifyPageLayoutContentEvent
.. _ModifyPageLayoutContentEvent:

=============================
ModifyPageLayoutContentEvent
=============================

Event for modifying page module content.

This event features the methods :php:`getRequest()`, :php:`getModuleTemplate()`
and additional getters and setters for the header and footer
content.

It is possible to add additional content, overwrite existing
content or reorder the content.

.. versionadded:: 12.0

Example
=======

Registration of the Event in your extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\Backend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/backend/modify-page-module-content'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

   namespace Vendor\MyExtension\Backend\MyEventListener;

   use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;

   class MyEventListener {

       public function __invoke(ModifyPageLayoutContentEvent $event): void
       {
           $event->addHeaderContent('Additional header content');

           $event->setFooterContent('Overwrite footer content');
       }
   }

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyPageLayoutContentEvent.rst.txt

History / Migration
===================

The event :php:class:`TYPO3\\CMS\\Backend\\Controller\\Event\\ModifyPageLayoutContentEvent`
has been introduced to serve as a more powerful and flexible alternative
for the removed hooks
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook']`
and :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawFooterHook']`.

In contrast to the removed hooks, this event does not provide the
:php:`PageLayoutController` as :php:`$parentObject`, since :php:`getModuleTemplate()`
has been the only public method, which is now directly included in the event.

Additionally, there were three public properties :php:`$id`, :php:`$pageInfo`
and :php:`$MOD_SETTINGS`, which had been marked as :php:`@internal`
in TYPO3 v9. If needed, the information can be retrieved from the request directly.

An example to get the current :php:`$id`:

.. code-block:: php

    public function __invoke(ModifyPageLayoutContentEvent $event): void
    {
        $id = (int)($event->getRequest()->getQueryParams()['id'] ?? 0);
    }

