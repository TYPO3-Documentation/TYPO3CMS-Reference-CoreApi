.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/Services.yaml
   Path; EXT:{extkey}/Configuration/Services.yaml
.. _extension-configuration-services-yaml:

================================
:file:`Services.yaml`
================================

Services can be configured in this file. TYPO3 uses it for:

*  :ref:`Dependency Injection <configure-dependency-injection-in-extensions>`
*  :ref:`Event Listeners <EventDispatcherRegistration>`
*  Command Controllers (see :doc:`Feature: #89139 - Add dependency injection
   support for console commands <ext_core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands>`)
*  :ref:`Registering a widget with the dashboard <ext_dashboard:register-new-widget>`


.. include:: /CodeSnippets/Manual/Extension/Configuration/ServicesYaml.rst.txt
