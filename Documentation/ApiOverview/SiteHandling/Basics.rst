:navigation-title: Basics
..  include:: /Includes.rst.txt
..  index::
    Site handling; Basics
    Module; Site management
..  _sitehandling-basics:

====================
Site handling basics
====================

TYPO3 site handling and configuration is the starting point for creating new
websites. The corresponding modules are found in the TYPO3 backend in the
section :guilabel:`Site Management`.

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
in the backend module :guilabel:`Sites`.

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingSiteModule.rst.txt

..  hint::
    While the editing mask for a site looks like a "normal" TYPO3 editing form,
    it is not. In contrast to other forms, the site configuration is stored in
    the file system and not in database tables.


..  index::
    Site handling; Directory
    Path; <project-root>/config/sites
    Path; typo3conf/sites
..  _site-storage:

Site configuration storage
==========================

When creating a new site configuration, a folder is created in the file system,
located at :file:`<project-root>/config/sites/<identifier>/`. The site
configuration is stored in a file called :file:`config.yaml <site-config-yaml>`.

..  note::
    If you are using a Classic mode installation, the location is
    :file:`typo3conf/sites/config.yaml`.

..  tip::
    Add this folder to your version control system.


..  index:: Site handling; File
..  _site-configuration-file:

The configuration file
======================

The following part explains the configuration file and options:

..  literalinclude:: _basics-config.yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

Most settings can also be edited via the :guilabel:`Site Management > Sites`
backend module, except for custom settings and additional routing configuration.


..  index:: Site handling; Site identifier
..  _sitehandling-basics-site-identifier:

Site identifier
---------------

The site identifier is the name of the folder in
:file:`<project-root>/config/sites/` that contains your configuration file(s).
When choosing an identifier, be sure to use ASCII, but you may also use `-`, `_`
and `.` for convenience.


Root page ID
------------

Root pages are identified by one of these two properties:

*   They are direct descendants of PID 0 (the root root page of TYPO3).
*   They have the :guilabel:`Use as Root Page` property in :sql:`pages` set to
    true.

..  note::
    The same root page ID **should not** be used in multiple site configurations.
    This may lead to misbehavior, since always the last defined site with this
    root page ID is used by TYPO3. The :guilabel:`Sites` module warns you if the
    same root page ID is used multiple times.


..  _sitehandling-basics-websiteTitle:

websiteTitle
------------

The title of the website which is used in :html:`<title>` tag in the frontend.


..  _sitehandling-basics-base:

base
----

The base is the base domain on which a website runs. It accepts either a
fully qualified URL or a relative segment "/" to react to any domain name.
It is possible to set a site base prefix to :samp:`/site1`, :samp:`/site2`
or even :samp:`example.com` instead of entering a full URI.

This allows a site base as :samp:`example.com` with http and https protocols to
be detected, although it is recommended to redirect HTTP to HTTPS, either at the
webserver level, via a :file:`.htaccess` rewrite rule or by adding a redirect
in TYPO3.

Please note: when the domain is an `Internationalized Domain Name (IDN)`_
containing non-Latin characters, the base must be provided in an
ASCII-Compatible Encoded (ACE) format (also known as "`Punycode`_"). You can use
a `converter`_ to get the ACE format of the domain name.

..  _Internationalized Domain Name (IDN): https://en.wikipedia.org/wiki/Internationalized_domain_name
..  _Punycode: https://en.wikipedia.org/wiki/Punycode
..  _converter: https://www.punycoder.com/

..  note::
    This flexibility introduces side effects if you have multiple sites with
    mixed configuration settings as site base:

    *   Site 1: `/mysite/`
    *   Site 2: `example.com`

    It is unspecific when a URL like :samp:`example.com/mysite/` is detected,
    and can lead to side effects.

    In this case, the site administrator must set unique site base prefixes.


..  _sitehandling-basics-languages:

languages
---------

Available languages for a site can be specified here. These settings determine
both the availability of the language and the behavior. For a detailed
description see :ref:`Language configuration <sitehandling-addingLanguages>`.


..  _sitehandling-basics-errorHandling:

errorHandling
-------------

The error handling section describes how to handle error status codes for this
website. It allows you to configure custom redirects, rendering templates, and
more. For a detailed description, see :ref:`error handling
<sitehandling-errorHandling>`.


..  _sitehandling-basics-routes:

routes
------

The routes section is used to add static routes to a site, for example a
:file:`robots.txt` or :file:`humans.txt` file that depends on the current site
(an does not contain the same content for the whole TYPO3 installation).
Read more at :ref:`static routes<sitehandling-staticRoutes>`.


..  _sitehandling-basics-routeEnhancers:

routeEnhancers
--------------

..  todo: Add some more documentation here from the changelog?

While page routing works out of the box without any further settings, route
enhancers allow configuring routing for TYPO3 extensions. Read more at
:ref:`routing-advanced-routing-configuration`.


..  _sitehandling-basics-settings:

settings
--------

The `settings` section can be used to define custom site settings. These values
are available in PHP code, TypoScript and Fluid templates. For further details,
see :ref:`sitehandling-settings`.

..  note::
    If a folder contains a `settings.yaml` file, all `settings` defined in
    `config.yaml` are ignored. Only the values from `settings.yaml` are
    applied.

    When you or your customer manage site settings via the *Site Settings* module
    in the TYPO3 backend, TYPO3 automatically creates (or updates) the
    `settings.yaml` file. As a result, the configuration in `config.yaml` is
    no longer considered.

    To avoid confusion, it is recommended to **remove** the obsolete `settings`
    section from `config.yaml` if `settings.yaml` is in use.


..  _sitehandling-basics-imports:

imports
-------

The imports section can be used to import additional YAML files into the site
configuration. This can be used to split large configurations into smaller
parts or to share common configuration parts between multiple sites. The path
is relative to the site configuration folder.

..  code-block:: yaml
    :caption: EXT:site_package/Configuration/Sets/SitePackage/config.yaml

    imports:
      - { resource: 'RouteEnhancers.yaml' }
