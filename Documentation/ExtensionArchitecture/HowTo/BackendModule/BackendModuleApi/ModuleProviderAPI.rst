.. include:: /Includes.rst.txt
.. index:: Backend modules; ModuleProvider
.. _backend-module-provider-api:

===================
ModuleProvider API
===================

The :php:`ModuleProvider` API, allows extension authors to work with the
registered modules.

This API is the central point to retrieve modules, since it
automatically performs necessary access checks and prepares specific structures,
for example for the use in menus.

.. include:: /CodeSnippets/Manual/Backend/ModuleProvider.rst.txt
