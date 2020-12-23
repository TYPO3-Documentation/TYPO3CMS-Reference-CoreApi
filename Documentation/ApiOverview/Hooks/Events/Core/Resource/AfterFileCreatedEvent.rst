.. include:: /Includes.rst.txt
.. index:: Events; AfterFileCreatedEvent
.. _AfterFileCreatedEvent:


=====================
AfterFileCreatedEvent
=====================

This event is fired before a file was created within a Resource Storage / Driver.
The folder represents the "target folder".

*Example*: This allows to modify a file or check for an appropriate signature after a file was created in `TYPO3`:pn:.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

