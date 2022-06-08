.. include:: /Includes.rst.txt
.. index:: Backend modules; TypoScript
.. _backend-module-typoscript:

====================================
TypoScript configuration of modules
====================================

The backend module of an extension can be configured via TypoScript.
The configuration is done in
:typoscript:`module.tx_<lowercaseextensionname>_<lowercasepluginname>`.
:typoscript:`_<lowercasepluginname>` can be omitted then the setting is used
for all backend modules of that extension.

Even though we are in the backend context here we use TypoScript setup. The
settings should be done globally and not changed on a per-page basis.
Therefore they are usually done in the file
:ref:`EXT:my_extension/ext_typoscript_setup.typoscript <ext_typoscript_setup_typoscript>`.

See the :ref:`toplevel object "module" <t3tsref:tlo-module>` in the
TypoScript reference for the available options.

