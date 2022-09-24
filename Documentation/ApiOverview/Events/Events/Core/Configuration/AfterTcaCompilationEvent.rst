.. include:: /Includes.rst.txt
.. index:: Events; AfterTcaCompilationEvent
.. _AfterTcaCompilationEvent:

========================
AfterTcaCompilationEvent
========================

Event after `$GLOBALS['TCA']` is built to allow to further manipulate the TCA.

.. note::

   Side note: It is possible to check against the original TCA as this is stored within $GLOBALS['TCA']
   before this event is fired.

API
===

.. include:: /CodeSnippets/Events/Core/AfterTcaCompilationEvent.rst.txt
