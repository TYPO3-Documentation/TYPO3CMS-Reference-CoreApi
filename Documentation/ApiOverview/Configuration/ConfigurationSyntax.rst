
.. include:: ../../Includes.txt

.. _configuration-syntax:

====================
Configuration Syntax
====================

These are the main languages TYPO3 uses for configuration:

* :ref:`TypoScript syntax <typoscript-syntax-start>` is used for TypoScript
  and TSconfig.
* :ref:`TypoScript constant syntax <t3tsref:typoscript-syntax-constant-editor>` is
  used for Extension Configuration and for defining constants for TypoScript.
* Yaml is the configuration language of choice for newer TYPO3 system extensions
  like rte_ckeditor and form. It has partly replaced TypoScript
  and TSconfig as configuration languages.
* XML is used in FlexForms.
* PHP is used for the :php:`$GLOBALS` array which includes TCA
  (:php:`$GLOBALS['TCA']`, Global Configuration (:php:`GLOBALS['TYPO3_CONF_VARS']`),
  User Settings (:php:`$GLOBALS['TYPO3_USER_SETTINGS']`, etc.

What is most important here, is that TypoScript has its own syntax. And the
TypoScript syntax is used for the configuration methods **TypoScript and TSconfig**.
The syntax for both is the same, while the semantics (what variables can be used and
what they mean) are not.

.. tip::

   Hence, the term **TypoScript** is used to both define the pure syntax TypoScript
   and the configuration method TypoScript. These are different things. To avoid
   confusion, we will use the term "TypoScript syntax" and "TypoScript configuration
   method", at least on this page.

.. toctree::
   :maxdepth: 1

   ../TypoScriptSyntax/Index
