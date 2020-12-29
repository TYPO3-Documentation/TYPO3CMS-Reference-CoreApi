.. include:: /Includes.rst.txt
.. index:: Events; AfterResourceStorageInitializationEvent
.. _AfterResourceStorageInitializationEvent:


=======================================
AfterResourceStorageInitializationEvent
=======================================

This event is fired after a resource object was built/created.
Custom handlers can be initialized at this moment for any kind of resource as well.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getStorage()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`
   :sep:`|`

   |nbsp|

setStorage(ResourceStorage $storage)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

