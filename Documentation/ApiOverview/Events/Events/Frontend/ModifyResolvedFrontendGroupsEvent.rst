..  include:: /Includes.rst.txt
..  index:: Events; ModifyResolvedFrontendGroupsEvent
..  _ModifyResolvedFrontendGroupsEvent:

===================================
`ModifyResolvedFrontendGroupsEvent`
===================================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent`
event allows frontend groups to be added to a (frontend) request, regardless of
whether a user is logged in or not.

..  _modify-resolved-frontend-groups-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _modify-resolved-frontend-groups-event-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyResolvedFrontendGroupsEvent.rst.txt
