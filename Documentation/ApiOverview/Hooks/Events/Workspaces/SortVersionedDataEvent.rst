.. include:: ../../../../../Includes.txt


.. _SortVersionedDataEvent:


======================
SortVersionedDataEvent
======================

Used in the workspaces module after sorting all data for versions of a workspace.

API
---


 - :Method:
         getGridService()
   :Description:
         Returns the current instance of the GridDataService.
   :ReturnType:
         \TYPO3\CMS\Workspaces\Service\GridDataService


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
         getSortColumn()
   :Description:
         Get column to sort by.
   :ReturnType:
         string


 - :Method:
         setSortColumn(string $sortColumn)
   :Description:
         Set / Overwrite column to sort by.
   :ReturnType:
         string


 - :Method:
         getSortDirection()
   :Description:
         Get the current sorting direction (ASC | DESC)
   :ReturnType:
         string


 - :Method:
         setSortDirection(string $sortDirection)
   :Description:
         Set the current sorting direction (ASC | DESC)
   :ReturnType:
         void

