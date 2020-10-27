.. include:: ../../../../../Includes.txt


.. _ModifyIconForResourcePropertiesEvent:


====================================
ModifyIconForResourcePropertiesEvent
====================================

This is an event every time an icon for a resource (file or folder) is fetched, allowing
to modify the icon or overlay in an event listener.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getResource()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceInterface`
   :sep:`|`

   |nbsp|

getSize()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getOptions()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getIconIdentifier()
   :sep:`|` :aspect:`ReturnType:` ?string
   :sep:`|`

   |nbsp|

setIconIdentifier(?string $iconIdentifier)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getOverlayIdentifier()
   :sep:`|` :aspect:`ReturnType:` ?string
   :sep:`|`

   |nbsp|

setOverlayIdentifier(?string $overlayIdentifier)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

