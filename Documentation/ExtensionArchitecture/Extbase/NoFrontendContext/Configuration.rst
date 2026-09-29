:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  index:: Extbase; Configuration outside the frontend
..  _extbase-no-frontend-configuration:

================================================
Reading configuration outside a frontend request
================================================

Extbase settings are only available while Extbase dispatches a plugin or a
backend module, see :ref:`Accessing settings outside a controller
<extbase-configuration-settings-outside-controller>`. Code that runs anywhere
else reads its configuration from a source that exists in its context.

..  _extbase-no-frontend-configuration-frontend-typoscript:

Frontend TypoScript outside the frontend
========================================

In backend contexts (such as backend modules, CLI commands, or scheduler tasks),
frontend TypoScript is either not loaded or behaves unpredictably. Backend
requests lack an active frontend user session and page context, while handling
record visibility flags such as :sql:`starttime`, :sql:`endtime`,
:sql:`hidden`, and workspace overlays differently. Attempting to evaluate
frontend TypoScript in the backend triggers unnecessary overhead and leads to
unreliable results.

..  _extbase-no-frontend-configuration-site-settings:

Global configuration: use site settings
=======================================

If a configuration value does not belong to a specific content element or
plugin instance, but applies globally to a site or extension (for example, API
keys, external endpoint URLs, or global defaults), Extbase TypoScript settings
are usually not the best place for it.

Instead, use :ref:`site settings <sitehandling-settings>`. Site settings can be
retrieved in any service, middleware, or console command using the
:php-short:`\TYPO3\CMS\Core\Site\Entity\Site` object:

..  code-block:: php
    :caption: Reading a site setting

    $apiKey = $site->getSettings()->get('myExtension.apiKey');

The site object can be obtained from the PSR-7 request
(:php:`$request->getAttribute('site')`) or by injecting
:php-short:`\TYPO3\CMS\Core\Site\SiteFinder`. See
:ref:`Accessing site settings in PHP and Fluid <sitehandling-settings-access>`
for details.

This requires knowing which site to load. In a frontend request the site has
already been resolved. Without one, :php-short:`\TYPO3\CMS\Core\Site\SiteFinder`
needs a site identifier or a page uid to find the site. When neither is known,
or when a value is the same for every site, other sources fit better:

*   TypoScript remains a valid place for such values. Without the Extbase
    configuration manager, it can be read in a frontend request through the
    :ref:`frontend.typoscript request attribute
    <typo3-request-attribute-frontend-typoscript>`, once the frontend has
    prepared it. :php:`getFlatSettings()` returns the TypoScript constants
    and is always available there. :php:`getSetupArray()` returns the setup,
    but throws an exception on a page delivered from the page cache. Outside a
    frontend request, TypoScript is not built for the request.
*   The extension configuration needs no request, no site and no page, see
    :ref:`Installation-wide configuration: use extension configuration
    <extbase-no-frontend-configuration-extension-configuration>`.

..  _extbase-no-frontend-configuration-extension-configuration:

Installation-wide configuration: use extension configuration
============================================================

A value that is the same for every site, or that is needed where no site is
known, belongs in the :ref:`extension configuration <extension-options>`.
:php:`\TYPO3\CMS\Core\Configuration\ExtensionConfiguration` reads it without a
request, a site or a page:

..  code-block:: php
    :caption: Reading an extension configuration value

    $newRecordPid = (int)$extensionConfiguration->get('my_extension', 'newRecordPid');

Administrators set these values in :guilabel:`System > Settings`. The
conferences backend module uses one for the page it creates new records on,
see :ref:`Creating records from an Extbase backend module
<extbase-backend-module-editing-new>`.
