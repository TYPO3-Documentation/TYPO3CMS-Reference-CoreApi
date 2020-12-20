.. include:: /Includes.rst.txt
.. index:: Events; AfterExtensionDatabaseContentHasBeenImportedEvent
.. _AfterExtensionDatabaseContentHasBeenImportedEvent:


=================================================
AfterExtensionDatabaseContentHasBeenImportedEvent
=================================================

.. versionadded:: 10.3

Event that is triggered after a package has imported the database file shipped within a t3d/xml import file.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getPackageKey()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getImportFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getImportResult()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getEmitter()
   :sep:`|` :aspect:`ReturnType:` `InstallUtility`
   :sep:`|`

   |nbsp|
