.. include:: ../../../../Includes.txt


.. _AfterExtensionStaticDatabaseContentHasBeenImportedEvent:


========================================
AfterExtensionFilesHaveBeenImportedEvent
========================================

.. versionadded:: 10.3

Event that is triggered after a package has imported all extension files (from `Initialisation/Files`).

API
===

 - :Method:
         getPackageKey()
   :Description:
         Returns the package key.
   :ReturnType:
         string


 - :Method:
         getDestinationAbsolutePath()
   :Description:
         Returns the (absolute) path to the new file destination.
   :ReturnType:
         string


 - :Method:
         getEmitter()
   :Description:
         Returns the current instance of :php:`InstallUtility`.
   :ReturnType:
         `InstallUtility`



