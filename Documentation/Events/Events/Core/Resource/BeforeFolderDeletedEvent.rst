.. include:: /Includes.rst.txt


.. _BeforeFolderDeletedEvent:


========================
BeforeFolderDeletedEvent
========================

This event is fired before a folder is about to be deleted.

Listeners can use this event to clean up further external references
to a folder / files in this folder.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

