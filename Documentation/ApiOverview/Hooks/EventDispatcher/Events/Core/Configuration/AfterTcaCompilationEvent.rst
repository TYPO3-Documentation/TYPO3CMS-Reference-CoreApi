.. include:: ../../../../../../Includes.txt


.. _AfterTcaCompilationEvent:


========================
AfterTcaCompilationEvent
========================

Event after $GLOBALS['TCA'] is built to allow to further manipulate $tca.

.. note:: 
   
   Side note: It is possible to check against the original TCA as this is stored within $GLOBALS['TCA'] 
   before this event is fired.

API
---


 - :Method:
         getTCA()
   :Description:
         Returns the current TCA (Table Configuration Array).
   :ReturnType:
         array


 - :Method:
         setTca(array $tca)
   :Description:
         Sets (overwrites) the TCA. 
   :ReturnType:
         void

