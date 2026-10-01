..  include:: /Includes.rst.txt
..  index:: Backend modules; ModuleInterface
..  _backend-module-interface:

=================
`ModuleInterface`
=================

The registered backend modules are stored as objects in a registry and can be
fetched using the :php:`\TYPO3\CMS\Backend\Module\ModuleProvider`.
All module objects implement :php:`\TYPO3\CMS\Backend\Module\ModuleInterface`.

The :php:`ModuleInterface` basically provides getters for the options
defined in the module registration and provides methods for
relation handling (main modules and sub modules).

..  versionchanged:: 14.0
    :changelog: feature-107663-1760110062

    Method :php:`getDependsOnSubmodules()` was added to the
    :php-short:`\TYPO3\CMS\Backend\Module\ModuleInterface`.

..  versionchanged:: 14.0
    :changelog: breaking-107712-1760548718

    Method :php:`hasSubmoduleOverview()` was added to the
    :php-short:`\TYPO3\CMS\Backend\Module\ModuleInterface`.

..  contents:: Table of contents

..  _backend-module-interface-moduleinterface-api:

`ModuleInterface` API
=====================

..  include:: /CodeSnippets/Manual/Backend/ModuleInterface.rst.txt
