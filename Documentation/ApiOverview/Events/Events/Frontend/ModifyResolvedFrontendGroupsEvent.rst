..  include:: /Includes.rst.txt
..  index:: Events; ModifyResolvedFrontendGroupsEvent
..  _ModifyResolvedFrontendGroupsEvent:

=================================
ModifyResolvedFrontendGroupsEvent
=================================

..  versionadded:: 11.5
    This event is intended to restore the functionality found in the
    :php:`getGroupsFE` authentication service that was removed in TYPO3 v11.

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent`
event allows frontend groups to be added to a (frontend) request, regardless of
whether a user is logged in or not.


API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyResolvedFrontendGroupsEvent.rst.txt
