.. include:: /Includes.rst.txt
.. index:: Events; AfterRecordPublishedEvent
.. _AfterRecordPublishedEvent:


=========================
AfterRecordPublishedEvent
=========================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent` is
fired after a record has been published in a workspace.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Service.yaml

    MyVendor\MyExtension\Workspaces\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/after-record-published'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Workspaces/MyEventListener.php;

    use TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent;

    final class MyEventListener {
        public function __invoke(AfterRecordPublishedEvent $event): void
        {
            // Do your magic here
        }
    }

API
===

.. include:: /CodeSnippets/Events/Workspaces/AfterRecordPublishedEvent.rst.txt
