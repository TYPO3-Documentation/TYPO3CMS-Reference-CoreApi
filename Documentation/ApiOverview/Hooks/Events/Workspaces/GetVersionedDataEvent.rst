.. include:: ../../../../Includes.txt


.. _GetVersionedDataEvent:


=====================
GetVersionedDataEvent
=====================

Used in the workspaces module to find all data of versions of a workspace.
In comparison to AfterDataGeneratedForWorkspaceEvent, this one contains the
cleaned / prepared data with an optional limit applied depending on the view.

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
         getDataArrayPart()
   :Description:
         Returns currently relevant (with applied limit) part of the data array.
   :ReturnType:
         array


 - :Method:
         setDataArrayPart(array $dataArrayPart)
   :Description:
         Set / overwrite currently relevant (with applied limit) part of the data array.
   :ReturnType:
         void


 - :Method:
         getStart()
   :Description:
         Returns current start index.
   :ReturnType:
         int


 - :Method:
         getLimit()
   :Description:
         Returns current limit / maximum number of data sets.
   :ReturnType:
         int

