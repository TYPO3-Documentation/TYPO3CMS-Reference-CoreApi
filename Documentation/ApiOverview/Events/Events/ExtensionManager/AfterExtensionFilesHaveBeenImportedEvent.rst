..  include:: /Includes.rst.txt
..  index:: Events; AfterExtensionFilesHaveBeenImportedEvent
..  _AfterExtensionFilesHaveBeenImportedEvent:


========================================
AfterExtensionFilesHaveBeenImportedEvent
========================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::afterExtensionFileImport`.

Event that is triggered after a package has imported all extension files
(from :file:`Initialisation/Files/`).

API
===

..  include:: /CodeSnippets/Events/ExtensionManager/AfterExtensionFilesHaveBeenImportedEvent.rst.txt
