..  include:: /Includes.rst.txt
..  index::
    Request handling; request object
    $GLOBALS; TYPO3_REQUEST
..  _typo3-request:

====================
TYPO3 request object
====================

The TYPO3 request object is an implementation of the PSR-7 based
`\Psr\Http\Message\ServerRequestInterface` containing TYPO3-specific attributes.

The request object is passed to controllers. The attributes can be retrieved via

..  code-block:: php

    // Get all available attributes
    $allAttributes = $request->getAttributes();

    // Get only a specific attribute
    $site = $request->getAttribute('site');

The request object is also available as a global variable in
:php:`$GLOBALS['TYPO3_REQUEST']`. This is a workaround for the Core which has to
access the server parameters at places where :php:`$request` is not available.
So, while this object is globally available during any HTTP request, it is
considered bad practice to use this global object, if the request is accessible
in another, official way. The global object is scheduled to vanish at a later
point once the code has been refactored enough to not rely on it anymore.


..  todo:
    Add information on how to retrieve the request object from different
    scenarios (Extbase controller, data processor, USER function, backend
    controller, etc, and global variable as last resort).


Following is a list of attributes available in frontend context:

..  contents::
    :depth: 1
    :local:


..  todo:
    Add information about attributes in backend context.


..  index::
    Request attribute; Application type
..  _typo3-request-attribute-application-type:

Application type
================

The :php:`applicationType` attribute helps to answer the question: "Is this a
frontend or backend request?".

`1`
    It is a frontend request.
`2`
    It is a backend request.


..  index::
    Request attribute; Frontend controller
..  _typo3-request-attribute-frontend-controller:

Frontend controller
===================

The :php:`frontend.controller` attribute provides access to the
:php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` object.

..  important::
    In former TYPO3 versions you have to retrieve the
    :php:`TypoScriptFrontendController` via the global variable
    :php:`$GLOBALS['TSFE']`. This should be avoided now, instead use the request
    attribute.

Example:

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');
    $rootline = $frontendController->rootline;


..  index::
    Request attribute; Frontend user
..  _typo3-request-attribute-frontend-user:

Frontend user
=============

The :php:`frontend.user` attribute provides the
:php:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication` object.

Example:

..  code-block:: php

    $frontendUser = $request->getAttribute('frontend.user');
    $groupData = $frontendUser->fetchGroupData($request);


..  index::
    Request attribute; Language
..  _typo3-request-attribute-language:

Language
========

The :php:`language` attribute provides information about the current language
of the webpage via the :php:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` object.

Example:

..  code-block:: php

    $language = $request->getAttribute('language');
    $locale = $language->getLocale();


..  todo:
    Add API as code snippet.


..  index::
    Request attribute; Normalized parameters
..  _typo3-request-attribute-normalizedParams:

Normalized parameters
=====================

The :php:`normalizedParams` attribute provide access to server parameters, for
instance, if the TYPO3 installation is behind a reverse proxy.

..  important::
    The normalized parameters substitute
    :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv()`.

One can retrieve the normalized parameters like this:

..  code-block:: php

    /** @var \TYPO3\CMS\Core\Http\NormalizedParams $normalizedParams */
    $normalizedParams = $request->getAttribute('normalizedParams');
    $requestPort = $normalizedParams->getRequestPort();


..  index:: Request handling; Migration from getIndpEnv

Migrating from :php:`GeneralUtility::getIndpEnv()`
--------------------------------------------------

The class :php:`\TYPO3\CMS\Core\Http\NormalizedParams` is a one-to-one transition
of :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv()`, the old
arguments can be substituted with these calls:

-   :php:`SCRIPT_NAME` is now :php:`->getScriptName()`
-   :php:`SCRIPT_FILENAME` is now :php:`->getScriptFilename()`
-   :php:`REQUEST_URI` is now :php:`->getRequestUri()`
-   :php:`TYPO3_REV_PROXY` is now :php:`->isBehindReverseProxy()`
-   :php:`REMOTE_ADDR` is now :php:`->getRemoteAddress()`
-   :php:`HTTP_HOST` is now :php:`->getHttpHost()`
-   :php:`TYPO3_DOCUMENT_ROOT` is now :php:`->getDocumentRoot()`
-   :php:`TYPO3_HOST_ONLY` is now :php:`->getRequestHostOnly()`
-   :php:`TYPO3_PORT` is now :php:`->getRequestPort()`
-   :php:`TYPO3_REQUEST_HOST` is now :php:`->getRequestHost()`
-   :php:`TYPO3_REQUEST_URL` is now :php:`->getRequestUrl()`
-   :php:`TYPO3_REQUEST_SCRIPT` is now :php:`->getRequestScript()`
-   :php:`TYPO3_REQUEST_DIR` is now :php:`->getRequestDir()`
-   :php:`TYPO3_SITE_URL` is now :php:`->getSiteUrl()`
-   :php:`TYPO3_SITE_PATH` is now :php:`->getSitePath()`
-   :php:`TYPO3_SITE_SCRIPT` is now :php:`->getSiteScript()`
-   :php:`TYPO3_SSL` is now :php:`->isHttps()`

Some further old :php:`getIndpEnv()` arguments directly access :php:`$request->serverParams()` and do not apply any
normalization. These have been transferred to the new class, too, but will be deprecated later if the Core does not use
them anymore:

-   :php:`PATH_INFO` is now :php:`->getPathInfo()`, but better use
    :php:`->getScriptName()` instead
-   :php:`HTTP_REFERER` is now :php:`->getHttpReferer()`, but better use
    :php:`$request->getServerParams()['HTTP_REFERER']` instead
-   :php:`HTTP_USER_AGENT` is now :php:`->getHttpUserAgent()`, but better use
    :php:`$request->getServerParams()['HTTP_USER_AGENT']` instead
-   :php:`HTTP_ACCEPT_ENCODING` is now :php:`->getHttpAcceptEncoding()`, but
    better use :php:`$request->getServerParams()['HTTP_ACCEPT_ENCODING']` instead
-   :php:`HTTP_ACCEPT_LANGUAGE` is now :php:`->getHttpAcceptLanguage()`, but
    better use :php:`$request->getServerParams()['HTTP_ACCEPT_LANGUAGE']` instead
-   :php:`REMOTE_HOST` is now :php:`->getRemoteHost()`, but better use
    :php:`$request->getServerParams()['REMOTE_HOST']` instead
-   :php:`QUERY_STRING` is now :php:`->getQueryString()`, but better use
    :php:`$request->getServerParams()['QUERY_STRING']` instead


..  index::
    Request attribute; Routing
..  _typo3-request-attribute-routing:

Routing
=======

The :php:`routing` attribute provides routing information in the object
:php:`\TYPO3\CMS\Core\Routing\PageArguments`. If you want to know the current
page ID or retrieve the query parameters this attribute is your friend.

Example:

..  code-block:: php

    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();


..  todo::
    Add API as code snippet.


..  index::
    Request attribute; Site
..  _typo3-request-attribute-site:

Site
====

The :php:`site` attribute hold information about the current site in the
object :php:`\TYPO3\CMS\Core\Site\Entity\Site`.

Example:

..  code-block:: php

    $site = $request->getAttribute('site');
    $siteConfiguration = $site->getConfiguration();

..  todo::
    Add API as code snippet.
