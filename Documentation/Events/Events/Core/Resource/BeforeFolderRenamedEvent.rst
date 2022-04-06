.. include:: /Includes.rst.txt


.. _BeforeFolderRenamedEvent:


========================
BeforeFolderRenamedEvent
========================

This event is fired before a folder is about to be renamed.
Listeners can be used to modify a folder name before it is actually moved or to ensure consistency
or specific rules when renaming folders.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getTargetName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

