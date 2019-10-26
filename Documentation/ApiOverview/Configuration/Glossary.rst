.. include:: ../../Includes.txt

.. _configuration-glossary:

===========
Glossary
===========

To differentiate between different configuration languages we use the
terms syntax and semantics:

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

Configuration methods
=====================

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

