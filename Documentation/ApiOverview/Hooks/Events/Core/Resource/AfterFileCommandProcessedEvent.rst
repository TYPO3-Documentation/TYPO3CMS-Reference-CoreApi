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

.. rst-class:: dl-parameters

:php:`getCommand()`
   :sep:`|` :aspect:`ReturnType:` :php:`array`
   :sep:`|`

   Returns the command array. The array key is the performed action and the value is the command data (`cmdArr`).

:php:`getResult()`
   :sep:`|` :aspect:`ReturnType:` :php:`mixed`
   :sep:`|`

   Returns the operation result, which could e.g. be an uploaded or changed :php:`File` or a :php:`boolean` for the "delete" action

:php:`getConflictMode()`
   :sep:`|` :aspect:`ReturnType:` :php:`string`
   :sep:`|`

   The conflict mode for the performed operation, e.g. "rename" or "cancel".

