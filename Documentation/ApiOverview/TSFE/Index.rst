.. include:: /Includes.rst.txt
.. index:: TSFE; TypoScriptFrontendController
.. _tsfe:

====
TSFE
====

.. todo::

    There are still several public properties / methods in TSFE. Unclear if
    usage should be generally discouraged or only where marked as @internal /
    protected.

What is TSFE?
=============

TSFE is short for :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`,
a class which exists in the system extension EXT:frontend.

As the name implies: A responsibility of TSFE
is page rendering. It also handles reading from and writing to the page cache.
For more details it is best to look in the source code.

There are several contexts in which the term TSFE is used:

1.  PHP: It is passed as request attribute
    :ref:`frontend.controller <typo3-request-attribute-frontend-controller>`
2.  PHP: It was and is available as global array :php:`$GLOBALS['TSFE']` in PHP.
3.  TypoScript: TypoScript function :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`
    which can be used to access public properties in TSFE.
4.  (deprecated since v9.5 and :doc:`removed in 10.0
    <ext_core:Changelog/10.0/Breaking-88564-PageTSconfigSettingTSFEconstantsRemoved>`)
    Page TSconfig: :typoscript:`TSFE.constants`.

Focusing on the PHP part (as the TypoScript part is covered in the
:ref:`TypoScript Reference: TSFE <t3tsref:data-type-gettext-tsfe>` page),
this page gives an overview, what can still be used, what is deprecated,
removed or discouraged and in which way the TSFE class itself may be
interesting to developers.

Accessing TSFE
===============

.. attention::

    Some of the former public properties and methods have been changed to
    protected or marked as internal. Often, accessing TSFE is no longer
    necessary, and there are better alternatives.

    Directly access :php:`$GLOBALS['TSFE']` only as a last resort. It is
    strongly discouraged if not absolutely necessary.

From the source:

    When calling a Frontend page, an instance of this object is available
    as :php:`$GLOBALS['TSFE']`, even though the core development strives to get
    rid of this in the future.

If access to the
:php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` instance is
necessary, use the request attribute
:ref:`frontend.controller <typo3-request-attribute-frontend-controller>`:

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');

:php:`$GLOBALS['TSFE']` is not available in all contexts. In particular, it is
only available in frontend contexts, not in the backend or cli.

Initializing :php:`$GLOBALS['TSFE']` in the Backend is sometimes done in code
examples found online. This is not recommended. TSFE is not initialized in the
backend context by the core (and there is usually no need to do this).

From the PHP documentation:

    As of PHP 8.1.0, $GLOBALS is now a read-only copy of the global symbol table.
    That is, global variables cannot be modified via its copy.

https://www.php.net/manual/en/reserved.variables.globals.php

Howtos
======

.. add howtos for common use cases, remove the not recommended, deprecated
.. way if there is a better way

Following are some examples which use TSFE and alternatives to using TSFE,
where available:

-------------

Access the :php:`ContentObjectRenderer` (often referred to as "cObj"):

.. code-block:: php

    $GLOBALS['TSFE']->cObj

Can be done as follows in Extbase controllers:

.. code-block:: php

    $contentObj = $this->configurationManager->getContentObject();

-------------

Access the current page id:

.. code-block:: php

    $GLOBALS['TSFE']->id

Can be done using the ContentObjectRenderer (see previous example):

.. code-block:: php

    $pageId = $contentObj->data['pid'];

-------------

In order to get current language settings, such as the current language id,
obtain :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` object from the
:ref:`request attribute <request-attributes>` 'language':

.. code-block:: php

    // TYPO3\CMS\Core\Site\Entity\SiteLanguage object.
    $language = $request->getAttribute('language');
    $languageId = $language->getLanguageId();


If the request is not available, accessing language settings
can be done using the :ref:`language aspect <context_api_aspects_language>`.

Get the language of the current page as integer:

.. code-block:: php

    $languageId = (int) $context->getPropertyFromAspect('language', 'id');

--------------

