.. include:: /Includes.rst.txt
.. index:: ! Coding guidelines
.. _cgl:

=================
Coding Guidelines
=================

This chapter contains description of the formal requirements or standards
regarding coding that you should adhere to when you develop `TYPO3`:pn:
extensions or `Core`:pn: parts.

.. tip::

   You can find an
   `.editorconfig <https://github.com/TYPO3/TYPO3.CMS/blob/master/.editorconfig>`__
   file in the `TYPO3 Core`:pn: repository.
   `Some editors and IDEs <https://editorconfig.org/>`__ can use this
   file and the rules defined within.

Some basic rules are defined in the .editorconfig, such as the charset and
the indenting style. By default, indenting with 4 spaces is
used, but there are a few exceptions (for example for YAML or JSON
files).

For the files that are not specifically covered in the subchapters (for example
Fluid, .json, or .sql), the information in the .editorconfig file
should be sufficient.

.. toctree::
   :maxdepth: 1
   :titlesonly:

   Introduction
   CglPhp/Index
   CglJavaScript/Index
   CglTypeScript/Index
   CglTypoScript/Index
   CglTsConfig
   CglXliff/Index
   CglYaml
   CglRest/Index
