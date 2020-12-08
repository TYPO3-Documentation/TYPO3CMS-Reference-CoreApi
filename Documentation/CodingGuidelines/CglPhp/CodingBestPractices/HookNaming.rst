.. include:: /Includes.rst.txt
.. index:: Coding guidelines; Hooks

.. _cgl-hook-naming:

===========
Hook Naming
===========

When introducing new hooks in TYPO3 the naming of the registration arrays shall follow this schema::

   // assign array of callables or Foo:class->function
   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['<topic>']['<hook name>'] = [];


Note that '<topic>' shall be an abstract thing like 'link' or 'url' and should not reflect the class or file the hook
is currently implemented in. This should prevent irritation when hooks are moved around in the code.
