..  include:: /Includes.rst.txt
..  index::
    Events; ModifyImageManipulationPreviewUrlEvent
..  _ModifyImageManipulationPreviewUrlEvent:

======================================
ModifyImageManipulationPreviewUrlEvent
======================================

..  versionadded:: 12.0
    This event serves as a direct replacement for the now removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend/Form/Element/ImageManipulationElement']['previewUrl']`
    hook.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent`
can be used to modify the preview URL within the
:ref:`image manipulation <t3tca:columns-imageManipulation>` element, used
for example for the :php:`crop` field of the :sql:`sys_file_reference` table.

As soon as a preview URL is set, the image manipulation element will display
a corresponding button in the footer of the modal window, next to the
:guilabel:`Cancel` and :guilabel:`Accept` buttons. On click, the preview
URL will be opened in a new window.

..  note::
    The element's crop variants will always be appended to the preview URL
    as JSON-encoded string, using the `cropVariants` parameter.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/modify-imagemanipulation-previewurl'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent

    final class MyEventListener
    {
        public function __invoke(ModifyImageManipulationPreviewUrlEvent $event): void
        {
            $event->setPreviewUrl('https://example.com/some/preview/url');
        }
    }

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyImageManipulationPreviewUrlEvent.rst.txt
