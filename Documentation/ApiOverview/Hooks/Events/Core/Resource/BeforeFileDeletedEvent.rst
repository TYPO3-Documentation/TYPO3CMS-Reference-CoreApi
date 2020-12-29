.. include:: /Includes.rst.txt
.. index:: Events; BeforeFileDeletedEvent
.. _BeforeFileDeletedEvent:


======================
BeforeFileDeletedEvent
======================

This event is fired before a file is about to be deleted.

Event listeners can clean up third-party references with this event.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

