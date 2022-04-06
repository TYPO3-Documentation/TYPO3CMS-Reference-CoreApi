.. include:: /Includes.rst.txt


.. _AfterExtensionFilesHaveBeenImportedEvent:


========================================
AfterExtensionFilesHaveBeenImportedEvent
========================================

.. versionadded:: 10.3

Event that is triggered after a package has imported all extension files (from `Initialisation/Files`).

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getPackageKey()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getDestinationAbsolutePath()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getEmitter()
   :sep:`|` :aspect:`ReturnType:` `InstallUtility`
   :sep:`|`

   |nbsp|
