

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Using third-party JavaScript libraries in the TYPO3 Backend
-----------------------------------------------------------

Since TYPO3 4.3, it is very easy to use third-party JavaScript
libraries in the TYPO3 BE. A simple API is provided by template class
(which all modules use). Third-party JS libraries are those which are
available in the "typo3/contrib" folder. Note that use of
Prototype/Scriptaculous is now discouraged. Use ExtJS instead.
Prototype/Scriptaculous support may be removed in future versions of
TYPO3.

Inside a module, the instance of template.php is normally available as

::

   $this->doc


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   UsingPrototype/Index
   UsingScriptaculous/Index
   UsingExtjs/Index

