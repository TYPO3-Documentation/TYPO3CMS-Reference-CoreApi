.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _system-overview:
.. _overview:

System Overview
===============

The TYPO3 system is multi-layered. The backend and frontend user interfaces
sit on top of the application layer, which in turn sits on the infrastructure
layer. The webserver, database and PHP in the infrastructure layer are
prerequisites for running TYPO3.

TYPO3 Core primarily consists of the API (Application Programming Interface),
which defines a framework for managing the project content. The base features
of the API include content storage, user permissions and access, content
editing, and file management. These features are delivered via system
**extensions** that use the API. All of the content is stored in a database
that TYPO3 then accesses via the API.

Extensions are clearly confined code additions, such as plugins, backend
modules, application logic, skins, and third-party apps.

The most important thing to note is that everything is an extension in TYPO3
CMS. Even the most basic functions are packaged in a system extension called
"core".

.. figure:: /Images/ManualScreenshots/Introduction/Typo3CmsStructure.png
   :alt: TYPO3 System layers diagram
   :class: with-border

   Diagram showing the layers of the TYPO3 system


Application layer
-----------------

The TYPO3 Core framework interacts with system and 3rd party extensions via
the TYPO3 extension API.

The core and extensions interact with each other seamlessly and operate as a
single, unified system.

User interface layer
--------------------

The backend is the **content-creation** side. It is the administrative area
where you manage content and configuration based on the extensions that are
installed.

The frontend is the **content-delivery** side. Typically a website, it is the
meeting place for templates, CSS, content, and logic from extensions,
delivering your project to the world.
The frontend doesn't have to be a website, it could be a native mobile
application, a web application built in a frontend framework,  or an API to
interface with other systems.

.. _installation:

A basic installation
====================

To follow this document, it might help to have a totally trimmed down
installation of TYPO3 CMS with *only* the Core and the required system
extensions at hand.

The installation process is covered in the :ref:`Installation and Upgrade
Guide <t3install:start>`.
You should perform the basic installation steps and not install any
distribution. This will give you the "lightest" possible version of TYPO3 CMS.

In your basic installation, go to the :guilabel:`ADMIN TOOLS > Extensions`
module. You will see all the extensions that are loaded by default.
Required extensions that are loaded by default have no
"Activate/Deactivate" button.

.. figure:: /Images/ManualScreenshots/Introduction/ExtensionsMinimalList.png
   :alt: The Extension Manager with a bare bones installation
   :class: with-border

   Screenshot of the backend showing the Extensions module
