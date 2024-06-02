.. include:: /Includes.rst.txt
.. index:: Backend modules; ModuleInterface
.. _backend-module-interface:

===============
ModuleInterface
===============

The registered backend modules are stored as objects in a registry and can be
fetched using the :php:class:`\TYPO3\CMS\Backend\Module\ModuleProvider`.
All module objects implement the :php:`\TYPO3\CMS\Backend\Module\ModuleInterface`.

The :php:`ModuleInterface` basically provides getters for the options
defined in the module registration and additionally provides methods for
relation handling (main modules and sub modules).

..  contents:: Table of contents

ModuleInterface API
===================

.. include:: /CodeSnippets/Manual/Backend/ModuleInterface.rst.txt

