.. include:: ../../../../../../Includes.txt


.. _BeforeFolderAddedEvent:


======================
BeforeFolderAddedEvent
======================

This event is fired before a folder is about to be added to the Resource Storage / Driver.
This allows to further specify folder names according to regulations for a specific project.

API
---

 - :Method:
         getParentFolder()
   :Description:
         Returns the parent folder where the folder should be stored.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getFolderName()
   :Description:
         Returns the folder name of the folder to be added.
   :ReturnType:
         string
