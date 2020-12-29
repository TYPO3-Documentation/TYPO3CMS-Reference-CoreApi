.. include:: /Includes.rst.txt
.. index:: Events; AfterFolderCopiedEvent
.. _AfterFolderCopiedEvent:


======================
AfterFolderCopiedEvent
======================

This event is fired after a folder was copied to the Resource Storage / Driver.
*Example*: Custom listeners can analyze contents of a file or add custom permissions to a folder automatically.

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

