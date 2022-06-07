.. include:: /Includes.rst.txt
.. index:: Backend modules; TypoScript
.. _backend-module-typoscript:

====================================
TypoScript configuration of modules
====================================

The backend module of an extension can be configured via TypoScript.
The configuration is done in
:typoscript:`module.tx_<lowercaseextensionname>_<lowercasepluginname>`.
:typoscript:`_<lowercasepluginname>` can be ommited then the setting is used
for all backend modules of that extension.

Even though we are in the backend context here we use TypoScript setup. The
settings should be done globally and not changed on a per-page basis.
Therefore they are usually done in the file
:ref:`EXT:my_extension/ext_typoscript_setup.typoscript <ext_typoscript_setup_typoscript>`.


Options for simple backend modules
===================================

In simple backend modules extension authors can decide how to use this
namespace. By convention settings should go in the subsection
:typoscript:`settings`.

.. code-block:: typoscript
   :caption: EXT:my_extension/ext_typoscript_setup.typoscript

   module.tx_myextension_somemodule {
       settings {
           enablesomething = 1
       }
   }

Options for Extbase backend modules
===================================

Most configuration options that can be done for Extbase frontend plugins
can also be done for Extbase backend modules.


