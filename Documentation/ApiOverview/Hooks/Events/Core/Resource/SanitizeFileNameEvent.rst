.. include:: /Includes.rst.txt
.. index:: Events; SanitizeFileNameEvent
.. _SanitizeFileNameEvent:


=====================
SanitizeFileNameEvent
=====================

This event is fired once an index was just added to the database (= indexed), so it is possible
to modify the file name, and name the files according to naming conventions of a specific project.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

setFileName(string $fileName)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getTargetFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getStorage()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`
   :sep:`|`

   |nbsp|

getDriver()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Driver\DriverInterface`
   :sep:`|`

   |nbsp|

