.. include:: /Includes.rst.txt
.. index:: Events; GetVersionedDataEvent
.. _GetVersionedDataEvent:


=====================
GetVersionedDataEvent
=====================

Used in the workspaces module to find all data of versions of a workspace.
In comparison to AfterDataGeneratedForWorkspaceEvent, this one contains the
cleaned / prepared data with an optional limit applied depending on the view.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getGridService()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Workspaces\Service\GridDataService`
   :sep:`|`

   |nbsp|

getData()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setData(array $data)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getDataArrayPart()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setDataArrayPart(array $dataArrayPart)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getStart()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getLimit()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

