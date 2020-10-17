.. include:: ../../../../Includes.txt


.. _AfterExtensionDatabaseContentHasBeenImportedEvent:


=================================================
AfterExtensionDatabaseContentHasBeenImportedEvent
=================================================

.. versionadded:: 10.3

Event that is triggered after a package has imported the database file shipped within a t3d/xml import file.

API
===

 - :Method:
         getPackageKey()
   :Description:
         Returns the package key.
   :ReturnType:
         string


 - :Method:
         getImportFileName()
   :Description:
         Returns the imported file name.
   :ReturnType:
         string

 - :Method:
         getImportResult()
   :Description:
         Returns the number of pages imported.
   :ReturnType:
         int


 - :Method:
         getEmitter()
   :Description:
         Returns the current instance of :php:`InstallUtility`.
   :ReturnType:
         `InstallUtility`



