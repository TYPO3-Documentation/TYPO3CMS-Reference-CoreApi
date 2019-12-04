.. include:: ../../../../../Includes.txt


.. _ModifyLoadedPageTsConfigEvent:


=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify Page TSConfig entries that can be overridden or added, based on the root line.


API
---


 - :Method:
         getTsConfig()
   :Description:
         Returns current Page TSConfig
   :ReturnType:
         array


 - :Method:
         addTsConfig(string $tsConfig)
   :Description:
         Add additional TSConfig (appending).
   :ReturnType:
         void


 - :Method:
         setTsConfig(array $tsConfig)
   :Description:
         Overwrite / Set TSConfig.
   :ReturnType:
         void


 - :Method:
         getRootLine()
   :Description:
         Get the current root line.
   :ReturnType:
         array

