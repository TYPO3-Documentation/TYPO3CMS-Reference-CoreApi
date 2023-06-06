..  include:: /Includes.rst.txt
..  index:: Events; AfterExtensionDatabaseContentHasBeenImportedEvent
..  _AfterExtensionDatabaseContentHasBeenImportedEvent:


=================================================
AfterExtensionDatabaseContentHasBeenImportedEvent
=================================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::afterExtensionStaticSqlImport`.

The PSR-14 event
:php:`\TYPO3\CMS\Extensionmanager\Event\AfterExtensionDatabaseContentHasBeenImportedEvent`
is triggered after a package has imported the database file shipped within a
:file:`t3d`/:file:`xml` import file.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/ExtensionManager/AfterExtensionDatabaseContentHasBeenImportedEvent.rst.txt
