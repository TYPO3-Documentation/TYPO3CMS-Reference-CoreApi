.. include:: ../../../../../Includes.txt


.. _BeforeFileMovedEvent:


====================
BeforeFileMovedEvent
====================

This event is fired before a file is about to be moved within a Resource Storage / Driver.
The folder represents the "target folder".

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getTargetFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

