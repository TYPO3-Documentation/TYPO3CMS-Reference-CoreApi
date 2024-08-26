.. include:: /Includes.rst.txt
.. _ServicesYaml:
.. index::
   File; EXT:{extkey}/Configuration/Services.yaml
   Services.yaml
   Configuration; Services.yaml

=============
Services.yaml
=============

Services can be configured in this file. TYPO3 uses it for:

*  :ref:`Dependency Injection <configure-dependency-injection-in-extensions>`
*  :ref:`Event Listeners <EventDispatcherRegistration>`
*  Command Controllers (see :doc:`Feature: #89139 - Add dependency injection support for console commands <ext_core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands>`)
*  :ref:`Registering a widget with the dashboard <ext_dashboard:register-new-widget>`

A typical :file:`Configuration/Services.yaml` may look like this:

..  literalinclude:: _example_services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

.. seealso::

   * TYPO3 uses the Symfony Dependency Injection component. The official documentation can be found at
     https://symfony.com/doc/current/service_container.html

   * The technology used for inluding files and folders is called `Glob Patterns <https://www.malikbrowne.com/blog/a-beginners-guide-glob-patterns/>`__. 
