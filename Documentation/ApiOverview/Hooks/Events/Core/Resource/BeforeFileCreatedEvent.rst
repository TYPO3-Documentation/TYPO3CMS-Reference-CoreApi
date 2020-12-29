.. include:: /Includes.rst.txt
.. index:: Events; BeforeFileCreatedEvent
.. _BeforeFileCreatedEvent:


======================
BeforeFileCreatedEvent
======================

This event is fired before a file is about to be created within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or filename before it is written by the driver.

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

