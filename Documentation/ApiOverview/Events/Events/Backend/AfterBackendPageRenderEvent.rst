..  include:: /Includes.rst.txt
..  index:: Events; AfterBackendPageRenderEvent
..  _AfterBackendPageRenderEvent:

===========================
AfterBackendPageRenderEvent
===========================

..  versionadded:: 12.0

    The PSR-14 event :php:`AfterBackendPageRenderEvent` has
    been introduced which serves as a direct replacement for the removed hooks:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['renderPreProcess']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['renderPostProcess']`

This event gets triggered after the page in the backend is rendered and includes
the rendered page body. Listeners may overwrite the page string if desired.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    Vendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/after-backend-controller-render'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    use TYPO3\CMS\Backend\Controller\Event\AfterBackendPageRenderEvent;

    final class MyEventListener
    {
        public function __invoke(AfterBackendPageRenderEvent $event): void
        {
            $content = $event->getContent() . ' I was here';
            $event->setContent($content);
        }
    }


API
===

..  include:: /CodeSnippets/Events/Backend/AfterBackendPageRenderEvent.rst.txt
