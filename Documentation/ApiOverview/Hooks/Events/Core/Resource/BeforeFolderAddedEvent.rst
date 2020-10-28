.. include:: ../../../../../Includes.txt


.. _BeforeFolderAddedEvent:


======================
BeforeFolderAddedEvent
======================

This event is fired before a folder is about to be added to the Resource Storage / Driver.
This allows to further specify folder names according to regulations for a specific project.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getParentFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getFolderName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

