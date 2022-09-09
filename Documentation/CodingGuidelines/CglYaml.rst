.. include:: /Includes.rst.txt
.. index:: pair: Coding guidelines; Yaml
.. _cgl-yaml:

======================
Yaml Coding Guidelines
======================

Yaml is (one of the languages) used for configuration in TYPO3.

Directory and File Names
========================

* Files have the ending :file:`.yaml`.

Format
======

* Use spaces, not tabs
* Indent with 2 spaces per indent level
* Favor single-quoted strings (' ') over double-quoted or multi-line strings where
  possible
* Double quoted strings should only be used when more complex escape
  characters are required.  String values with line breaks should use multi-line 
  block strings in YAML.
* The quotes on a trivial string value (a single word or similar) may be omitted.

.. code-block:: yaml

   trivial: aValue
   simple: 'This is a "salt" used for various kinds of encryption ...'
   complex: "This string has unicode escaped characters, like \x0d\x0a"
   multi: |
      This is a multi-line string.
      
      Line breaks are preserved in this value. It's good for including
      
      <em>HTML snippets</em>.

More Information
================

* See :ref:`cgl-ide` in this manual for information about setting up your Editor / IDE to adhere to
  the coding guidelines.
