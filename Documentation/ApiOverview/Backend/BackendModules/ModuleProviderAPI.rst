:navigation-title: ModuleProvider

..  include:: /Includes.rst.txt
..  index:: Backend modules; ModuleProvider
.. _backend-module-provider:

==============
ModuleProvider
==============

The :php:`ModuleProvider` API allows extension authors to work with the
registered modules.

This API is the central point to retrieve modules, since it
automatically performs necessary access checks and prepares specific structures,
for example for the use in menus.

..  _backend-module-provider-api:

ModuleProvider API
==================

.. include:: /CodeSnippets/Manual/Backend/ModuleProvider.rst.txt
