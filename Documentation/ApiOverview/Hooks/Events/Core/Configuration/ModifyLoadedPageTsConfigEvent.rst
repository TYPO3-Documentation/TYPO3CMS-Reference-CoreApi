.. include:: /Includes.rst.txt


.. _ModifyLoadedPageTsConfigEvent:


=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify Page TSConfig entries that can be overridden or added, based on the root line.


API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getTsConfig()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

addTsConfig(string $tsConfig)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

setTsConfig(array $tsConfig)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getRootLine()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

