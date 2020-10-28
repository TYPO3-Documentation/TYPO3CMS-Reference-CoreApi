.. include:: ../../../../../Includes.txt


.. _AfterFileRenamedEvent:


=====================
AfterFileRenamedEvent
=====================

This event is fired after a file was renamed in order to further process a file or filename
or update custom references to a file.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getTargetFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

