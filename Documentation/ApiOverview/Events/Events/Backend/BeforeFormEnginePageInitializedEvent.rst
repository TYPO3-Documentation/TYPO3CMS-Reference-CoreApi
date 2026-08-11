..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormEnginePageInitializedEvent
..  _BeforeFormEnginePageInitializedEvent:

======================================
`BeforeFormEnginePageInitializedEvent`
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent`
allows to listen for before the :ref:`form engine <FormEngine>` has been
initialized (before all data will be persisted).

..  _before-form-engine-page-initialized-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-form-engine-page-initialized-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeFormEnginePageInitializedEvent.rst.txt
