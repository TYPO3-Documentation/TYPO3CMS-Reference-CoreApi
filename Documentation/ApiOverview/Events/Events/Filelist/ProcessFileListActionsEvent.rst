.. include:: /Includes.rst.txt
.. index:: Events; ProcessFileListActionsEvent
.. _ProcessFileListActionsEvent:

===========================
ProcessFileListActionsEvent
===========================

.. versionadded:: 11.4


The :php:`\TYPO3\CMS\Core\Configuration\Event\ProcessFileListActionsEvent`
is fired after generating the actions for the
files and folders listing in the :guilabel:`File > Filelist` module.

This event can be used to manipulate the icons/actions, used for the edit control
section in the files and folders listing within the :guilabel:`File > Filelist`
module.

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\FileList\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/filelist/my-event-listener'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent;

    class MyEventListener {

        public function __invoke(ProcessFileListActionsEvent $event): void
        {
            // do your magic
        }

    }

API
---

.. include:: /CodeSnippets/Events/Filelist/ProcessFileListActionsEvent.rst.txt
