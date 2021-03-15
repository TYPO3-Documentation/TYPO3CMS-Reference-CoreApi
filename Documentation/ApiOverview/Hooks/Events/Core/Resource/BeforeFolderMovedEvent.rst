.. include:: /Includes.rst.txt


.. _BeforeFolderMovedEvent:


======================
BeforeFolderMovedEvent
======================

This event is fired before a folder is about to be moved to the Resource Storage / Driver.
Listeners can be used to modify a folder name before it is actually moved or to ensure consistency
or specific rules when moving folders.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getTargetParentFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getTargetFolderName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

