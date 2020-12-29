.. include:: /Includes.rst.txt
.. index:: Events; GeneratePublicUrlForResourceEvent
.. _GeneratePublicUrlForResourceEvent:


=================================
GeneratePublicUrlForResourceEvent
=================================

This event is fired before TYPO3 FAL's native URL generation for a Resource is instantiated.

This allows for listeners to create custom links to certain files (e.g. restrictions) for creating
authorized deeplinks.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getResource()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceInterface`
   :sep:`|`

   |nbsp|

getStorage()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`
   :sep:`|`

   |nbsp|

getDriver()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Driver\DriverInterface`
   :sep:`|`

   |nbsp|

isRelativeToCurrentScript()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   |nbsp|

getPublicUrl()
   :sep:`|` :aspect:`ReturnType:` ?string
   :sep:`|`

   |nbsp|

setPublicUrl(?string $publicUrl)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

