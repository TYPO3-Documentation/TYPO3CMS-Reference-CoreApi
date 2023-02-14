..  include:: /Includes.rst.txt
..  index::
    Events; AfterPageColumnsSelectedForLocalizationEvent
    Events; LocalizationController
..  _AfterPageColumnsSelectedForLocalizationEvent:

============================================
AfterPageColumnsSelectedForLocalizationEvent
============================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterPageColumnsSelectedForLocalizationEvent`
is available to listen for after the :ref:`form engine <FormEngine>` has been
initialized (and all data has been persisted). It will be dispatched after
records and columns are collected in the
:php:`\TYPO3\CMS\Backend\Controller\Page\LocalizationController`.

The event receives:

*   The default columns and columns list built by :php:`LocalizationController`
*   The list of records that were analyzed to create the columns manifest
*   The parameters received by the :php:`LocalizationController`

The event allows changes to:

*   the columns
*   the columns list

This allows third-party code to read or manipulate the "columns manifest" that
gets displayed in the translation modal when a user has clicked the
:guilabel:`Translate` button in the page module, by implementing a listener for
the event.


API
===

..  include:: /CodeSnippets/Events/Backend/AfterPageColumnsSelectedForLocalizationEvent.rst.txt
