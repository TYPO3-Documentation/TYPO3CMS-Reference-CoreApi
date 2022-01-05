.. index:: $GLOBALS; TBE_MODULES
.. _backend-modules-api-tbemodules:

=======================
View registered modules
=======================

When modules are registered, they get added to a global array called
:php:`$GLOBALS['TBE_MODULES']`. It contains the list of all registered
modules, their configuration and the configuration of any existing
navigation component (the components which may be loaded into the
navigation frame).

:php:`$GLOBALS['TBE_MODULES']` can be explored using the
:guilabel:`System > Configuration` module.

.. include:: /Images/AutomaticScreenshots/BackendModules/BackendModulesConfiguration.rst.txt

The list of modules is parsed by the class :php:`\TYPO3\CMS\Backend\Module\ModuleLoader`.
