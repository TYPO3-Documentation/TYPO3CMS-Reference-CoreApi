.. include:: /Includes.rst.txt
.. index:: pair: Site handling; PHP
.. _sitehandling-php-api:

=====================================
PHP API: accessing site configuration
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

Accessing the current site object
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
    The first method is preferred if possible as :php:`$GLOBALS['TYPO3_REQUEST']` was
    deprecated in 9.2 and will be removed in future versions.

Methods::

    // current site
    $site = $request->getAttribute('site');

    // current site language
    $siteLanguage = $request->getAttribute('language');


.. warning::
    The `PSR-7` Request and the extbase request are different things. You cannot
    access the site configuration via the extbase request. When in extbase context
    use the global access - a better way will be introduced in future versions.


.. index:: pair: Site handling; SiteFinder

Finding a site object
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


.. index:: pair: Site handling; Site object

The Site object
===============

Now we know how to find a :php:`Site` object, but what can it do?

First of all, it gives us access to the site configuration options via

- :php:`getConfiguration()`: returns the complete configuration
- :php:`getAttribute()`: returns a specific configuration attribute (root level configuration only)

It additionally provides methods for accessing related objects (languages / errorHandling):

- :php:`getErrorHandler()`: returns a :php:`PageErrorHandler` according to the site configuration
- :php:`getAvailableLanguages()`: returns languages available to a user (including access checks)
- :php:`getLanguageById()`: returns a site language object for a language id
- ...

Take a look at the class to find out more: :php:`\TYPO3\CMS\Core\Site\Entity\Site`


.. index:: pair: Site handling; SiteLanguage object

The SiteLanguage object
=======================

The :php:`SiteLanguage` object is basically a simple model that represents the configuration options of
the site regarding language as an object and provides getters for those properties.

See :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage`
