..  include:: /Includes.rst.txt
..  index:: Events; ModifyUrlForCanonicalTagEvent
..  _ModifyUrlForCanonicalTagEvent:


=============================
ModifyUrlForCanonicalTagEvent
=============================

With the PSR-14 event `\TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent`
the URL for the :html:`href` attribute of the canonical tag can be altered or
emptied.

Example
=======

Registration of the event in the :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\EventListener\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/my-listener'
        event: TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent

.. code-block:: php

    final class MyEventListener {
        public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
        {
            // do your magic
            // Note: $event->getUrl(); is initialized with the empty string value ''
        }
    }


API
===

..  include:: /CodeSnippets/Events/Seo/ModifyUrlForCanonicalTagEvent.rst.txt
