.. include:: /Includes.rst.txt
.. index:: Events; AfterFileMovedEvent
.. _AfterFileMovedEvent:


===================
AfterFileMovedEvent
===================

This event is fired after a file was moved within a Resource Storage / Driver.
The folder represents the "target folder".

*Examples*: Use this to update custom third party handlers that rely on specific paths.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getOriginalFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

