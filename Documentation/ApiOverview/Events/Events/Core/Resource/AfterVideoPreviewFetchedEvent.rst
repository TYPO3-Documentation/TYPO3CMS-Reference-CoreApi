..  include:: /Includes.rst.txt
..  index:: Events; AfterVideoPreviewFetchedEvent
..  _AfterVideoPreviewFetchedEvent:


=============================
AfterVideoPreviewFetchedEvent
=============================

..  versionadded:: 12.2

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\OnlineMedia\Event\AfterVideoPreviewFetchedEvent`
is to modify the preview file of online media previews (like YouTube and Vimeo).
If, for example, a processed file is bad (blank or outdated), this event can be
used to modify and/or update the preview file.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\EventListener\ExampleEventListener:
      tags:
        - name: event.listener
          identifier: 'exampleEventListener'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/ExampleEventListener.php

    use TYPO3\CMS\Core\Resource\OnlineMedia\Event\AfterVideoPreviewFetchedEvent;

    final class ExampleEventListener
    {
        public function __invoke(AfterVideoPreviewFetchedEvent $event): void
        {
            $event->setPreviewImageFilename(
                '/var/www/html/typo3temp/assets/online_media/new-preview-image.jpg'
            );
        }
    }

API
===

.. include:: /CodeSnippets/Events/Core/Resource/AfterVideoPreviewFetchedEvent.rst.txt
