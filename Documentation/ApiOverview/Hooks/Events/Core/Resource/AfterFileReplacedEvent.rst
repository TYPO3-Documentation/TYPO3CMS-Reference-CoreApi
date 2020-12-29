.. include:: /Includes.rst.txt
.. index:: Events; AfterFileReplacedEvent
.. _AfterFileReplacedEvent:


======================
AfterFileReplacedEvent
======================

This event is fired after a file was replaced.

*Example*: Further process a file or create variants, or index the
contents of a file for AI analysis etc.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getLocalFilePath()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

