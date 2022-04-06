.. include:: /Includes.rst.txt
.. index::
   Events; ModifyInfoModuleContentEvent
.. _ModifyInfoModuleContentEvent:

============================
ModifyInfoModuleContentEvent
============================

.. versionadded:: 12.0
   This event has been introduced as a more powerful and flexible alternative
   to :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/web_info/class.tx_cms_webinfo.php']['drawFooterHook']`
   which has now been removed.

This event allows the content above and below the
info module to be modified. The content added in the event is
displayed in each submodule of :guilabel:`Web > Info`.

The event also provides the :php:`getCurrentModule()` method, which
returns the current requested submodule. It is therefore possible to
limit the added content to a subset of the available submodules.

Next to :php:`getRequest()` and the :php:`getModuleTemplate()`
methods this event also features getters and setters for the header
and footer content.

Access control
==============

The added content is by default always displayed. This event
provides the :php:`hasAccess()` method, returning whether the access checks
in the module were passed by the user.

This way, event listeners can decide on their own, whether their content
should always be shown, or only if a user also has access to the main module
content.

Example
=======

Registration of the Event in your extension's :file:`Configuration/Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyPackage\Backend\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/backend/content-to-info-module'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/EventListener/MyEventListener.php

   use TYPO3\CMS\Info\Controller\Event\ModifyInfoModuleContentEvent;

   class MyEventListener {

     public function __invoke(ModifyInfoModuleContentEvent $event): void
     {
         // Add header content for the "Page TSconfig" submodule if user has access to module content
         if ($event->hasAccess() && $event->getCurrentModule()->getIdentifier() === 'web_info_pagets') {
             $event->addHeaderContent('<h3>Additional header content</h3>');
         }
     }
   }

API
===

.. include:: /CodeSnippets/Events/Info/ModifyInfoModuleContentEvent.rst.txt
