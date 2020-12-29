.. include:: /Includes.rst.txt
.. index:: Events; AfterFolderMovedEvent
.. _AfterFolderMovedEvent:


=====================
AfterFolderMovedEvent
=====================

This event is fired after a folder was moved within the Resource Storage / Driver.
Custom references can be updated via listeners of this event.

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

getTargetFolder()
   :sep:`|` :aspect:`ReturnType:` `?\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

