.. include:: ../../Includes.txt


.. _config-overview:

======================
Configuration Overview
======================

A primary feature of TYPO3 is its configurability. Not only can
it be configured by users with special user privileges in the backend,
most configuration can also be changed by extensions or
configuration files. Additionally, configuration can be extended by
extensions.

This chapter will give you an overview of various configuration
methods in TYPO3. We will not go into detail, but rather show
a comparison of the various methods and resolve some common
sources of confusion.

For a more extensive introduction we will refer you to the
respective chapter or reference.

Terminology
===========

To differentiate between different configuration languages we use the
terms syntax and semantics:

**Syntax** describes common rules for a language (e.g. how are lines terminated,
how are values assigned, what are separators, etc.) while semantics define the meaning.

For example, using only the basic syntax of yaml, this is a syntactically
correct snippet:

.. code-block:: yaml

   foo: bar


Most of the configuration languages used in TYPO3 basically assign values to
variables in one way another. In its simplest form, these can be simple
string assignments as in the yaml example, which may result in assigning
the value 'bar' to a variable `foo`.

The assignment in TypoScript syntax would look like this:

.. code-block:: typoscript

   foo = bar


However, without defining what are correct keys, values and data types, we
have no idea about the meaning (**semantics**) of the file and cannot interpret
it. We (or rather the TYPO3 core) have no idea, what `foo` means, whether
it is a valid assignment, what data type can be used as value etc. We can only
check whether the syntax is correct.

For this reason, we don't just need a language with a predefined syntax (like
XML, JSON, Yaml).

We also need to define the configuration schema: What are allowed variables
and datatypes? What are the default values? What settings are mandatory and
which are optional? And we define the semantics: What do these variables mean,
how will they be interpreted? Additionally, we must define where the
values are stored, who can change the values (privileges)
and to what the values apply (scope). Are they global or do they only
apply to certain pages, users or usergroups?

We refer to a configuration language, that only defines the syntax as
**configuration syntax**. When we refer to semantics, where the values
are stored, the scope etc. we use the term **configuration method**.

Configuration Syntax
====================

These are the main languages TYPO3 uses for configuration:

* :ref:`TypoScript syntax <typoscript-syntax-start>` is used for TypoScript
  and TSconfig.
* :ref:`TypoScript constant syntax <t3tsref:typoscript-syntax-constant-editor>` is
  used for Extension Configuration and for defining constants for TypoScript.
* Yaml is the configuration language of choice for newer TYPO3 system extensions
  like rte_ckeditor, form and the sites module. It has partly replaced TypoScript
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


Main Configuration Methods
==========================

These are the main configuration methods used by TYPO3:

The :php:`$GLOBALS` array consists:

* :ref:`Global Configuration <typo3ConfVars>` :php:`$GLOBALS['TYPO3_CONF_VARS']`
  is used for system wide configuration. A subset of this is
  :ref:`Extension Configuration <extension-options>`
  (:php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']`). It is used for
  configuration specific to one extension.
* :ref:`TCA <t3tca:introduction>` :php:`GLOBALS['TCA']` is specific to
  database fields and how they behave and can be edited in the backend.
* :ref:`User settings <user-settings>` :php:`$GLOBALS['TYPO3_USER_SETTINGS']`
  defines configuration for backend users
* ... you can find more in the TYPO3 backend :guilabel:`SYSTEM > Configuration`
  or by viewing the :php:`$GLOBALS` array in a debugger. Read more about this
  on :ref:`globals-variables`.


Furthermore, we have:

* :ref:`TSconfig <tsconfig>` is used to configure and **customize the backend** on a page (page TSconfig)
  and a user or group basis (user TSconfig).
* :ref:`TypoScript configuration method <t3tsref:introduction>` is used to
  configure plugins (FE) and modules (BE), as well as some
  global settings (config). It is also used to define the rendering, but that is
  beyond the scope of this page, which focuses only on configuration. TypoScript
  is mostly used for configuration that affects the Frontend (FE).
* :ref:`Flexform <flexforms>` is used to configure plugins and content elements.


Additionally, some system extensions use yaml for configuration:

* :ref:`Site <sitehandling>` configuration is stored in :file:`<project-root>/config/sites/<identifier>/config.yaml`
  and can be configured in the sites module.
* :ref:`form <sysextform:concepts-configuration>`
* :ref:`rte_ckeditor <sysextckedit:configuration>`

