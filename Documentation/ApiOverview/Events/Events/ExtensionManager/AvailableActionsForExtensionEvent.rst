..  include:: /Includes.rst.txt
..  index:: Events; AvailableActionsForExtensionEvent
..  _AvailableActionsForExtensionEvent:

=================================
AvailableActionsForExtensionEvent
=================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\ViewHelper\ProcessAvailableActionsViewHelper::processActions`.

Event that is triggered when rendering an additional action (currently within
a Fluid ViewHelper) in the extension manager.

API
===

..  include:: /CodeSnippets/Events/ExtensionManager/AvailableActionsForExtensionEvent.rst.txt
