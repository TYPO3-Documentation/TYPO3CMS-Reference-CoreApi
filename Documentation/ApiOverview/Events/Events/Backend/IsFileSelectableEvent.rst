..  include:: /Includes.rst.txt
..  index:: Events; IsFileSelectableEvent
..  _IsFileSelectableEvent:

=====================
IsFileSelectableEvent
=====================

..  versionadded:: 12.1

The PSR-14 event :php:`\TYPO3\CMS\Backend\ElementBrowser\Event\IsFileSelectableEvent`
allows to decide whether a file can be selected in the file browser.

To get the image dimensions (width and height) of a file, you can retrieve the
file and use the :php:`getProperty()` method.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/modify-file-is-selectable'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\ElementBrowser\Event\IsFileSelectableEvent;

    final class MyEventListener {
        public function __invoke(IsFileSelectableEvent $event): void
        {
            // Deny selection of "png" images
            if ($event->getFile()->getExtension() === 'png') {
                $event->denyFileSelection();
            }
        }
    }

API
===

.. include:: /CodeSnippets/Events/Backend/IsFileSelectableEvent.rst.txt
