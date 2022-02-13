.. include:: /Includes.rst.txt
.. index:: Backend modules; ModuleInterface
.. _backend-module-interface:

===============
ModuleInterface
===============


The registered backend modules are stored as objects in a registry.
The module objects do all implement the :php:`ModuleInterface`.
This allows a well-defined OOP-based approach to work with registered models.

The :php:`ModuleInterface` basically provides getters for the options,
defined in the module registration and additionally provides methods for
relation handling (main modules and sub modules).

.. include:: /CodeSnippets/Manual/Backend/ModuleInterface.rst.txt
