.. include:: ../../../../../../Includes.txt


.. _BeforeFileContentsSetEvent:


==========================
BeforeFileContentsSetEvent
==========================

This event is fired before the contents of a file gets set / replaced.
This allows to further analyze or modify the content of a file before it is written by the driver.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getContent()
   :Description:
         Returns the current file content.
   :ReturnType:
         string


 - :Method:
         setContent(string $content)
   :Description:
         Set / Overwrite the current file content.
   :ReturnType:
         void

