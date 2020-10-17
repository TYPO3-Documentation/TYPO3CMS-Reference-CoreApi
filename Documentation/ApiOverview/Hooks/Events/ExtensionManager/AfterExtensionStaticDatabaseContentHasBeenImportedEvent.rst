.. include:: ../../../../Includes.txt


.. _AfterExtensionStaticDatabaseContentHasBeenImportedEvent:


=======================================================
AfterExtensionStaticDatabaseContentHasBeenImportedEvent
=======================================================

.. versionadded:: 10.3

Event that is triggered after a package has imported the database file shipped within "ext_tables_static+adt.sql".

API
===

 - :Method:
         getPackageKey()
   :Description:
         Returns the package key.
   :ReturnType:
         string


 - :Method:
         getSqlFileName()
   :Description:
         Returns the sql file name.
   :ReturnType:
         string


 - :Method:
         getEmitter()
   :Description:
         Returns the current instance of :php:`InstallUtility`.
   :ReturnType:
         `InstallUtility`



