..  include:: /Includes.rst.txt
..  index:: Events; AfterPackageDeactivationEvent
..  _AfterPackageDeactivationEvent:

=============================
AfterPackageDeactivationEvent
=============================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::afterExtensionUninstall`.

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\AfterPackageDeactivationEvent`
is triggered after a package has been deactivated.

..  attention::
    This event is dispatched when an extension is deactivated in the
    :guilabel:`Extension Manager`, therefore starting with TYPO3 v11 this
    event is only dispatched in Classic mode installations, not in Composer-based
    installations. Use
    `installer events by Composer <https://getcomposer.org/doc/articles/scripts.md#installer-events>`__
    for Composer-based installations.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/AfterPackageDeactivationEvent.rst.txt
