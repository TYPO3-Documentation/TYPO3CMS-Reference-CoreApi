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

Changing the host of the current request and setting it as canonical:
.. code-block:: php

    final class MyEventListener {
        public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
        {
            // Note: $event->getUrl(); is dispatched with the empty string value ''
            $currentUrl = $GLOBALS['TYPO3_REQUEST']->getUri();
            $newCanonical = $currentUrl->withHost('example.com');
            $event->setUrl($newCanonical);
        }
    }


API
===

..  include:: /CodeSnippets/Events/Seo/ModifyUrlForCanonicalTagEvent.rst.txt
