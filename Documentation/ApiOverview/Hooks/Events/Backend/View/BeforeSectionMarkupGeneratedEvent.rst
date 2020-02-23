.. include:: ../../../../../Includes.txt


.. _BeforeSectionMarkupGeneratedEvent:


=================================
BeforeSectionMarkupGeneratedEvent
=================================

:php:`TYPO3\CMS\Backend\View\Event\BeforeSectionMarkupGeneratedEvent`

.. versionadded:: 10.3

    AfterSectionMarkupGeneratedEvent and BeforeSectionMarkupGeneratedEvent
    were added with the change
    :doc:`t3core:Changelog/master/Feature-88921-NewEventInThePageLayoutViewClassToEnrichContentIntoTheColumnsInTheBackendLayout`.


These events can be used to add content into any column of a Backend Layout.
You can use this for example to show some content in a column without a ``colPos`` assigned.

The event :php:`BeforeSectionMarkupGeneratedEvent` can be used to add content above
the content elements of the column.

Example
=======

For an example, see :ref:`AfterSectionMarkupGeneratedEvent`.

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


