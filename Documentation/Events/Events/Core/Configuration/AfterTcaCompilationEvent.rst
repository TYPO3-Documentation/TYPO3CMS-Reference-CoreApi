.. include:: /Includes.rst.txt


.. _AfterTcaCompilationEvent:


========================
AfterTcaCompilationEvent
========================

Event after `$GLOBALS['TCA']` is built to allow to further manipulate the TCA.

.. note::

   Side note: It is possible to check against the original TCA as this is stored within $GLOBALS['TCA']
   before this event is fired.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getTca()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|


setTca(array $tca)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|


