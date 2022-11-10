..  include:: /Includes.rst.txt
..  index::
    Site handling; Basics
    Module; Site management
..  _sitehandling-basics:

======
Basics
======

TYPO3 site handling and configuration is the starting point for creating new
websites. The corresponding modules are found in the TYPO3 backend in the
section :guilabel:`Site management`.

A site configuration consists of the following parts:

*   Base URL configurations: the domain(s) to access my site.
*   :ref:`Language configuration <sitehandling-addingLanguages>`: the languages
    of my site.
*   :ref:`Error handling <sitehandling-errorHandling>`: error behavior of my
    site (for example, configuration of custom 404 pages).
*   :ref:`Static routes <sitehandling-staticRoutes>`: static routes of my site
    (for example, :file:`robots.txt` on a per site base).
*   Routing configuration: How shall routing behave for this site.

When creating a new page on root level via the TYPO3 backend, a very basic site
configuration is generated on the fly. It prevents immediate errors due to
missing configuration and can also serve as a starting point for all further
actions.

Most parts of the site configuration can be edited via the graphical interface
in the backend module :guilabel:`Site`.

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingSiteModule.rst.txt

..  hint::
    While the editing mask for a site looks like a "normal" TYPO3 editing form,
    it is not. In contrast to other forms, the site configuration is stored in
    the file system and not in database tables.


..  index::
    Site handling; Directory
    Path; <project-root>/config/sites
    Path; typo3conf/sites

Site configuration storage
==========================

When creating a new site configuration, a folder is created in the file system,
located at :file:`<project-root>/config/sites/<identifier>/`. The site
configuration is stored in a file called :file:`config.yaml`.

..  note::
    If you are using a legacy installation, the location is
    :file:`typo3conf/sites/`. In the future this folder can (and should) be used
    for more files like Fluid templates, and backend layouts.

..  hint::
    Add this folder to your version control system.


..  index:: Site handling; File

The configuration file
======================

The following part explains the configuration file and options:

..  code-block:: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

    rootPageId: 12
    base: 'https://example.org/'
    websiteTitle: Example
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
        base: 'https://example.net/'
        locale: de_DE.UTF-8
        iso-639-1: de
        hreflang: de-DE
        direction: ltr
        typo3Language: de
        flag: de
        fallbackType: fallback
        fallbacks: '1,0'
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
        Sitemap: https://example.org/sitemap.xml
        User-agent: *
        Allow: /
        Disallow: /forbidden/

Most settings can also be edited via the :guilabel:`Site Management > Sites`
backend module, except for custom settings and additional routing configuration.


..  index:: Site handling; Site identifier

Site identifier
---------------

The site identifier is the name of the folder in
:file:`<project-root>/config/sites/` that contains your configuration file(s).
When choosing an identifier, be sure to use ASCII, but you may also use `-`, `_`
and `.` for convenience.


rootPageId
----------

Root pages are identified by one of these two properties:

*   They are direct descendants of PID 0 (the root root page of TYPO3).
*   They have the :guilabel:`Use as Root Page` property in :sql:`pages` set to
    true.


websiteTitle
------------

The title of the website which is used in :html:`<title>` tag in the frontend.


base
----

The base is the base domain on which a website runs. It accepts either a
fully qualified URL or a relative segment "/" to react to any domain name.
It is possible to set a site base prefix to just :samp:`/site1`, :samp:`/site2`
or even :samp:`example.com` instead of entering a full URI.

This allows a site base as :samp:`example.com` with http and https protocols to
be detected, although it is recommended to redirect HTTP to HTTPS, either at the
webserver level, via a :file:`.htaccess` rewrite rule or by adding a redirect
in TYPO3.

..  note::
    This flexibility introduces side effects if you have multiple sites with
    mixed configuration settings as site base:

    *   Site 1: `/mysite/`
    *   Site 2: `example.com`

    It is unspecific when a URL like :samp:`example.com/mysite/` is detected,
    and can lead to side effects.

    In this case, the site administrator must set unique site base prefixes.


languages
---------

Available languages for a site can be specified here. These settings determine
both the availability of the language and the behavior. For a detailed
description see :ref:`Language configuration <sitehandling-addingLanguages>`.


errorHandling
-------------

The error handling section describes how to handle error status codes for this
website. It allows you to configure custom redirects, rendering templates, and
more. For a detailed description, see :ref:`error handling
<sitehandling-errorHandling>`.


routes
------

The routes section is used to add static routes to a site, for example a
:file:`robots.txt` or :file:`humans.txt` file that depends on the current site
(an does not contain the same content for the whole TYPO3 installation).
Read more at :ref:`static routes<sitehandling-staticRoutes>`.


routeEnhancers
--------------

..  todo: Add some more documentation here from the changelog?

While page routing works out of the box without any further settings, route
enhancers allow configuring routing for TYPO3 extensions. Read more at
:ref:`routing-advanced-routing-configuration`.
