.. include:: ../../../../../Includes.txt


.. _AfterFolderDeletedEvent:


=======================
AfterFolderDeletedEvent
=======================

This event is fired after a folder was deleted.
Custom listeners can then further clean up permissions or
third-party processed files with this event.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

isDeleted()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   |nbsp|

