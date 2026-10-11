..  include:: /Includes.rst.txt
..  index:: ! Backend routing
    File; EXT:{extkey}/Configuration/Backend/Routes.php
..  _backend-routing:

===============
Backend routing
===============

Each request to the backend is eventually executed by a controller.
A list of routes is defined which maps a given request to a controller
and an action.

Routes are defined inside extensions, in the files:

*   :ref:`Configuration/Backend/Routes.php <extension-configuration-backend-routes>`
    for general requests
*   :ref:`Configuration/Backend/AjaxRoutes.php <extension-configuration-backend-ajaxroutes>`
    for Ajax calls

Here is an extract of :t3src:`backend/Configuration/Backend/Routes.php`:

..  literalinclude:: _BackendRouting/_RoutesBackend.php
    :caption: EXT:backend/Configuration/Backend/Routes.php (excerpt)

So, a route file essentially returns an array containing route mappings. A route
is defined by a key, a path, a referrer and a target. The option `access`
defines whether the route needs a backend user, see
`Access to a backend route <https://docs.typo3.org/permalink/t3coreapi:backend-routing-access>`_.

..  note::
    The current route object is available as a :ref:`route attribute
    <typo3-request-attribute-route>` in the PSR-7 request object of every
    backend request. It is added through the PSR-15 middleware stack and can be
    retrieved using :php:`$request->getAttribute('route')`.


..  index::
    Backend routing; Access
..  _backend-routing-access:

Access to a backend route
=========================

..  versionadded:: 15.0
    :changelog: feature-110863-1790781220

    The values `anonymous` and `authenticated-without-token` replace the
    value `public`, which is deprecated. A route with `public` behaves like
    `authenticated-without-token`. Use `anonymous` only for a route that
    must work without a backend user.

The option `access` of a route takes one of these values:

`authenticated`
    The default. The route needs a logged-in backend user and a valid
    request token.

`authenticated-without-token`
    The route needs a logged-in backend user, but no request token.

`anonymous`
    The route works without a backend user and without a request token,
    for example the login form or the callback of a single sign-on
    provider.

TYPO3 treats any other value as `authenticated`, so a misspelled value
never makes a route reachable without login.

..  literalinclude:: _BackendRouting/_RoutesAccess.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

The console command
`vendor/bin/typo3 debug:backend:routes <https://docs.typo3.org/permalink/t3coreapi:console-command-debug-backend-routes>`_
lists the access of every route.

..  index::
    pair: Backend routing; Cross-site scripting
    Backend routing; Public

..  _backend-routing-backend-routing-cross:

Backend routing and cross-site scripting
========================================

Backend routes with `'access' => 'anonymous'` or
`'access' => 'authenticated-without-token'` do not require a session token,
but can be used to redirect to a route that requires a session token
internally. For this context, the backend user logged in must
have a valid session.

This scenario can lead to situations where an existing cross-site scripting
vulnerability (XSS) bypasses the mentioned session token, which can be
considered cross-site request forgery (CSRF). The difference in terminology is
that this scenario occurs on same-site requests and not cross-site - however,
potential security implications are still the same.

Backend routes can enforce the existence of an HTTP referrer header by adding a
:php:`referrer` to routes to mitigate the described scenario.

..  literalinclude:: _BackendRouting/_RoutesReferrer.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

Values for :php:`referrer` are declared as a comma-separated list:

*   :php:`required` enforces existence of HTTP `Referer` header that has to match
    the currently used backend URL (for example, :samp:`https://example.org/typo3/`),
    the request will be denied otherwise.
*   :php:`refresh-empty` triggers an HTML-based refresh in case HTTP `Referer`
    header is not given or empty - this attempt uses an HTML refresh, since
    regular HTTP `Location` redirect still would not set a referrer. It implies
    this technique should only be used on plain HTML responses and will not have
    any impact, for example, on JSON or XML response types.

This technique should be used on all routes without a session token that
internally redirect to a restricted route (having a session token). The goal is
to protect and keep information about the current session token internal.

The request sequence in the TYPO3 Core looks like this:

#.  HTTP request to :samp:`https://example.org/typo3/` having a valid user
    session
