.. include:: ../../Includes.txt

.. _sitehandling-basics:

Basics
======

.. note::
   Site Handling as described here is available since TYPO3 9 LTS.

TYPO3 Site Handling and Configuration is the starting point for creating new web sites. The corresponding modules are found in the TYPO3 backend
in the section "Site Management".

A site configuration consists of the following parts:

* Base URL configuration: Under which domain(s) is my site accessible
* :ref:`Language configuration<sitehandling-addingLanguages>`: Which languages are available for my site
* :ref:`Error Handling<sitehandling-errorHandling>`: How should errors for this site behave (For example: configure custom 404 pages)
* :ref:`Static Routes<sitehandling-staticRoutes>`: Add static routes to a site (For example for robots.txt on a per site base)
* Routing Configuration: How shall routing behave for this site

Most parts of the site configuration can be edited via the graphical interface in the backend module "Site".

.. figure:: ../../Images/SiteHandlingSiteModule.png
   :class: with-shadow
   :alt: Site Module

   The Site module in the TYPO3 backend.

.. hint::
   While the editing mask for a site looks like a "normal" TYPO3 editing form, it is not. In contrast to
   other forms, site configuration is stored in the file system and not in database tables.


Site configuration storage
--------------------------

When creating a new site configuration, a folder in the file system is created located at
:file:`<project-root>/config/sites/<identifier>/`. The site configuration is stored in a
file called `config.yaml`.

.. note::
    If you are using a non-composer based installation, the location is `typo3conf/sites/`.
    In the future this folder can (and should) be used for more files like Fluid templates, and Backend layouts.

.. hint::
    Add this folder to your version control. 


The configuration file
----------------------

The following part explains the configuration file and options:

.. code-block:: yaml

  rootPageId: 12
  base: 'https://www.example.com/'
  languages:
    -
      languageId: '0'
      title: English
      navigationTitle: ''
      base: /
      locale: en_US.UTF-8
      iso-639-1: en
      hreflang: en-US
      direction: ltr
      typo3Language: default
      flag: gb
    -
      languageId: '1'
      title: 'danish'
      navigationTitle: Dansk
      base: /da/
      locale: dk_DK.UTF-8
      iso-639-1: da
      hreflang: dk-DK
      direction: ltr
      typo3Language: default
      flag: dk
      fallbackType: strict
    -
      languageId: '2'
      title: Deutsch
      navigationTitle: ''
      base: 'https://www.beispiel.de/'
      locale: de_DE.UTF-8
      iso-639-1: de
      hreflang: de-DE
      direction: ltr
      typo3Language: de
      flag: de
      fallbackType: fallback
      fallbacks: '2,1,0'
  errorHandling:
    -
      errorCode: '404'
      errorHandler: Page
      errorContentSource: 't3://page?uid=8'
    -
      errorCode: '403'
      errorHandler: Fluid
      errorFluidTemplate: 'EXT:my_extension/Resources/Private/Templates/ErrorPages/403.html'
      errorFluidTemplatesRootPath: 'EXT:my_extension/Resources/Private/Templates/ErrorPages'
      errorFluidLayoutsRootPath: 'EXT:my_extension/Resources/Private/Layouts/ErrorPages'
      errorFluidPartialsRootPath: 'EXT:my_extension/Resources/Private/Partials/ErrorPages'
    -
      errorCode: '0'
      errorHandler: PHP
      errorPhpClassFQCN: Vendor\ExtensionName\ErrorHandlers\GenericErrorhandler
  routes:
    route: robots.txt
    type: staticText
    content: |
        Sitemap: https://example.com/sitemap.xml
        User-agent: *
        Allow: /
        Disallow: /forbidden/

Most settings can also be edited via the backend module `Site Management > Configuration`,
exceptions being custom settings and additional routing configuration.


site identifier
^^^^^^^^^^^^^^^

The site identifier is the name of the folder within `<project-root>/config/sites/` that will hold your configuration file(s). When
choosing an identifier make sure to stick to ASCII but you may also use `-`, `_` and `.` for convenience.


rootPageId
^^^^^^^^^^

Root pages are identified by one of these two properties:

* they are direct descendants of PID 0 (the root root page of TYPO3)
* they have the "Use as Root Page" property in `pages` set to true.

base
^^^^

The base is the base domain to run a site on. It either accepts a fully qualified URL or a relative segment "/" to react to any domain name.
It is possible to set a site base prefix to just "/site1" and "/site2" or "www.mydomain.com" instead of entering a full URI.

This allows to have a Site base e.g. www.mydomain.com to be detected with http and https protocols, although it is recommended to do a HTTP to 
HTTPS redirect either on the webserver level, via a .htaccess rewrite rule, or by adding a redirect in TYPO3.

.. note::
  Please note that this flexibility will introduce side-effects when having multiple sites with mixed configuration settings as Site base:

  + Site 1: /mysite/
  + Site 2: www.mydomain.com

  will be unspecific when detecting a URL like www.mydomain/mysite/ and can lead to side-effects.

  In this case, it is necessary by the Site Administrator to define unique Site base prefixes.

languages
^^^^^^^^^

Available languages for a site can be specified here. These settings determine language avaialability as well as behavior. For a detailed 
description see  :ref:`Language configuration<sitehandling-addingLanguages>`.

errorHandling
^^^^^^^^^^^^^

The error handling section describes how to handle error status codes for this web site. It allows configuration of custom redirects, 
rendering templates and more. For a detailed description see :ref:`error handling<sitehandling-errorHandling>`.

routes
^^^^^^

The routes section is for adding static routes to a site, an example would be a :file:`robots.txt` or :file:`humans.txt` file that is 
dependent on the current site (as opposed to containing the same content for the whole TYPO3 installation). Read more at 
:ref:`static routes<sitehandling-staticRoutes>`

routeEnhancers
^^^^^^^^^^^^^^

While page routing works out of the box with no further settings, routeEnhancers allow the configuration of routing for TYPO3 extensions. 
