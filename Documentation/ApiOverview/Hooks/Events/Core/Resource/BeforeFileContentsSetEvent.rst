.. include:: /Includes.rst.txt
.. index:: Events; BeforeFileContentsSetEvent
.. _BeforeFileContentsSetEvent:


==========================
BeforeFileContentsSetEvent
==========================

This event is fired before the contents of a file gets set / replaced.
This allows to further analyze or modify the content of a file before it is written by the driver.

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

setContent(string $content)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

