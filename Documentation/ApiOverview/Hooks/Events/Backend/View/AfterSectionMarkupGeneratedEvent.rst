.. include:: ../../../../../Includes.txt


.. _AfterSectionMarkupGeneratedEvent:


================================
AfterSectionMarkupGeneratedEvent
================================

:php:`TYPO3\CMS\Backend\View\Event\AfterSectionMarkupGeneratedEvent`

.. versionadded:: 10.3

    AfterSectionMarkupGeneratedEvent and BeforeSectionMarkupGeneratedEvent
    were added with the change
    :doc:`t3core:Changelog/master/Feature-88921-NewEventInThePageLayoutViewClassToEnrichContentIntoTheColumnsInTheBackendLayout`.

These events can be used to add content into any column of a BackendLayout.
You can use this for example to show some content in a column without a ``colPos`` assigned.

The event :php:`AfterSectionMarkupGeneratedEvent`
can be used to add content below the content elements of the column.

Example
=======

You can use business logic to show content in specific columns.
E.g. for displaying content only in columns without any ``colPos``
in the BackendLayout configuration.

Example Service.yaml to register the event listener in your own extension:

:file:`EXT:my_extension/Configuration/Services.yaml`

.. code-block:: yaml

  Vendor\MyExtension\Backend\View\PageLayoutViewDrawEmptyColposContent:
    tags:
      - name: event.listener
        identifier: 'myColposListener'
        before: 'backend-empty-colpos'
        event:  TYPO3\CMS\Backend\View\Event\AfterSectionMarkupGeneratedEvent

With :yaml:`before` and :yaml:`after`, you can make sure your own listener is
executed before or after the given identifiers.

:file:`EXT:my_extension/Classes/Backend/View/PageLayoutViewDrawEmptyColposContent.php`

.. code-block:: php

   class PageLayoutViewDrawEmptyColposContent
   {
      public function __invoke(AfterSectionMarkupGeneratedEvent $event): void
      {
         if (
             !isset($event->getColumnConfig()['colPos'])
             || trim($event->getColumnConfig()['colPos']) === ''
         ) {
            $content = $event->getContent();
            $content .= <<<EOD
               <div class="t3-page-ce-wrapper">
                  <div class="t3-page-ce">
                     <div class="t3-page-ce-header">Empty colpos</div>
                     <div class="t3-page-ce-body">
                        <div class="t3-page-ce-body-inner">
                           <div class="row">
                              <div class="col-xs-12">
                                 This column has no "colPos". This is only for display Purposes.
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            EOD;

            $event->setStopRendering(true);
            $event->setContent($content);
         }
      }
   }


API
===

see abstract :php:`\TYPO3\CMS\Backend\View\Event\AbstractSectionMarkupGeneratedEvent`:


 - :Method:
         getPageLayoutView()
   :Description:
         Get page layout view.
   :ReturnType:
         \TYPO3\CMS\Backend\View\PageLayoutView

 - :Method:
         getLanguageId()
   :Description:
         Get language id
   :ReturnType:
         int

 - :Method:
         getColumnConfig()
   :Description:
         Returns the column configuration.
   :ReturnType:
         array

 - :Method:
         setContent()
   :Description:
         Sets the content.
   :Arguments:
         string $content
   :ReturnType:
         void

 - :Method:
         getContent()
   :Description:
         Returns the content.
   :ReturnType:
         string

 - :Method:
         isPropagationStopped()
   :Description:
         This is used to check if the rendering has been stopped with setStopRendering().
   :ReturnType:
         bool

 - :Method:
         setStopRendering()
   :Description:
         Prevent other listeners from being called if rendering is stopped by listener.
   :ReturnType:
         string


