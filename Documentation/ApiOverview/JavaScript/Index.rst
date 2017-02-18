.. include:: ../../Includes.txt





.. _javascript:

JavaScript in TYPO3
===================

Some thid-party JavaScript libraries are packaged with the TYPO3 source code.
The TYPO3 backend itself relies on quite a lot of JavaScript to do its job.
The topic of this chapter is to present how to use JavaScript properly
with TYPO3, in particular in the backend. It presents the most important
APIs in that regard.

.. attention::

   Since TYPO3 7, the TYPO3 backend relies primarily on bootstrap and jQuery.
   Since TYPO3 7.4, Prototype and Scriptaculous are not packed with the Core
   anymore. If you need them for your projects, you need to take care of shipping them
   yourself, preferable by usage of RequireJS.
   Since TYPO3 8, ExtJS will be removed step by step, the most parts are now
   ExtJS free and replaces with mostly pure JavaScript components.


**Contents:**

.. toctree::

   Ajax/Index
   RequireJS/Index
