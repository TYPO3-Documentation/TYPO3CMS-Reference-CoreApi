.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _examples:

Various examples
----------------

This chapter presents some examples of how you can use the APIs
of Core libraries. They are not meant to be exhaustive,
ultimately the source code is the best documentation.
These examples are here to get you started.

The Core itself along with its many system extensions provide
another whole lot of examples.


.. _examples-debug:

Debugging
^^^^^^^^^

Before diving into the topic here are a few hints about debugging in TYPO3 CMS.

The TYPO3 Core provides a simple :code:`debug()` (defined in
:file:`EXT:core/Classes/Core/GlobalDebugFunctions.php`). It wraps around
:code:`\TYPO3\CMS\Core\Utility\DebugUtility::debug()` and will output debug
information only if it matches a set of IP addresses (defined in
:code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']`).

For example, the following code::

   debug($_COOKIE, 'cookie');


will produce such an output:

.. figure:: ../../Images/DebugOutput.png
   :alt: Debug output

   Typical TYPO3 debug output


.. tip::

   The :code:`debug()` function allows for adding your own debugging object.
   Put an instance of your class in :code:`$GLOBALS['error']` and its :code:`debug()`
   method, receiving the same parameters as the original :code:`debug()` function.

In general, look at class :code:`\TYPO3\CMS\Core\Utility\DebugUtility` for useful
debugging tools.


.. _examples-examples:

Examples
^^^^^^^^

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PageTrees/Index
   Clipboard/Index
   ContextualMenu/Index
   ParsingHtml/Index
   EditLinks/Index
   TablesInPageModule/Index
   ContentElementWizard/Index
   CustomPermissions/Index


