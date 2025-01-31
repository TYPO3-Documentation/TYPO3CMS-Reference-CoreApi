.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/Services.yaml
   Path; EXT:{extkey}/Configuration/Services.yaml
.. _extension-configuration-services-yaml:

===============
`Services.yaml`
===============

It is possible to use a YAML or PHP format:

..  typo3:file:: Services.yaml
    :scope: extension
    :path: /Configuration/
    :regex: /^.*\/Configuration\/Services\.yaml/
    :shortDescription: Dependency injection service configuration

..  typo3:file:: Services.php
    :scope: extension
    :path: /Configuration/
    :regex: /^.*\/Configuration\/Services\.php/
    :shortDescription: Dependency injection service configuration

Services can be configured in this file. TYPO3 uses it for:

*  :ref:`Dependency Injection <configure-dependency-injection-in-extensions>`
*  :ref:`Event Listeners <EventDispatcherRegistration>`
*  Command Controllers (see :doc:`Feature: #89139 - Add dependency injection
   support for console commands <ext_core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands>`)
*  :ref:`Registering a widget with the dashboard <ext_dashboard:register-new-widget>`

..  literalinclude:: /Configuration/Yaml/_example_services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml
