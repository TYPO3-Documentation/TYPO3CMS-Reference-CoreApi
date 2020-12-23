.. include:: /Includes.rst.txt
.. index:: Events; AfterFileAddedEvent
.. _AfterFileAddedEvent:

===================
AfterFileAddedEvent
===================

This event is fired after a file was added to the Resource Storage / Driver.

Use case: Using listeners for this event allows to for example post-check permissions or
specific analysis of files like additional metadata analysis after adding them to `TYPO3`:pn:.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