Accessing information about Frontend users. Accessing
:php:`$GLOBALS['TSFE']->fe_user` directly is discouraged.

.. code-block:: php

    // not recommended, use alternatives if possible
    // TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
    $feUser = $GLOBALS['TSFE']->fe_user;

Using :ref:`request-attributes`:

.. code-block:: php

    // TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
    $frontendUser = $request->getAttribute('frontend.user');

Some information via frontend and backend users con be obtained via the
:ref:`user aspect <context_api_aspects_user>`. For example:

.. code-block:: php

    // return whether a frontend user is logged in
    $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

------------------

To get the base URL of the current site (or other site configuration), use site
configuration:

.. code-block:: php

    // TYPO3\CMS\Core\Site\Entity\Site
    $site = $request->getAttribute('site');
    // array
    $siteConfiguration = $site->getConfiguration();
    $baseUrl = $siteConfiguration['base'];

To get the site by page id:

.. code-block:: php

    // TYPO3\CMS\Core\Site\SiteFinder object (e.g. was injected by DI)
    // TYPO3\CMS\Core\Site\Entity\Site
    $site = $this->siteFinder->getSiteByPageId($pageId);

.. seealso::

    :ref:`Site <typo3-request-attribute-site>`

Hooks and events
================

.. todo::

    Add overview of hooks and events that are dispatched / called in TSFE

Properties and functions
========================

.. todo::
    here some still used properties and functions can be listed and explained,
    e.g. fe_user, id etc.


Deprecated functionality (PHP)
==============================

.. todo::

    This entire section can be removed in future versions.

.. note::

    In general, it is advised to check the code of your version and use an
    IDE or tools which show the @internal status.

The following properties / methods in :php:`TypoScriptFrontendController` were
deprecated, have been set to protected, :php:`@internal` or no longer exist.
If something is set to :php:`@internal` it is meant to only be used by the
TYPO3 core. Also, the internal method or property may disappear or be changed
without further notice (no deprecations) in the future.

acquireLock()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

$ATagParams
    calls of :php:`$GLOBALS['TSFE']->ATagParams` can be
    replaced with :php:`$GLOBALS['TSFE']->config['config']['ATagParams'] ?? ''`.

    *   :doc:`ext_core:Changelog/11.5/Deprecation-95219-TypoScriptFrontendController-ATagParams` (11.5)

addTempContentHttpHeaders()
    is now incorporated within
    :php:`TSFE->processOutput().` This function should be used, or rather add
    custom headers to a PSR-15 Response object if available.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

$baseUrl
    In TypoScript you can access the TypoScript properties directly via
    :typoscript:`.data = TSFE:config|config|fileTarget` and in PHP code via
    :php:`$GLOBALS['TSFE']->config['config']['intTarget']`.
    Additionally, the TypoScript option
    :typoscript:`config.baseURL` has been deprecated.

    *   :doc:`ext_core:Changelog/12.0/Deprecation-97866-VariousPublicTSFEProperties` (12.0)
    *   :doc:`ext_core:Changelog/12.1/Deprecation-99170-ConfigbaseURLAndBaseTagFunctionality` (12.1)

baseUrlWrap()
    is obsolete and has been deprecated. Use the site configuration with
    fully-qualified domain names to achieve the same result, as rendering a
    <base> tag in HTML will not be supported out-of-the-box anymore by TYPO3 v13.

    *   :doc:`ext_core:Changelog/12.1/Deprecation-99170-ConfigbaseURLAndBaseTagFunctionality` (12.1)

clearPageCacheContent()
    is :php:`@internal`.

clearPageCacheContent_pidList()
    changed from public to protected.

    *   :doc:`ext_core:Changelog/9.5/Deprecation-86047-TSFEPropertiesMethodsAndChangeVisibility` (9.5)

$extTarget
    in TypoScript you can access the TypoScript properties directly via
    :typoscript:`.data = TSFE:config|config|extTarget` and in PHP code via
    :php:`$GLOBALS['TSFE']->config['config']['extTarget']`.

    *   :doc:`ext_core:Changelog/12.0/Deprecation-97866-VariousPublicTSFEProperties` (12.0)


