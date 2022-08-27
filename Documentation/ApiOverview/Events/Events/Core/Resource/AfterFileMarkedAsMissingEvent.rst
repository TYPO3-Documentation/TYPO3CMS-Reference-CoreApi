.. include:: /Includes.rst.txt
.. index:: Events; AfterFileMarkedAsMissingEvent
.. _AfterFileMarkedAsMissingEvent:


=============================
AfterFileMarkedAsMissingEvent
=============================

This event is fired once a file was just marked as missing in the database (sys_file).

*Example*: If a file is marked as missing, listeners can try to recover a file. This can happen on specific setups
where editors also work via FTP.

API
---

.. include:: /CodeSnippets/Events/Core/Resource/AfterFileMarkedAsMissingEvent.rst.txt
