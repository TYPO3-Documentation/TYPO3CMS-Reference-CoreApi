.. include:: /Includes.rst.txt


.. _AfterFileContentsSetEvent:


=========================
AfterFileContentsSetEvent
=========================

This event is fired after the contents of a file got set / replaced.

*Examples*: Listeners can analyze content for AI purposes within Extensions.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getContent()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