$fileTarget
    in TypoScript you can access the TypoScript properties directly via
    :typoscript:`.data = TSFE:config|config|fileTarget` and in PHP code via
    :php:`$GLOBALS['TSFE']->config['config']['fileTarget']`.

    *   :doc:`ext_core:Changelog/12.0/Deprecation-97866-VariousPublicTSFEProperties` (12.0)

getConfigArray()
    was removed.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

getFromCache()
    is :php:`@internal`.

getFromCache_queryRow()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

getHash()
    was removed.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

getLockHash()
    was removed.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

getRedirectUriForMountPoint()
    is :php:`@internal`.

getRedirectUriForShortcut()
    is :php:`@internal`.

hook_eofe()
    Use a PSR-15 middleware instead.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

initFEuser()
    use a PSR-15 middleware instead.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

$intTarget
    in TypoScript you can access the TypoScript properties directly via
    :typoscript:`.data = TSFE:config|config|intTarget` and in PHP code via
    :php:`$GLOBALS['TSFE']->config['config']['intTarget']`.

    *   :doc:`ext_core:Changelog/12.0/Deprecation-97866-VariousPublicTSFEProperties` (12.0)

makeCacheHash
    Ensure to use the PSR-15 middleware stack with the
    PageArgumentValidator in use to verify a given cHash signature against given
    query parameters.

    *   :doc:`ext_core:Changelog/9.5/Deprecation-86411-TSFE-makeCacheHash` (9.5)

$MP
    is :php:`@internal`.

MP_defaults
    has been removed.

$no_cache
    has been set to :php:`@internal`. Use the event
    :ref:`AfterCacheableContentIsGeneratedEvent <AfterCacheableContentIsGeneratedEvent>`
    and its methods :php:`isCachingEnabled()`, :php:`disableCaching()`,
    :php:`enableCaching()`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

pageContentWasLoadedFromCache()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

populatePageDataFromCache()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

previewInfo()
    Use a PSR-15 middleware instead.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

releaseLock()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

setContentType()
    is :php:`@internal`.

sendCacheHeaders()
    is now incorporated within :php:`TSFE->processOutput().`
    This function should be used, or rather add custom headers to a PSR-15 Response object if available.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

$spamProtectEmailAddresses
    in TypoScript you can access the TypoScript properties directly via
    :typoscript:`.data = TSFE:config|config|fileTarget` and in PHP code via
    :php:`$GLOBALS['TSFE']->config['config']['$spamProtectEmailAddresses']`,

    *   :doc:`ext_core:Changelog/12.0/Deprecation-97866-VariousPublicTSFEProperties` (12.0)

shouldAcquireCacheData()
    has been set to :php:`@internal`.

    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

storeSessionData()
    should be replaced with :PHP:`TSFE->fe_user->storeSessionData()`.

    *   :doc:`ext_core:Changelog/9.4/Deprecation-85878-EidUtilityAndVariousTSFEMethods` (9.4)

$sys_language_uid->id
    for example :php:`$sys_language_uid->id`,
    :php:`$sys_language_content->contentId` etc.. Use
    :ref:`Language Aspect <context_api_aspects_language>`.

$tmpl
    has been set to :php:`@internal`. The class
    :php:`TYPO3\CMS\Core\TypoScript\TemplateService` has been marked as deprecated
    in TYPO3 v12 and will be removed in v13. This class was sometimes indirectly accessed
    using :php:`TypoScriptFrontendController->tmpl` or :php:`$GLOBALS['TSFE']->tmpl`.

    *   :doc:`ext_core:Changelog/12.1/Deprecation-99020-DeprecateTypoScriptTemplateService` (12.1)
    *   :doc:`ext_core:Changelog/12.0/Breaking-97816-NewTypoScriptParserInFrontend` (12.0)

For more deprecations, please see the
`Changelog <https://docs.typo3.org/c/typo3/cms-core/main/en-us/Index.html>`__.

