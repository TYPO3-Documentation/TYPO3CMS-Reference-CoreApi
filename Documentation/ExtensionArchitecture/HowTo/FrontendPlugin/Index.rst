.. include:: /Includes.rst.txt
.. index::
   pair: Extension development; Frontend plugin

.. _frontend_plugin:

===============
Frontend plugin
===============

There are different technology choices to create frontend plugins in TYPO3.

For pure output it is often sufficient to use a
:ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` in combination with
:ref:`DataProcessors <t3tsref:dataProcessing>`. See also
:ref:`Creating a custom content element <adding-your-own-content-elements>`.

For scenarios with user input and or complicated data operations consider
using :ref:`Extbase <extbase>`.

It is also possible to create a frontend plugin using Core functionality only.

..  todo: Document how to create a frontend plugin without Extbase.
