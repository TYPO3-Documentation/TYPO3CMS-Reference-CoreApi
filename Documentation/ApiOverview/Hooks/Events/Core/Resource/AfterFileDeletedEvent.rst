.. include:: ../../../../../Includes.txt


.. _AfterFileDeletedEvent:


======================
AfterFileDeletedEvent
======================

This event is fired after a file was deleted.

*Example*: If an extension provides additional functionality (e.g. variants),
this event allows listener to also clean
up their custom handling. This can also be used for versioning of files.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

