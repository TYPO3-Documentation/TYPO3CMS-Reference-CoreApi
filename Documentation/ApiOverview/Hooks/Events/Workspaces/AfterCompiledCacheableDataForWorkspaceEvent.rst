.. include:: ../../../../Includes.txt


.. _AfterCompiledCacheableDataForWorkspaceEvent:


===========================================
AfterCompiledCacheableDataForWorkspaceEvent
===========================================

Used in the workspaces module to find all chacheable data of versions of a workspace.

API
---


 - :Method:
         getGridService()
   :Description:
         Returns the current instance of the GridDataService.
   :ReturnType:
         `\TYPO3\CMS\Workspaces\Service\GridDataService`


 - :Method:
         getData()
   :Description:
         Returns the cacheable data of versions.
   :ReturnType:
         array


 - :Method:
         setData(array $data)
   :Description:
         Set / Overwrite the cacheable data of versions.
   :ReturnType:
         void


 - :Method:
         getVersions()
   :Description:
         Returns versions.
   :ReturnType:
         array


 - :Method:
         setVersions(array $versions)
   :Description:
         Set / overwrite workspace versions.
   :ReturnType:
         void

