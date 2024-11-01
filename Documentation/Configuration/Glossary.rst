.. include:: /Includes.rst.txt

.. _configuration-glossary:
.. _configuration-classification:

========
Glossary
========

This page explains how some terms are used but is also an attempt
to classify the various configuration methods.

Configuration vs settings
=========================

While sometimes the terms are used interchangeably and this is
not an exact definition, a general rule of thumb is:

configuration:
   Is used mostly to describe configuration that is initialized once
   using configuration files and cannot be changed on the fly in the
   backend.

settings:
   Are options that can be modified in the backend, mostly in
   :guilabel:`Admin Tools > Settings`



Syntax vs method
================

We refer to a configuration language, that only defines the syntax as
**configuration syntax** or *configuration language*.

When we refer to semantics, where the values are stored, the scope etc.
we use the term **configuration method**. Thus, the *configuration
language* is part of the *configuration method*.

This differentiation is important to make because there is often
confusion about the term TypoScript: TypoScript can be used to
describe the TypoScript syntax, but it can also be used to describe
TypoScript templating, which can be considered a configuration method.
TypoScript syntax is used in both TypoScript templating and TSconfig.


.. _classification-config-methods:

Configuration methods
=====================

In TYPO3 there are several ways to configure the system, depending on
what is to be configured, where the values are stored and how and
where they can be changed.

"Configuration methods" is not a generally used term. We use it in
this chapter to differentiate between "configuration syntax" (as explained above),
which only defines the syntax and the "configuration method". For each
type of configuration method, the following may differ:

* The used **configuration syntax** or configuration language
* **Schema** (data types, default values, what settings are required, ...)
* What do these variables mean, how will they be interpreted?
* Where the values are stored (**persistence**): In a configuration file,
  the database, etc.
* Who can change the values (**privileges**), e.g. only a system
  maintainer or admin in the TYPO3 backend.
* To what the values apply (**scope**). Are they global or do they only
  apply to certain extension, page, plugin, users or usergroups?

An example for a TYPO3 specific configuration methods is TSconfig. This
uses the TypoScript syntax. The values can be
changed in the backend only by admins or in extensions.


.. _classification-syntax:
.. _configuration-syntax:

Configuration syntax
====================

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

Without defining what are correct keys, values and data types, we
have no idea about the meaning (**semantics**) of the file and cannot interpret
it. We (or rather the TYPO3 Core ) have no idea, what `foo` (in the example
above) means, whether
it is a valid assignment, what data type can be used as value etc. We can only
check whether the syntax is correct.


These are the main languages TYPO3 uses for configuration:

* :ref:`TypoScript syntax <t3tsref:typoscript-syntax>` is used for TypoScript
  and TSconfig.
* :ref:`TypoScript constant syntax <t3tsref:typoscript-syntax-constant-editor>` is
  used for Extension Configuration and for defining constants for TypoScript.
* :ref:`Yaml <yaml-syntax>` is the configuration language of choice for newer TYPO3 system extensions
  like rte_ckeditor, form and the sites module. It has partly replaced TypoScript
  and TSconfig as configuration languages.
* XML is used to define a schema for FlexForms.
* PHP is used for the :php:`$GLOBALS` array which includes TCA
  (:php:`$GLOBALS['TCA']`), Global Configuration (:php:`GLOBALS['TYPO3_CONF_VARS']`),
  etc.

.. tip::

   The term **TypoScript** is used to both define the pure syntax TypoScript
   and the configuration method TypoScript. These are different things. To avoid
   confusion, we will use the term "TypoScript syntax" and "TypoScript configuration
   method", at least in this chapter.

Configuration definition
========================

A configuration definition or schema can be used to define what may be configured:

* What are allowed variables and datatypes?
* What are the default values?

So, for example in the example above we would define that there is a variable
'foo' with a datatype string and a default value might be an empty string.

There are specific languages for defining a schema to be applied, for example
for XML, this might be DTD or XML schema. For YAML and JSON there is for example
a schema validator `Kwalify <http://www.kuwata-lab.com/kwalify/>`__ which uses
YAML as language for the schema.

If you use a schema to define the configuration, this often has the additional
advantage, that configuration can be validated with that schema.

TYPO3 does not use an explicit schema for most configuration methods. Often,
the parsing and validation is done in the PHP source.

Examples for using a configuration definition file in TYPO3:

* TypoScript constant syntax is used to define Extension Configuration in the
  file :file:`ext_conf_template.txt` of an extension.
* Flexforms are defined using XML in an extension.
