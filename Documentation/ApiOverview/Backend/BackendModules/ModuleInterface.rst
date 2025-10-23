.. include:: /Includes.rst.txt
.. index:: Backend modules; ModuleInterface
.. _backend-module-interface:

===============
ModuleInterface
===============

The registered backend modules are stored as objects in a registry and can be
fetched using the :php:`\TYPO3\CMS\Backend\Module\ModuleProvider`.
All module objects implement :php:`\TYPO3\CMS\Backend\Module\ModuleInterface`.

The :php:`ModuleInterface` basically provides getters for the options
defined in the module registration and provides methods for
relation handling (main modules and sub modules).

..  versionchanged:: 14.0

    Method  :php:`getDependsOnSubmodules()` was added to the
    :php-short:`\TYPO3\CMS\Backend\Module\ModuleInterface`. See also
    `Breaking: #107663 - New method getDependsOnSubmodules() required <https://docs.typo3.org/permalink/changelog:breaking-107663-1760110062>`_.

..  contents:: Table of contents

ModuleInterface API
===================

..  include:: /CodeSnippets/Manual/Backend/ModuleInterface.rst.txt
