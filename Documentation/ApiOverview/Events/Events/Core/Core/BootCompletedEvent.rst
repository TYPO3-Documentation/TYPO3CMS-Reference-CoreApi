.. include:: /Includes.rst.txt
.. index:: Events; BootCompletedEvent
.. _BootCompletedEvent:

==================
BootCompletedEvent
==================

.. versionadded:: 11.4

The :php:`BootCompletedEvent` is fired on every request when TYPO3 has been
fully booted, right after all configuration files have been added.

This new event complements the :ref:`AfterTcaCompilationEvent` which
is executed after TCA configuration has been assembled.

Use cases for this event include running extensions'
code which needs to be executed at any time, and needs
TYPO3's full configuration including all loaded extensions.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\Bootstrap\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/my-listener'

.. code-block:: php

    final class MyEventListener {
        public function __invoke(BootCompletedEvent $e): void
        {
            // do your magic
        }
    }


API
===

.. include:: /CodeSnippets/Events/Core/BootCompletedEvent.rst.txt
