..  include:: /Includes.rst.txt

..  index::
    Request attribute; Normalized parameters
..  _typo3-request-attribute-normalizedParams:

=====================
Normalized parameters
=====================

The :php:`normalizedParams` request attribute provide access to server
parameters, for instance, if the TYPO3 installation is behind a reverse proxy.
It is available in frontend and backend context.

..  important::
    The normalized parameters substitute
    :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv()`. See the
    :ref:`migration guide <GeneralUtility-getIndpEnv-migration>` below.

One can retrieve the normalized parameters like this:

..  code-block:: php

    /** @var \TYPO3\CMS\Core\Http\NormalizedParams $normalizedParams */
    $normalizedParams = $request->getAttribute('normalizedParams');
    $requestPort = $normalizedParams->getRequestPort();


API
===

..  include:: /CodeSnippets/Manual/Entity/NormalizedParams.rst.txt


..  index:: Request handling; Migration from getIndpEnv
..  _GeneralUtility-getIndpEnv-migration:

Migrating from :php:`GeneralUtility::getIndpEnv()`
==================================================

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
