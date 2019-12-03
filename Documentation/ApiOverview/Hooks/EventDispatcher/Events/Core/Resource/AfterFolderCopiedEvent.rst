.. include:: ../../../../../../Includes.txt


.. _AfterFolderCopiedEvent:


======================
AfterFolderCopiedEvent
======================

This event is fired after a folder was copied to the Resource Storage / Driver.
*Example*: Custom listeners can analyze contents of a file or add custom permissions to a folder automatically.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder about to be copied.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetParentFolder()
   :Description:
         Returns the parent folder to be copied to.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetFolder()
   :Description:
         Returns the target folder after copying.
   :ReturnType:
         ?\TYPO3\CMS\Core\Resource\Folder

