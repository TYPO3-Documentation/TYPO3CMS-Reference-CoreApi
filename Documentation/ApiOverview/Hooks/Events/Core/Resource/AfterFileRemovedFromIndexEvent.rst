.. include:: /Includes.rst.txt
.. index:: Events; AfterFileRemovedFromIndexEvent
.. _AfterFileRemovedFromIndexEvent:


==============================
AfterFileRemovedFromIndexEvent
==============================

This event is fired once a file was just removed in the database (sys_file).
*Example* can be to further handle files and manage them separately outside of TYPO3's index.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileUid()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

