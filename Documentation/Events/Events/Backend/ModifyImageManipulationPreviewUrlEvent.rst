.. include:: /Includes.rst.txt
.. index::
   Events; ModifyImageManipulationPreviewUrlEvent
.. _ModifyImageManipulationPreviewUrlEvent:

============================================
ModifyImageManipulationPreviewUrlEvent
============================================

.. versionadded:: 12.0
   This event serves as a direct replacement for the now removed
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend/Form/Element/ImageManipulationElement']['previewUrl']`
   hook.

This event can be used to modify the preview url within the image manipulation
element, used for example for the :php:`crop` field of the
:sql:`sys_file_reference` table.

As soon as a preview url is set, the image manipulation element will display
a corresponding button in the footer of the modal window, next to the
:guilabel:`Cancel` and :guilabel:`Accept` buttons. On click, the preview
url will be opened in a new window.

.. note::

    The elements crop variants will always be appended to the preview url
    as json encoded string, using the `cropVariants` parameter.

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyImageManipulationPreviewUrlEvent.rst.txt


Example
=======

Registration of the Event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\Backend\ModifyLinkExplanationEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/backend/modify-imagemanipulation-previewurl'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Backend/ModifyLinkExplanationEventListener.php

   use TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent

   final class ModifyLinkExplanationEventListener
   {
       public function __invoke(ModifyImageManipulationPreviewUrlEvent $event): void
       {
           $event->setPreviewUrl('https://example.com/some/preview/url');
       }
   }
