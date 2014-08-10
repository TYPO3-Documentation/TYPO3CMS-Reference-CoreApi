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
   for the future. Although Prototype and Scriptaculous are still packed with the Core
   and used in places, they should not be used for any new stuff, nor relied upon
   in extensions.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Ajax/Index
   UsingExtjs/Index

