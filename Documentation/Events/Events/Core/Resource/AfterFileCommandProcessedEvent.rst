.. include:: /Includes.rst.txt

.. _AfterFileCommandProcessedEvent:

==============================
AfterFileCommandProcessedEvent
==============================

.. versionadded:: 11.4

The :php:`AfterFileCommandProcessedEvent` can be used to perform additional tasks for specific file commands. For example, trigger a custom indexer after a file has been uploaded.

The `AfterFileCommandProcessedEvent` is fired in the :php:`ExtendedFileUtility`
class.

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml

   MyVendor\MyPackage\File\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/file/my-event-listener'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Core\Resource\Event\AfterFileCommandProcessedEvent;

    class MyEventListener {

        public function __invoke(AfterFileCommandProcessedEvent $event): void
        {
            // do magic here
        }

    }

API
---

.. include:: /CodeSnippets/Events/Core/Resource/AfterFileCommandProcessedEvent.rst.txt
