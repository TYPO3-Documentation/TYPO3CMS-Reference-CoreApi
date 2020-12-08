.. include:: /Includes.rst.txt


.. index::
   pair: Coding Guidelines; Yaml

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
* Use single (' ') for defining string values. Double quotes can be used for
  quotes inside of quotes:

.. code-block:: yaml

   description: 'This is a "salt" used for various kinds of encryption ...'


More Information
================

* See :ref:`cgl-ide` in this manual for information about setting up your Editor / IDE to adhere to
  the coding guidelines.
