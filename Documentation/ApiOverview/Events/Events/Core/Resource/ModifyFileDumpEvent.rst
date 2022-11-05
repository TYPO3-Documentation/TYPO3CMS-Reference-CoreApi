.. include:: /Includes.rst.txt
.. index:: Events; ModifyFileDumpEvent
.. _ModifyFileDumpEvent:


===================
ModifyFileDumpEvent
===================

.. versionadded:: 11.4

The `ModifyFileDumpEvent` is fired in the :php:`FileDumpController` and allows extensions
to perform additional access / security checks before dumping a file. The
event does not only contain the file to dump but also the PSR-7 Request.

In case the file dump should be rejected, the event has to set a PSR-7
response, usually with a `403` status code. This will then immediately
stop the propagation.

With the event, it's not only possible to reject the file dump request,
but also to replace the file, which should be dumped.

Example
=======

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml

   MyVendor\MyPackage\Resource\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/resource/my-event-listener'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Core\Resource\Event\ModifyFileDumpEvent;

    final class MyEventListener {

        public function __invoke(ModifyFileDumpEvent $event): void
        {
            // do magic here
        }

    }

API
===

.. include:: /CodeSnippets/Events/Core/Resource/ModifyFileDumpEvent.rst.txt
