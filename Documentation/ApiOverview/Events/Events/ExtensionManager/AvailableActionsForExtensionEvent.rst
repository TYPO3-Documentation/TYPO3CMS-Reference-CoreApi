..  include:: /Includes.rst.txt
..  index:: Events; AvailableActionsForExtensionEvent
..  _AvailableActionsForExtensionEvent:

=================================
AvailableActionsForExtensionEvent
=================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\ViewHelper\ProcessAvailableActionsViewHelper::processActions`.

The PSR-14 event
:php:`\TYPO3\CMS\Extensionmanager\Event\AvailableActionsForExtensionEvent`
is triggered when rendering an additional action (currently within
a Fluid ViewHelper) in the extension manager.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/ExtensionManager/AvailableActionsForExtensionEvent.rst.txt
