.. include:: /Includes.rst.txt
.. index:: Events; AfterTcaCompilationEvent
.. _AfterTcaCompilationEvent:

========================
AfterTcaCompilationEvent
========================

Event after `$GLOBALS['TCA']` is built to allow to further manipulate the `TCA`:pn:.

.. note::

   Side note: It is possible to check against the original `TCA`:pn: as this is stored within $GLOBALS['TCA']
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


