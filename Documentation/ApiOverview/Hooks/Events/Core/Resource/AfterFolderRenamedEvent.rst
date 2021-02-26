.. include:: /Includes.rst.txt
.. index:: Events; AfterFolderRenamedEvent
.. _AfterFolderRenamedEvent:


=======================
AfterFolderRenamedEvent
=======================

This event is fired after a folder was renamed.
*Examples*: Add custom processing of folders or adjust permissions.

This event is also used by TYPO3 itself to synchronize folder relations in
records (for example in :sql:`sys_filemounts`) after renaming of folders.

API
---

.. rst-class:: dl-parameters

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   Returns the renamed folder object.

getSourceFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   Returns the original folder object.

