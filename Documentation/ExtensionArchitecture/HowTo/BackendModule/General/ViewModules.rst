.. include:: /Includes.rst.txt

.. index:: $GLOBALS; TBE_MODULES
.. _backend-modules-api-tbemodules:

=======================
View registered modules
=======================

All registered modules are stored as objects in a registry. They can be viewed
in the backend in the :guilabel:`System > Configuration > Backend Modules`
module.

.. include:: /Images/AutomaticScreenshots/BackendModules/BackendModulesConfiguration.rst.txt

The list of modules is parsed by the class :php:`\TYPO3\CMS\Backend\Module\ModuleLoader`.
