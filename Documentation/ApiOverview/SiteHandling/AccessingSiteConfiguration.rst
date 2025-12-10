:navigation-title: PHP API
..  include:: /Includes.rst.txt
..  index:: pair: Site handling; PHP
..  _sitehandling-php-api:

=====================================
PHP API: accessing site configuration
=====================================

..  contents::
    :local:

The PHP API for sites comes in two parts:

-   Accessing the current, resolved site object
-   Finding a site object / configuration via a page or identifier

The first case is relevant when we want to access the site configuration in the
current request, for example, if we want to know which language is currently
rendered.

The second case is about accessing site configuration options independent of the
current request but based on a page ID or a site identifier.

Let us look at both cases in detail.

..  _sitehandling-php-api-access:

Accessing the current site object
=================================

When rendering the frontend or backend, TYPO3 builds an HTTP request object through
a :ref:`PSR-15 middleware stack <request-handling>` and enriches it with
information. Part of that information are the objects
:php:`\TYPO3\CMS\Core\Site\Entity\Site` and
:php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage`. Both objects are
available as :ref:`attributes <typo3-request-attributes>` in the current
:ref:`request object <typo3-request>`.

Depending on the context, there are two main ways to access them:

-   via the PSR-7 HTTP request object directly - for example in a PSR-15
    middleware, an :ref:`Extbase controller <extbase-action-controller>` or a
    :ref:`user function <t3tsref:cobj-user>`.
-   via :php:`$GLOBALS['TYPO3_REQUEST']` - everywhere you do not have a
    request object.

..  hint::
    The first method is preferred, if possible, as :php:`$GLOBALS['TYPO3_REQUEST']`
    was deprecated in TYPO3 v9.2 and will be removed in a future version.

Methods:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    // current site
    $site = $request->getAttribute('site');

    // current site language
    $siteLanguage = $request->getAttribute('language');

The :ref:`Extbase <extbase>` request class implements the
PSR-7 :php:`\Psr\Http\Message\ServerRequestInterface`. Therefore, you can
retrieve all needed attributes from the request object.

..  index:: pair: Site handling; SiteFinder
..  _sitehandling-sitefinder-object:

Finding a site object with the :php:`SiteFinder` class
======================================================

When you need to access the site configuration for a specific page ID or by a
site identifier, you can use the class :php:`\TYPO3\CMS\Core\Site\SiteFinder`.

The methods for finding a specific site throw a
:php:`\TYPO3\CMS\Core\Exception\SiteNotFoundException`, if no site was found.

API
---

..  include:: /CodeSnippets/Manual/Core/SiteFinder.rst.txt


.. index:: pair: Site handling; Site object
..  _sitehandling-site-object:

The :php:`Site` object
======================

A :php:`\TYPO3\CMS\Core\Site\Entity\Site` object gives access to the site
configuration options.

API
---

..  include:: /CodeSnippets/Manual/Entity/Site.rst.txt


.. index:: pair: Site handling; SiteLanguage object
..  _sitehandling-sitelanguage-object:

The :php:`SiteLanguage` object
==============================

The :php:`SiteLanguage` object is basically a simple model that represents the
configuration options of the site regarding language as an object and provides
getters for those properties.

API
---

..  include:: /CodeSnippets/Manual/Entity/SiteLanguage.rst.txt

..  _sitehandling-sitesetting-object:

The :php:`SiteSettings` object
==============================

..  versionadded:: 12.1

The :ref:`site settings <sitehandling-settings>` can be retrieved using the
:php:`getSettings()` method of the :ref:`Site <sitehandling-site-object>`
object, which returns a :php:`SiteSettings` object.

The object can be used to access settings either by the dot notation ("flat"),
for example:

..  code-block:: php

    $redirectStatusCodeForRedirects = (int)$siteSettings->get('redirects.httpStatusCode', 307);

or by accessing all options for a certain group:

..  code-block:: php

    $allSettingsRelatedToRedirects = $siteSettings->get('redirects');

or even fetching all settings:

..  code-block:: php

    $siteSettings->getAll();

See :ref:`<sitehandling-inTypoScript>` for other means of accessing the site settings.

API
---

..  include:: /CodeSnippets/Manual/Entity/SiteSettings.rst.txt
