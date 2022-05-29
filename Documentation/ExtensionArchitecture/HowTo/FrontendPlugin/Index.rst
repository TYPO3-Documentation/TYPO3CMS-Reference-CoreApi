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

Legacy frontend plugins without Extbase, so called "pi-based plugins" are based
on the :ref:`AbstractPlugin <abstractplugin>`. It is not recommended anymore
to use the AbstractPlugin as base for new frontend plugins. The Core does not
use it anymore and only few third party extensions still use it.

.. toctree::
   :titlesonly:
   :glob:

   *