#.  Internally the **anonymous** backend route `/login` is processed
#.  Internally redirects to **restricted** backend route `/main` since an
    existing and valid backend user session was found
    + HTTP redirect to :samp:`https://example.org/typo3/main?token=...`
    + exposing the token is mitigated with `referrer` route option mentioned
    above

..  attention::
    Please keep in mind these steps are part of a mitigation strategy, which
    requires to be aware of mentioned implications when implementing custom web
    applications.


..  _backend-routing-cross-site-requests:

Requests from other sites that change data
------------------------------------------

..  versionadded:: 15.0
    :changelog: feature-110863-1790781220

TYPO3 rejects a request that changes data and comes from another site. This
applies to every route except those with `'access' => 'anonymous'`, and to
every request method except `GET`, `HEAD`, and `OPTIONS`. TYPO3 answers such
a request with the HTTP status `403`.

The browser reports the origin of a request in the `Sec-Fetch-Site` header.
If this header is missing, TYPO3 compares the `Origin` header with the host
of the request. The feature toggle
`security.backend.enforceFetchMetadata <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-features-security-backend-enforcefetchmetadata>`_
turns this check off.


..  index:: Backend routing; Dynamic URL parts
..  _backend-routing-dynamic-parts:

Dynamic URL parts in backend URLs
=================================

Backend routes can be registered with path segments that contain dynamic parts,
which are then resolved into a PSR-7 request attribute called
:ref:`routing <typo3-request-attribute-routing-backend>`.

These routes are defined within the route path as named placeholders:

..  literalinclude:: _BackendRouting/_RoutesMyRoute.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

Within a controller (we use here a non-Extbase controller as example):

..  literalinclude:: _BackendRouting/_MyRouteController.php
    :caption: EXT:my_extension/Classes/Controller/MyRouteController.php

..  index:: Backend routing; Generating backend URLs

..  _generating-backend-urls:
Generating backend URLs
=======================

Using the UriBuilder API, you can generate any kind of URL for the backend, may
it be a module, a typical route or an Ajax call. Therefore use either
:php:`buildUriFromRoute()` or :php:`buildUriFromRoutePath()`. The
:php:`UriBuilder` then returns a PSR-7 conform :php:`Uri` object that can be
cast to a string when needed. Furthermore, the :php:`UriBuilder` automatically
generates and applies the mentioned session token.

To generate a backend URL via the :php:`UriBuilder` you'd usually use the route
identifier and optional :php:`parameters`.

In case of Extbase controllers you can append the controller action to the route
identifier to directly target those actions. See also module configuration: :confval:`controllerActions <t3coreapi:backend-module-controlleractions>`.

..  _backend-routing-url-viewhelper:

Via Fluid ViewHelper
--------------------

To generate a backend URL in Fluid you can use html:`<f:be.link>` (which
is using :php:`UriBuilder` internally).

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.fluid.html

    <f:be.link route="web_layout" parameters="{id:42}">go to page 42</f:be.link>
    <f:be.link route="web_ExtkeyExample">go to custom BE module</f:be.link>
    <f:be.link route="web_ExtkeyExample.MyModuleController_list">
        go to custom BE module but specific controller action
    </f:be.link>

..  _backend-routing-url-php:

Via PHP
-------

Example within a controller (we use here a non-Extbase controller):

..  literalinclude:: _BackendRouting/_UriBuilderExample.php
    :caption: EXT:my_extension/Classes/Controller/MyRouteController.php

..  _backend-routing-sudo:

Sudo mode
=========

The sudo mode, as known from the install tool,
can be request for arbitrary backend modules.

You can configure the sudo mode in your backend routing like this:

..  literalinclude:: /ApiOverview/Backend/_BackendRouting/_sudo_routes.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

See also
:ref:`Custom backend modules requiring the sudo mode
<backend-module-sudo-modules>`.

..  _backend-routing-information:

More information
================

Please refer to the following resources and look at how the TYPO3 source code
handles backend routing in your TYPO3 version.

*   :ref:`TYPO3 request object <typo3-request>`
*   TYPO3 Core: :t3src:`backend/Configuration/Backend/AjaxRoutes.php`
*   TYPO3 Core: :t3src:`backend/Configuration/Backend/Routes.php`
