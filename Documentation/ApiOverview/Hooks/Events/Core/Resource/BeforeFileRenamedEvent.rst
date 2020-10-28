.. include:: ../../../../../Includes.txt


.. _BeforeFileRenamedEvent:


======================
BeforeFileRenamedEvent
======================

This event is fired before a file is about to be renamed. Custom listeners can further rename the file
according to specific guidelines based on the project.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getTargetFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

