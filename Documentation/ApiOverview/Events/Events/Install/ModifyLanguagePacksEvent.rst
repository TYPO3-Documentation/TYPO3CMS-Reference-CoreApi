.. include:: /Includes.rst.txt
.. index:: Events; ModifyLanguagePacksEvent
.. _ModifyLanguagePacksEvent:


========================
ModifyLanguagePacksEvent
========================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent`
allows to ignore extensions or individual language packs for extensions when
downloading language packs.

The options of the :bash:`language:update` command can be used to further
restrict the download (ignore additional extensions or download only certain
languages), but not to ignore decisions made by the event.

Example
=======

Registration of the event:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      MyVendor\MyExtension\EventListener\ModifyLanguagePacks:
        tags:
          - name: event.listener
            identifier: 'modifyLanguagePacks'

Implementation of the event listener:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/ModifyLanguagePacks.php

    namespace MyVendor\MyExtension\EventListener;

    use TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent;

    final class ModifyLanguagePacks
    {
        public function __invoke(ModifyLanguagePacksEvent $event): void
        {
            $extensions = $event->getExtensions();
            foreach ($extensions as $key => $extension){
                // Do not download language packs from Core extensions
                if ($extension['type'] === 'typo3-cms-framework'){
                    $event->removeExtension($key);
                }
            }

            // Remove German language pack from EXT:styleguide
            $event->removeIsoFromExtension('de', 'styleguide');
        }
    }


API
===

.. include:: /CodeSnippets/Events/Install/ModifyLanguagePacksEvent.rst.txt
