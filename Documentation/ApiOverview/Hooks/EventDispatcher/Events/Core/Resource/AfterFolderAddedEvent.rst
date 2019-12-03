.. include:: ../../../../../../Includes.txt


.. _AfterFolderAddedEvent:


=====================
AfterFolderAddedEvent
=====================

This event is fired after a folder was added to the Resource Storage / Driver.
This allows to customize permissions or set up editor permissions automatically via listeners.

API
---

 - :Method:
         getFolder()
   :Description:
         Returns the folder that has been added.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

