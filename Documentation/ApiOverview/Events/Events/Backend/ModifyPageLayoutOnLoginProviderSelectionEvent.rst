..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLayoutOnLoginProviderSelectionEvent
..  _ModifyPageLayoutOnLoginProviderSelectionEvent:

===============================================
`ModifyPageLayoutOnLoginProviderSelectionEvent`
===============================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\LoginProvider\Event\ModifyPageLayoutOnLoginProviderSelectionEvent`
allows to modify variables for the view depending on a special login provider
set in the controller.

..  _modify-page-layout-on-login-provider-selection-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _modify-page-layout-on-login-provider-selection-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyPageLayoutOnLoginProviderSelectionEvent.rst.txt
