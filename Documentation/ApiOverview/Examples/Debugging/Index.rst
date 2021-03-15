.. include:: /Includes.rst.txt



.. _examples-debug:

=========
Debugging
=========

Before diving into the topic here are a few hints about debugging in TYPO3 CMS.

The TYPO3 Core provides a simple :code:`debug()` (defined in
:file:`EXT:core/Classes/Core/GlobalDebugFunctions.php`). It wraps around
:code:`\TYPO3\CMS\Core\Utility\DebugUtility::debug()` and will output debug
information only if it matches a set of IP addresses (defined in
:code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']`).

For example, the following code::

   debug($_COOKIE, 'cookie');


will produce such an output:

.. figure:: ../../../Images/DebugOutput.png
   :alt: Debug output

   Typical TYPO3 debug output

In general, look at class :code:`\TYPO3\CMS\Core\Utility\DebugUtility` for useful
debugging tools.

