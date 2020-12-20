.. include:: /Includes.rst.txt
.. index:: Events; BeforeFolderCopiedEvent
.. _BeforeFolderCopiedEvent:


=======================
BeforeFolderCopiedEvent
=======================

This event is fired before a folder is about to be copied to the Resource Storage / Driver.
Listeners could add deferred processing / queuing of large folders.

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

