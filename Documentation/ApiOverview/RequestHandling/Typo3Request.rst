.. include:: /Includes.rst.txt
.. highlight:: php
.. index::
   Request handling; request object
   $GLOBALS; TYPO3_REQUEST
.. _typo3-request:

====================
TYPO3 request object
====================

The TYPO3 request object is a PSR-7 based `ServerRequest` object containing a TYPO3-specific attribute object for normalized
server parameters. These normalized parameter for instance resolve variables
if the instance is behind a reverse proxy.

.. important::

   This substitutes :php:`GeneralUtility::getIndpEnv()`.

The object is available from :php:`ServerRequestInterface $request` objects as an attribute.
The request object is passed to controllers, example:

.. code-block:: php

    /** @var NormalizedParams $normalizedParams */
    $normalizedParams = $request->getAttribute('normalizedParams');
    $requestPort = $normalizedParams->getRequestPort();


The request object is also available as a global variable in :php:`$GLOBALS['TYPO3_REQUEST']`. This is a workaround for
the core which has to access the server parameters at places where $request is not available. So, while this object is
globally available during any HTTP request, it is considered bad practice to use this global object if the request is
accessible in another, official way. The global object is scheduled to vanish at a later point once the code has been refactored
enough to not rely on it anymore.


.. index:: Request handling; Migration from getIndpEnv

Migrating from :php:`GeneralUtility::getIndpEnv()`
==================================================

Class :php:`NormalizedParams` is a one-to-one transition of :php:`GeneralUtility::getIndpEnv()`, the old
arguments can be substituted with these calls:

- :php:`SCRIPT_NAME` is now :php:`->getScriptName()`
- :php:`SCRIPT_FILENAME` is now :php:`->getScriptFilename()`
- :php:`REQUEST_URI` is now :php:`->getRequestUri()`
- :php:`TYPO3_REV_PROXY` is now :php:`->isBehindReverseProxy()`
- :php:`REMOTE_ADDR` is now :php:`->getRemoteAddress()`
- :php:`HTTP_HOST` is now :php:`->getHttpHost()`
- :php:`TYPO3_DOCUMENT_ROOT` is now :php:`->getDocumentRoot()`
- :php:`TYPO3_HOST_ONLY` is now :php:`->getRequestHostOnly()`
- :php:`TYPO3_PORT` is now :php:`->getRequestPort()`
- :php:`TYPO3_REQUEST_HOST` is now :php:`->getRequestHost()`
- :php:`TYPO3_REQUEST_URL` is now :php:`->getRequestUrl()`
- :php:`TYPO3_REQUEST_SCRIPT` is now :php:`->getRequestScript()`
- :php:`TYPO3_REQUEST_DIR` is now :php:`->getRequestDir()`
- :php:`TYPO3_SITE_URL` is now :php:`->getSiteUrl()`
- :php:`TYPO3_SITE_PATH` is now :php:`->getSitePath()`
- :php:`TYPO3_SITE_SCRIPT` is now :php:`->getSiteScript()`
- :php:`TYPO3_SSL` is now :php:`->isHttps()`

Some further old :php:`getIndpEnv()` arguments directly access :php:`$request->serverParams()` and do not apply any
normalization. These have been transferred to the new class, too, but will be deprecated later if the core does not use
them anymore:

- :php:`PATH_INFO` is now :php:`->getPathInfo()`, but better use :php:`->getScriptName()` instead
- :php:`HTTP_REFERER` is now :php:`->getHttpReferer()`, but better use :php:`$request->getServerParams()['HTTP_REFERER']` instead
- :php:`HTTP_USER_AGENT` is now :php:`->getHttpUserAgent()`, but better use :php:`$request->getServerParams()['HTTP_USER_AGENT']` instead
- :php:`HTTP_ACCEPT_ENCODING` is now :php:`->getHttpAcceptEncoding()`, but better use :php:`$request->getServerParams()['HTTP_ACCEPT_ENCODING']` instead
- :php:`HTTP_ACCEPT_LANGUAGE` is now :php:`->getHttpAcceptLanguage()`, but better use :php:`$request->getServerParams()['HTTP_ACCEPT_LANGUAGE']` instead
- :php:`REMOTE_HOST` is now :php:`->getRemoteHost()`, but better use :php:`$request->getServerParams()['REMOTE_HOST']` instead
- :php:`QUERY_STRING` is now :php:`->getQueryString()`, but better use :php:`$request->getServerParams()['QUERY_STRING']` instead

