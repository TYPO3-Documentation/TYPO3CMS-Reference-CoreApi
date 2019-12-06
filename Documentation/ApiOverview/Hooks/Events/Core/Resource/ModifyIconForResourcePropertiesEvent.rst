.. include:: ../../../../../Includes.txt


.. _ModifyIconForResourcePropertiesEvent:


====================================
ModifyIconForResourcePropertiesEvent
====================================

This is an event every time an icon for a resource (file or folder) is fetched, allowing
to modify the icon or overlay in an event listener.

API
---


 - :Method:
         getResource()
   :Description:
         Returns the current resource (file or folder).
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ResourceInterface


 - :Method:
         getSize()
   :Description:
         Returns the size of the current file or folder.
   :ReturnType:
         string


 - :Method:
         getOptions()
   :Description:
         Returns the currently set options.
   :ReturnType:
         array


 - :Method:
         getIconIdentifier()
   :Description:
         Get the currently set icon identifier, if any. 
   :ReturnType:
         ?string


 - :Method:
         setIconIdentifier(?string $iconIdentifier)
   :Description:
         Set / Overwrite the current icon identifier, or remove the identifier (by setting `null`). 
   :ReturnType:
         void


 - :Method:
         getOverlayIdentifier()
   :Description:
         Get the currently set overlay identifier, if any. 
   :ReturnType:
         ?string


 - :Method:
         setOverlayIdentifier(?string $overlayIdentifier)
   :Description:
         Set / Overwrite the current overlay identifier, or remove the identifier (by setting `null`). 
   :ReturnType:
         void

