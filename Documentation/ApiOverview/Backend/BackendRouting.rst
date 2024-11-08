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

Routes are defined inside extensions, in the files

*   :ref:`Configuration/Backend/Routes.php <extension-configuration-backend-routes>`
    for general requests
*   :ref:`Configuration/Backend/AjaxRoutes.php <extension-configuration-backend-ajaxroutes>`
    for Ajax calls

Here is an extract of :t3src:`backend/Configuration/Backend/Routes.php`:

..  literalinclude:: _BackendRouting/_RoutesBackend.php
    :language: php
    :caption: EXT:backend/Configuration/Backend/Routes.php (excerpt)

So, a route file essentially returns an array containing route mappings. A route
is defined by a key, a path, a referrer and a target. The "public" :php:`access`
property indicates that no authentication is required for that action.

..  note::
    The current route object is available as a :ref:`route attribute
    <typo3-request-attribute-route>` in the PSR-7 request object of every
    backend request. It is added through the PSR-15 middleware stack and can be
    retrieved using :php:`$request->getAttribute('route')`.


..  index::
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

Backend routes can enforce the existence of an HTTP referrer header by adding a
:php:`referrer` to routes to mitigate the described scenario.

..  code-block:: php

    'main' => [
        'path' => '/main',
        'referrer' => 'required,refresh-empty',
        'target' => Controller\BackendController::class . '::mainAction'
    ],

Values for :php:`referrer` are declared as a comma-separated list:

*   :php:`required` enforces existence of HTTP `Referer` header that has to match
    the currently used backend URL (for example, :samp:`https://example.org/typo3/`),
    the request will be denied otherwise.
*   :php:`refresh-empty` triggers an HTML-based refresh in case HTTP `Referer`
    header is not given or empty - this attempt uses an HTML refresh, since
    regular HTTP `Location` redirect still would not set a referrer. It implies
    this technique should only be used on plain HTML responses and will not have
    any impact, for example, on JSON or XML response types.

This technique should be used on all public routes (without session token) that
internally redirect to a restricted route (having a session token). The goal is
to protect and keep information about the current session token internal.

The request sequence in the TYPO3 Core looks like this:

#.  HTTP request to :samp:`https://example.org/typo3/` having a valid user
    session
#.  Internally **public** backend route `/login` is processed
#.  Internally redirects to **restricted** backend route `/main` since an
    existing and valid backend user session was found
    + HTTP redirect to :samp:`https://example.org/typo3/main?token=...`
    + exposing the token is mitigated with `referrer` route option mentioned
    above

..  attention::
    Please keep in mind these steps are part of a mitigation strategy, which
    requires to be aware of mentioned implications when implementing custom web
    applications.


..  index:: Backend routing; Dynamic URL parts
..  _backend-routing-dynamic-parts:

Dynamic URL parts in backend URLs
=================================

..  versionadded:: 12.1

Backend routes can be registered with path segments that contain dynamic parts,
which are then resolved into a PSR-7 request attribute called
:ref:`routing <typo3-request-attribute-routing-backend>`.

These routes are defined within the route path as named placeholders:

..  literalinclude:: _BackendRouting/_RoutesMyRoute.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

Within a controller (we use here a non-Extbase controller as example):

..  literalinclude:: _BackendRouting/_MyRouteController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyRouteController.php

.. index:: Backend routing; Generating backend URLs

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

.. _backend-routing-url-viewhelper:

Via Fluid ViewHelper
--------------------

To generate a backend URL in Fluid you can simply use html:`<f:be.link>` (which
is using :php:`UriBuilder` internally).

..  code-block:: html

    <f:be.link route="web_layout" parameters="{id:42}">go to page 42</f:be.link>
    <f:be.link route="web_ExtkeyExample">go to custom BE module</f:be.link>
    <f:be.link route="web_ExtkeyExample.MyModuleController_list">
        go to custom BE module but specific controller action
    </f:be.link>
    
.. _backend-routing-url-php:

Via PHP
-------

Example within a controller (we use here a non-Extbase controller):

..  literalinclude:: _BackendRouting/_UriBuilderExample.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/MyRouteController.php

..  versionadded:: 13.0
    The :php:`UriBuilder->buildUriFromRequest()` method has been introduced.

..  _backend-routing-sudo:

Sudo mode
=========

The sudo mode, as known from the install tool,
can be request for arbitrary backend modules.

You can configure the sudo mode in your backend routing like this:

..  literalinclude:: /ApiOverview/Backend/_BackendRouting/_sudo_routes.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

See also :ref:`backend-module-sudo-modules`.

More information
================

Please refer to the following resources and look at how the TYPO3 source code
handles backend routing in your TYPO3 version.

*   :ref:`TYPO3 request object <typo3-request>`
*   TYPO3 Core: :t3src:`backend/Configuration/Backend/AjaxRoutes.php`
*   TYPO3 Core: :t3src:`backend/Configuration/Backend/Routes.php`
