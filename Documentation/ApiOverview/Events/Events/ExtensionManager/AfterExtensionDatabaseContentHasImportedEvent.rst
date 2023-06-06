..  include:: /Includes.rst.txt
..  index:: Events; AfterExtensionDatabaseContentHasBeenImportedEvent
..  _AfterExtensionDatabaseContentHasBeenImportedEvent:


=================================================
AfterExtensionDatabaseContentHasBeenImportedEvent
=================================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::afterExtensionStaticSqlImport`.

Event that is triggered after a package has imported the database file shipped
within a t3d/xml import file.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/ExtensionManager/AfterExtensionDatabaseContentHasBeenImportedEvent.rst.txt
