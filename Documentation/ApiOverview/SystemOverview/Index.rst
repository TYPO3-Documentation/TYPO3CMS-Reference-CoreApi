..  include:: /Includes.rst.txt

.. _system-overview:
.. _overview:

===============
System Overview
===============

The TYPO3 system is multi-layered. The backend and frontend user interfaces
sit on top of the application layer, which in turn sits on top of the infrastructure
layer. The webserver, database and PHP in the infrastructure layer are
prerequisites for running TYPO3.

The TYPO3 Core primarily consists of an API (Application Programming Interface),
which defines a framework for managing content in the project. The API
includes functionality for content storage, user permissions and access, content
editing, and file management. This functionality is delivered via system
**extensions** that use the API. All of the content is stored in a database
that TYPO3 accesses via the API.

Extensions are clearly defined parcels of code, such as plugins, backend
modules, application logic, skins, and third-party apps.

The most important thing to note is that the TYPO3 CMS consists solely
of extensions. The most basic functions are packaged in a system extension called
"core".

.. figure:: /Images/Graphics/Typo3CmsStructure.svg
   :alt: TYPO3 System layers diagram
   :class: with-border
   :width: 800px

   Diagram showing the layers of the TYPO3 system

.. _system-overview-application:

Application layer
=================

The TYPO3 Core framework interacts with system and 3rd party extensions via
the TYPO3 extension API.

The core and extensions interact with each other seamlessly and operate as a
single, unified system.

.. _system-overview-ui:

User interface layer
====================

The backend is the **content-creation** side. It is an administrative area
where you can manage content and configuration based on the extensions that are
installed.

The frontend is the **content-delivery** side. Typically a website, it is the
meeting point for templates, CSS, content, and logic from extensions,
delivering your project to the world.
The frontend doesn't have to be a website, it can be a native mobile
application, a web application built in a frontend framework, or an API to
interface with other systems.
