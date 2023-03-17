.. include:: /Includes.rst.txt
.. index:: Events; ModifyPageLinkConfigurationEvent
.. _ModifyPageLinkConfigurationEvent:

=================================
ModifyPageLinkConfigurationEvent
=================================

.. versionadded:: 12.0

The event is called after a page has been resolved, and includes
arguments such as the generated fragment and the to-be-used query parameters.

The page to be linked to can also be modified to link to a different page.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   Vendor\MyExtension\Frontend\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/frontend/modify-page-link-configuration'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

   namespace Vendor\MyExtension\HrefLang\EventListener;

   use TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent;

   final class MyEventListener {

       public function __invoke(ModifyPageLinkConfigurationEvent $event): void
       {
           // Do your magic here
       }
   }


API
===

.. include:: /CodeSnippets/Events/Frontend/ModifyPageLinkConfigurationEvent.rst.txt

History
=======

The event :php:class:`TYPO3\\CMS\\Frontend\\Event\\ModifyPageLinkConfigurationEvent`
has been introduced to serve as a more powerful and flexible alternative
for the removed hook
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typolinkProcessing']['typolinkModifyParameterForPageLinks']`.
