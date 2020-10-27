.. include:: ../../../../../Includes.txt


.. _AfterFileCopiedEvent:


====================
AfterFileCopiedEvent
====================

This event is fired after a file was copied within a Resource Storage / Driver.
The folder represents the "target folder".

*Example*: Listeners can sign up for listing duplicates using this event.

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

