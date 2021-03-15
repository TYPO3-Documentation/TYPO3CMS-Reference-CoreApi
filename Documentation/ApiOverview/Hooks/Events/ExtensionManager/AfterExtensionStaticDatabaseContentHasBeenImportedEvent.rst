.. include:: /Includes.rst.txt


.. _AfterExtensionStaticDatabaseContentHasBeenImportedEvent:


=======================================================
AfterExtensionStaticDatabaseContentHasBeenImportedEvent
=======================================================

.. versionadded:: 10.3

Event that is triggered after a package has imported the database file shipped within "ext_tables_static+adt.sql".

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getPackageKey()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getSqlFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getEmitter()
   :sep:`|` :aspect:`ReturnType:` `InstallUtility`
   :sep:`|`

   |nbsp|
