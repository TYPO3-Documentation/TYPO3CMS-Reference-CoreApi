.. include:: ../../../../../Includes.txt


.. _AfterFileContentsSetEvent:


=========================
AfterFileContentsSetEvent
=========================

This event is fired after the contents of a file got set / replaced.

*Examples*: Listeners can analyze content for AI purposes within Extensions.

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

