..  include:: /Includes.rst.txt
..  index:: Events; ModifyEditFileFormDataEvent
..  _ModifyEditFileFormDataEvent:

===========================
ModifyEditFileFormDataEvent
===========================

..  versionadded:: 12.1
    This event can be used as an improved alternative for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/file_edit.php']['preOutputProcessingHook']`
    hook.

The PSR-14 event :php:`TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent`
allows to modify the form data, used to render the file edit form in the
:guilabel:`File > Filelist` module using
:ref:`FormEngine data compiling <FormEngine-DataCompiling>`.


Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_package/Configuration/Services.yaml

    MyVendor\MyPackage\EventListener\ModifyEditFileFormDataEventListener:
        tags:
            - name: event.listener
              identifier: 'my-package/modify-edit-file-form-data-event-listener'

The corresponding event listener class:

..  code-block:: php
   :caption: EXT:my_package/Classes/EventLister/ModifyEditFileFormDataEventListener.php

    use TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent;

    final class ModifyEditFileFormDataEventListener
    {
        public function __invoke(ModifyEditFileFormDataEvent $event): void
        {
            // Get current form data
            $formData = $event->getFormData();

            // Change TCA "renderType" based on the file extension
            $fileExtension = $event->getFile()->getExtension();
            if ($fileExtension === 'ts') {
                $formData['processedTca']['columns']['data']['config']['renderType'] = 'tsRenderer';
            }

            // Set updated form data
            $event->setFormData($formData);
        }
    }

API
===

..  include:: /CodeSnippets/Events/Filelist/ModifyEditFileFormDataEvent.rst.txt
