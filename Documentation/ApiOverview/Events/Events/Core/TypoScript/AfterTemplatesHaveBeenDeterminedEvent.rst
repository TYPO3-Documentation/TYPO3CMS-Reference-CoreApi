.. include:: /Includes.rst.txt
.. index:: Events; AfterTemplatesHaveBeenDeterminedEvent
.. _AfterTemplatesHaveBeenDeterminedEvent:

=====================================
AfterTemplatesHaveBeenDeterminedEvent
=====================================

.. versionadded:: 12.0
   This event is a substitution of the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Core/TypoScript/TemplateService']['runThroughTemplatesPostProcessing']`
   hook.

The event :php:`AfterTemplatesHaveBeenDeterminedEvent` can be used
to manipulate :sql:`sys_template` rows. The event receives the list of resolved
:sql:`sys_template` rows and the :php:`ServerRequestInterface` and allows manipulating the
:sql:`sys_template` rows array.

The event is called in backend EXT:tstemplate code, for example in
the :guilabel:`Template Analyzer`, and in the frontend.

Extensions using the old hook that want to stay compatible with both TYPO3 v11
and v12 can implement both the hook and the event.

Example
=======

.. code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\EventListener\MyAfterTemplatesHaveBeenDeterminedEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/typoscript/post-process-sys-templates'


The corresponding event listener class could look like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/MyAfterTemplatesHaveBeenDeterminedEventListener.php

    use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\AfterTemplatesHaveBeenDeterminedEvent;

    final class MyAfterTemplatesHaveBeenDeterminedEventListener
    {
        public function __invoke(AfterTemplatesHaveBeenDeterminedEvent $event): void
        {
            $rows = $event->getTemplateRows();
            // do something
            $event->setTemplateRows($rows);
        }
    }

API
===

.. include:: /CodeSnippets/Events/Core/AfterTemplatesHaveBeenDeterminedEvent.rst.txt
