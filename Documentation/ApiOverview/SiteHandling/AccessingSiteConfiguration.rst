.. include:: ../../Includes.txt

.. _sitehandling-php-api:

=====================================
PHP API: Accessing Site Configuration
=====================================

The PHP API for Sites comes in two parts:

- Accessing the current, resolved site object
- Finding a site object / configuration via a page or identifier

The first case is relevant when we want to access site
configuration in the current request, for example if we want to
know which language is currently rendered.

The second case is about accessing site configuration options
independent of the current request but based on a page id or a
site identifier.

Let's look at both cases in detail:

Accessing the Current Site Object
=================================

When rendering the frontend or backend TYPO3 builds a HTTP request object
through a `PSR-15` middleware stack and enriches that with information.
Part of that information are the :php:`Site` and :php:`SiteLanguage` objects. Both
objects are available as attributes on the current request object.

Depending on the context, there are two main ways to access them:

* via the `PSR-7` HTTP ServerRequest object directly - for example in a PSR-15 middleware
  or the admin panel
* via :php:`$GLOBALS['TYPO3_REQUEST']` - everywhere you don't have a ServerRequest object

.. hint::
    The first method is preferred if possible as the global access will be
    deprecated and removed in future versions.

Methods::

    // current site
    $site = $request->getAttribute('site');

    // current site language
    $siteLanguage = $request->getAttribute('language');


.. warning::
    The `PSR-7` Request and the extbase request are different things. You cannot
    access the site configuration via the extbase request. When in extbase context
    use the global access - a better way will be introduced in future versions.


Finding a Site Object
=====================

When you need to access site configuration for a specific page ID or by identifier,
you can use the :php:`SiteFinder` (:php:`\TYPO3\CMS\Core\Site\SiteFinder`).

The :php:`SiteFinder` offers the following methods for finding a site:

- :php:`getSiteByIdentifier()`: returns site object for the specified identifier ("folder name")
- :php:`getSiteByRootPageId()`: returns site object for a specific root page (pid = 0 or is_siteroot set)
- :php:`getSiteByPageId()`: returns site object for a page (walks the root line to find the root page
  and returns the site configuration)
- :php:`getAllSites()`: returns all configured site objects

All methods for finding a specific site throw an exception if no site was found.


The Site Object
===============

Now we know how to find a site object, but what can it do?

First of all, it gives us access to the site configuration options via

- :php:`getConfiguration()`: returns the complete configuration
- :php:`getAttribute()`: returns a specific configuration attribute (root level configuration only)

It additionally provides methods for accessing related objects (languages / errorHandling):

- :php:`getErrorHandler()`: returns a :php:`PageErrorHandler` according to the site configuration
- :php:`getAvailableLanguages()`: returns languages available to a user (including access checks)
- :php:`getLanguageById()`: returns a site language object for a language id
- ...

Take a look at the class to find out more: :php:`\TYPO3\CMS\Core\Site\Entity\Site`


The SiteLanguage Object
=======================

The :php:`SiteLanguage` object is basically a simple model that represents the configuration options of
the site regarding language as an object and provides getters for those properties.

See :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage`


Pages Without Site Configuration
================================

The site handling functionality has a counterpart for usages within PHP code where no site configuration
can be found, which is named "Pseudo Site", a site without configuration.

For a pseudo-site it is not possible to determine all available languages (as they are only configured in TypoScript),
or the proper labels for the default language (as this is done in PageTSconfig), however, a PseudoSite or Site object
(both instances of "SiteInterface") is always attached to every Frontend or Backend request via a PSR-15 middleware.

Extension Developers can access a site and determine the base URL / Entry Point URL for a site, or access all
available languages via the SiteInterface object, instead of querying sys_domain or sys_language respectively.
