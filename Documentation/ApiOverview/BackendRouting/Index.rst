.. include:: /Includes.rst.txt
.. index:: ! Backend routing
   File; EXT:{extkey}/Configuration/Backend/Routes.php
.. _backend-routing:

===============
Backend routing
===============

Each request to the backend is eventually executed by a controller.
A list of routes is defined which maps a given request to a controller
and an action.

Routes are defined inside extensions, in file :file:`Configuration/Backend/Routes.php`
for general requests and in  :file:`Configuration/Backend/AjaxRoutes.php` for
AJAX calls.

Here is an extract of :file:`typo3/sysext/backend/Configuration/Backend/Routes.php`:

.. code-block:: php

   <?php

   use TYPO3\CMS\Backend\Controller;

   /**
    * Definitions for routes provided by EXT:backend
    * Contains all "regular" routes for entry points
    *
    * Please note that this setup is preliminary until all Core use-cases are set up here.
    * Especially some more properties regarding modules will be added until TYPO3 CMS 7 LTS, and might change.
    *
    * Currently the "access" property is only used so no token creation + validation is made,
    * but will be extended further.
    */
   return [
       // Login screen of the TYPO3 Backend
       'login' => [
           'path' => '/login',
           'access' => 'public',
           'target' => Controller\LoginController::class . '::formAction'
       ],

       // Main backend rendering setup (previously called backend.php) for the TYPO3 Backend
       'main' => [
           'path' => '/main',
           'referrer' => 'required,refresh-always',
           'target' => Controller\BackendController::class . '::mainAction'
       ],
      // ...
   ];

So a routes file essentially returns an array containing routes mapping.
A route is defined by a key, a path, a referrer and a target. The "public" :code:`access`
property indicates that no authentication is required for that action.

.. note::

   The current route object is available as `route` attribute on the PSR-7 request
   object of every backend request. It is added through the PSR-15 middleware stack
   and can be retrieved using :php:`$request->getAttribute('route')`.

.. index::
   pair: Backend routing; Cross-site scripting
   Backend routing; Public

Backend routing and cross-site scripting
========================================

Public backend routes (those having option :php:`'access' => 'public'`) do not
require any session token, but can be used to redirect to a route that requires
a session token internally. For this context, the backend user logged in must
have a valid session.

This scenario can lead to situations where an existing cross-site scripting
vulnerability (XSS) bypasses the mentioned session token, which can be
considered cross-site request forgery (CSRF). The difference in terminology is
that this scenario occurs on same-site requests and not cross-site - however,
potential security implications are still the same.

Backend routes can enforce an HTTP Referer header's existence by adding a
:php:`referrer` to routes to mitigate the described scenario.

.. code-block:: php

    'main' => [
        'path' => '/main',
        'referrer' => 'required,refresh-empty',
        'target' => Controller\BackendController::class . '::mainAction'
    ],

Values for :php:`referrer` are declared as comma-separated list:

* `required` enforces existence of HTTP `Referer` header that has to match the
  currently used backend URL (e.g. `https://example.org/typo3/`), the request
  will be denied otherwise.
* `refresh-empty` triggers a HTML based refresh in case HTTP `Referer` header
  is not given or empty - this attempt uses an HTML refresh, since regular HTTP
  `Location` redirect still would not set a referrer. It implies this technique
  should only be used on plain HTML responses and won't have any impact e.g. on
  JSON or XML response types.

This technique should be used on all public routes (without session token) that
internally redirect to a restricted route (having a session token). The goal is
to protect and keep information about the current session token internal.

The request sequence in the TYPO3 Core looks like this:

* HTTP request to `https://example.org/typo3/` having a valid user session
* internally **public** backend route `/login` is processed
* internally redirects to **restricted** backend route `/main` since an
  existing and valid backend user session was found
  + HTTP redirect to `https://example.org/typo3/main?token=...`
  + exposing the token is mitigated with `referrer` route option mentioned above

.. important::

   Please keep in mind these steps are part of a mitigation strategy, which requires
   to be aware of mentioned implications when implementing custom web applications.
   
   
.. index:: Backend routing; Generating backend URLs
   
Generating backend URLs
=======================

Using the UriBuilder API, you can generate any kind of URL for the Backend, may it be
a module, a typical route or an AJAX call. Therefore use either :php:`buildUriFromRoute()`
or :php:`buildUriFromRoutePath()`. The :php:`UriBuilder` then returns a PSR-7 conform :php:`Uri` object
that can be cast to string when needed. Furthermore does the :php:`UriBuilder` automatically
generate and apply the mentioned session token.

.. code-block:: php

   // Using a route identifier
   $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
   $uri = $uriBuilder->buildUriFromRoute('web_layout', ['id' => $pageId]);
   
   // Using a route path
   $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
   $uri = $uriBuilder->buildUriFromRoutePath(
      '/record/edit',
      [
         'edit' => [
            'pages' => [
               123 => 'edit'
            ]
         ]
      ]
   );

More Information
================

Please refer to the following external resources and look at how the TYPO3 source code
handles backend routing in your TYPO3 version.

* `Scripting-Base: "PSR-7 for backend modules" <https://scripting-base.de/blog/psr-7-for-backend-modules>`__
* `Scripting-Base: "AJAX with PSR-7" <https://scripting-base.de/blog/ajax-with-psr-7.html>`__
* `PSR-7 <https://www.php-fig.org/psr/psr-7/>`__
* TYPO3 Core : `backend : AjaxRoutes.php <https://github.com/TYPO3/TYPO3.CMS/blob/9.5/typo3/sysext/backend/Configuration/Backend/AjaxRoutes.php>`__ (GitHub)
* TYPO3 Core : `backend : Routes.php <https://github.com/TYPO3/TYPO3.CMS/blob/9.5/typo3/sysext/backend/Configuration/Backend/Routes.php>`__ (GitHub)
