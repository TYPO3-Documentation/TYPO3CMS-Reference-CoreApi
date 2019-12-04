.. include:: ../../../../../Includes.txt


.. _GeneratePublicUrlForResourceEvent:


=================================
GeneratePublicUrlForResourceEvent
=================================

This event is fired before TYPO3 FAL's native URL generation for a Resource is instantiated.

This allows for listeners to create custom links to certain files (e.g. restrictions) for creating
authorized deeplinks.

API
---


 - :Method:
         getResource()
   :Description:
         Returns the currently handled resource.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ResourceInterface


 - :Method:
         getStorage()
   :Description:
         Returns the current storage object of the resource.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ResourceStorage


 - :Method:
         getDriver()
   :Description:
         Returns the current FAL driver for the resource.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Driver\DriverInterface


 - :Method:
         isRelativeToCurrentScript()
   :Description:
         Returns `true` if the resource is relative to the currently executed script.
   :ReturnType:
         bool


 - :Method:
         getPublicUrl()
   :Description:
         Returns current public URL of resource if one is available.
   :ReturnType:
         ?string


 - :Method:
         setPublicUrl(?string $publicUrl)
   :Description:
         Sets new public URL of resource - or removes public url (by setting `null`), disallowing public access.
   :ReturnType:
         void

