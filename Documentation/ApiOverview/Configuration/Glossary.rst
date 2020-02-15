.. include:: ../../Includes.txt

.. _configuration-glossary:

===========
Glossary
===========

We refer to a configuration language, that only defines the syntax as
**configuration syntax**. When we refer to semantics, where the values
are stored, the scope etc. we use the term **configuration method**.


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

Examples for TYPO3 specific syntax languages are:

* TypoScript syntax

Examples for general syntax languages are:

* XML, YAML

Syntax vs semantics
===================

Without defining what are correct keys, values and data types, we
have no idea about the meaning (**semantics**) of the file and cannot interpret
it. We (or rather the TYPO3 core) have no idea, what `foo` (in the example
above) means, whether
it is a valid assignment, what data type can be used as value etc. We can only
check whether the syntax is correct.


Configuration schema
====================

A configuration schema can be used to define what may be configured:

* What are allowed variables and datatypes?
* What are the default values?


So, for example in the example above we would define that there is a variable
'foo' with a datatype string and a default value might be an empty string.

There are specific languages for defining a schema to be applied, for example
for XML, this might be DTD or XML schema. For YAML and JSON there is for example
a schema validator `Kwalify <http://www.kuwata-lab.com/kwalify/>` which uses
YAML as language for the schema.

If you use a schema to define the configuration, this often has the additional
advantage, that configuration can be validated with that schema.

TYPO3 does not use an explicit schema for all configuration methods. Often,
the parsing and validation is done in the PHP source.

Examples for schema in TYPO3:

* Global configuration (LocalConfiguration.php, TYPO3_CONF_VARS) is defined in
  :file:`typo3/sysext/core/Configuration/DefaultConfigurationDescription.yaml`.
  The default values are in :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
  Here, a YAML file (in combination with a PHP file) is used to define the configuration,
  which is set in PHP (as PHP array).
* TypoScript constant syntax is used to define Extension Configuration.

Examples for general schemas:

* XML schema, DTD, Relax NG for XML
* Kwalify for JSON, YAML
* RDFS for RDF

.. seealso::

   * `Overview: Schema Language on ScienceDirect <https://www.sciencedirect.com/topics/computer-science/schema-language>`__

Configuration methods
=====================

"Configuration methods" is not a generally used term. We use it in this chapter
to differentiate between "configuration syntax" (as explained above),
which only defines the syntax and the "configuration method", which
consist of:

* The used **syntax** language
* **Schema** (data types, default values, what settings are required, ...)
* What do these variables mean, how will they be interpreted?
* Where the values are stored (**persistence**): In a configuration file,
  the database, etc.
* Who can change the values (**privileges**)
* To what the values apply (**scope**). Are they global or do they only
  apply to certain extension, page, plugin, users or usergroups?

Examples for TYPO3 specific configuration methods are:

* TSconfig (using the TypoScript syntax)
* TCA (configured in PHP)


