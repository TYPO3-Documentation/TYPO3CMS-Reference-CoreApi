.. include:: /Includes.rst.txt


.. _BeforeFileCopiedEvent:


=====================
BeforeFileCopiedEvent
=====================

This event is fired before a file is about to be copied within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or metadata before it is written by the driver.

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

