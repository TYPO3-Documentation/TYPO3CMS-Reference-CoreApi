.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt





.. _javascript:

JavaScript in TYPO3
===================

Some thid-party JavaScript libraries are packaged with the TYPO3 source code.
The TYPO3 backend itself relies on quite a lot of JavaScript to do its job.
The topic of this chapter is to present how to use JavaScript properly
with TYPO3, in particular in the backend. It presents the most important
APIs in that regard.

.. warning::

   Since TYPO3 4.4, the TYPO3 backend relies primarily on ExtJS. As of TYPO3 6.0,
   jQuery was introduced in the new Extension Manager and is the library of choice
   for the future. Since TYPO3 7.4, Prototype and Scriptaculous are not packed with the Core
   anymore. If you need them for your projects, you need to take care of shipping them
   yourself, preferable by usage of requireJs.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Ajax/Index
   UsingExtjs/Index
