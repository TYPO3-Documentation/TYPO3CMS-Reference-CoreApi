..  include:: /Includes.rst.txt
..  index::
    Request handling
    PSR-15
    Request handling; PSR-15
    Middlewares
..  _request-handling:

==============================
Middlewares (Request handling)
==============================

TYPO3 has implemented `PSR-15`_ for handling incoming HTTP requests. The
implementation within TYPO3 is often called "Middlewares", as PSR-15 consists of
two interfaces where one is called :php:`Middleware`.

..  contents::
    :local:

..  _request-handling-basic-concept:

Basic concept
=============

The most important information is available at
https://www.php-fig.org/psr/psr-15/ and https://www.php-fig.org/psr/psr-15/meta/
where the standard itself is explained.

The idea is to use `PSR-7`_ :php:`Request` and :php:`Response` as a base, and
wrap the execution with middlewares which implement `PSR-15`_. PSR-15 will receive
the incoming request and return the created response. Within PSR-15 multiple
request handlers and middlewares can be executed. Each of them can adjust the
request and response.

..  _request-handling-typo3-implementation:

TYPO3 implementation
====================

TYPO3 has implemented the PSR-15 approach in the following way:

..  uml:: /Images/Plantuml/RequestHandling/flow-of-middleware-execution.plantuml
   :align: center
   :caption: Figure 1-1: Application flow
   :width: 1000


..  rst-class:: bignums

#.  TYPO3 will create a :ref:`typo3-request`.

#.  TYPO3 will collect and sort all configured PSR-15 middlewares.

#.  TYPO3 will convert all middlewares to PSR-15 request handlers.

#.  TYPO3 will call the first middleware with request and the next middleware.

#.  Each middleware can modify the request if needed, see :ref:`request-handling-middlewares`.

#.  Final Request is passed to the last RequestHandler (`\TYPO3\CMS\Frontend\Http\RequestHandler`
    or `\TYPO3\CMS\Backend\Http\RequestHandler`) which generates PSR-7 response and passes
    it back to the last middleware.

#.  Each middleware gets back a PSR-7 response from middleware later in the stack and passes it up the stack to the previous middleware.
    Each middleware can modify the response before passing it back.

#.  This response is passed back to the execution flow.

..  index:: Request handling; Middleware
..  _request-handling-middlewares:

Middlewares
===========

Each middleware has to implement the PSR-15
:php:`\Psr\Http\Server\MiddlewareInterface`:

..  include:: /CodeSnippets/Middleware/MiddlewareInterface.rst.txt

By doing so, the middleware can do one or multiple of the following:

* Adjust the incoming request, e.g. add further information.

* Create and return a PSR-7 response.

* Call next request handler (which again can be a middleware).

* Adjust response received from the next request handler.


..  _request-handling-middlewares-extbase:

Using Extbase
-------------

One note about using :ref:`Extbase <extbase>` in middlewares: do not! Extbase
relies on :ref:`frontend TypoScript <t3tsref:start>` being present; otherwise
the configuration is not applied. This is usually no problem - Extbase plugins
are typically either included as :ref:`USER content object <t3tsref:cobj-user>`
(its content is cached and returned together with other content elements in
fully-cached page context), or the Extbase plugin is registered as USER_INT. In
this case, the :ref:`TSFE <tsfe>` takes care of calculating TypoScript before
the plugin is rendered, while other USER content objects are fetched from page
cache.

With TYPO3 v11, the "calling Extbase in a context where TypoScript has not been
calculated" scenario did not fail, but simply returned an empty array for
TypoScript, crippling the configuration of the plugin in question. This
mitigation hack has been removed in TYPO3 v13, though. Extension developers
that already use Extbase in a middleware have the following options:

*   Consider not using Extbase for the use case: Extbase is quite expensive.
    Executing it from within middlewares can increase the parse time in
    fully-cached page context significantly and should be avoided especially for
    "simple" things. In many cases, directly manipulating the response object
    and skipping the Extbase overhead in a middleware should be enough.

*   Move away from the middleware and register the Extbase instance as a casual
    :ref:`USER_INT <t3tsref:cobj-user-int>` object via TypoScript: Extbase is
    designed to be executed like this, the TSFE bootstrap will take care of
    properly calculating TypoScript, and Extbase will run as expected.

    Note that with TYPO3 v12, the overhead of USER_INT content objects has been
    reduced significantly, since TypoScript can be fetched from improved cache
    layers more quickly. This is also more resilient towards core changes since
    extension developers do not need to go through the fiddly process of
    bootstrapping Extbase on their own.


..  _request-handling-middleware-examples:

Middleware examples
===================

The following list shows typical use cases for middlewares.

*   :ref:`A middleware to return a JSON response with localized
    strings <example-localization-middleware>`.


..  index:: Request handling; Custom response
..  _request-handling-returning-custom-response:

Returning a custom response
---------------------------

This middleware checks whether `foo/bar` was called and will return
an unavailable response in that case. Otherwise the next middleware will be
called, and its response is returned instead.

..  literalinclude:: _Middlewares/_NotAvailableMiddleware.php

..  index:: Request handling; Enriched request
..  _request-handling-enriching-request:

Enriching the request
---------------------

The current request can be extended with further information, e.g. the current
resolved site and language could be attached to the request.

In order to do so, a new request is built with additional attributes, before
calling the next request handler with the enhanced request.

..  literalinclude:: _Middlewares/_RequestEnrichingMiddleware.php

..  index:: Request handling; Enriched response
..  _request-handling-enriching-response:

Enriching the response
----------------------

This middleware will check the length of generated output, and add a header
with this information to the response.

In order to do so, the next request handler is called. It will return the generated
response, which can be enriched before it gets returned.

If you want to modify the response coming from certain middleware,
your middleware has to be configured to be `before` it.
Order of processing middlewares when enriching response is opposite
to when middlewares are modifying the request.

..  literalinclude:: _Middlewares/_ResponseEnrichingMiddleware.php

..  index:: Request handling; Configuration
..  _request-handling-configuring-middlewares:

Configuring middlewares
=======================

In order to implement a custom middleware, this middleware has to be configured.
TYPO3 already provides some middlewares out of the box. Beside adding your own
middlewares, it's also possible to remove existing middlewares from
the configuration.

The configuration is provided within
:file:`Configuration/RequestMiddlewares.php` of an extension:

..  include:: /CodeSnippets/Manual/Extension/Configuration/RequestMiddlewares.rst.txt

TYPO3 has multiple stacks where one middleware might only be necessary in one
of them. Therefore the configuration defines the context on its first level to define the
context. Within each context the middleware is registered as new subsection with
an unique identifier as key.

The default stacks are: `frontend` and `backend`.

Each middleware consists of the following options:

target
    PHP string

    FQCN (=Fully Qualified Class Name) to use as middleware.

before
    PHP Array

    List of middleware identifiers. The middleware itself is
    executed before any other middleware within this array.

after
    PHP Array

    List of middleware identifiers. The middleware itself is
    executed after any other middleware within this array.

disabled
    PHP boolean

    Allows to disable specific middlewares.

The `before` and `after` configuration is used to sort middlewares in form of a stack.
You can check the calculated order in the configuration module in TYPO3 Backend.

Middleware which is configured `before` another middleware (higher in the stack) wraps execution of following middlewares.
Code written before `$handler->handle($request);` in the `process` method can modify
the request before it's passed to the next middlewares. Code written after `$handler->handle($request);`
can modify the response provided by next middlewares.

Middleware which is configured `after` another (e.g. `MiddlewareB` from the diagram above),
will see changes to the request made by previous middleware (`MiddlewareA`),
but will not see changes made to the response from `MiddlewareA`.

..  index:: Request handling; Ordering
..  _request-handling-configuring-middlewares-override:

Override ordering of middlewares
================================

To change the ordering of middlewares shipped by the Core an extension can override the registration in
:file:`Configuration/RequestMiddlewares.php`:

..  literalinclude:: _Middlewares/_RequestMiddlewaresOrdering.php
    :caption: EXT:some_extension/Configuration/RequestMiddlewares.php

However, this could lead to circular ordering depending on the ordering constraints of other
middlewares. Alternatively an existing middleware can be disabled and reregistered again with a new
identifier. This will circumvent the risk of circularity:

..  literalinclude:: _Middlewares/_RequestMiddlewaresDisable.php
    :caption: EXT:some_extension/Configuration/RequestMiddlewares.php

..  literalinclude:: _Middlewares/_RequestMiddlewaresOrdering.php
    :caption: EXT:some_extension/Configuration/RequestMiddlewares.php

..  attention::

    Always check the integrity of the middleware stack after changing the default ordering.
    This can be done in the configuration module that comes with EXT:lowlevel.

..  _request-handling-psr-17:

Creating new request / response objects
=======================================

PSR-17_ HTTP Factory interfaces are provided by `psr/http-factory` and should be used as
dependencies for PSR-15_ request handlers or services that need to create PSR-7_ message objects.

It is discouraged to explicitly create PSR-7_ instances of classes from the :php:`\TYPO3\CMS\Core\Http`
namespace (they are not public APIs). Instead, use type declarations against PSR-17_ HTTP Message Factory
interfaces and dependency injection.

..  _request-handling-psr-17-example:

Example
-------

A middleware that needs to send a JSON response when a certain condition is met, uses the
PSR-17_ response factory interface (the concrete TYPO3 implementation is injected as a constructor
dependency) to create a new PSR-7_ response object:

..  literalinclude:: _Middlewares/_StatusCheckMiddleware.php
   :caption: EXT:some_extension/Classes/Middleware/StatusCheckMiddleware.php

..  index:: Request handling; Execution
..  _request-handling-psr-18:

Executing HTTP requests in middlewares
======================================

The PSR-18_ HTTP Client is intended to be used by PSR-15_ request handlers in order to perform HTTP
requests based on PSR-7_ message objects without relying on a specific HTTP client implementation.

PSR-18_ consists of a client interface and three exception interfaces:

-   :php:`\Psr\Http\Client\ClientInterface`
-   :php:`\Psr\Http\Client\ClientExceptionInterface`
-   :php:`\Psr\Http\Client\NetworkExceptionInterface`
-   :php:`\Psr\Http\Client\RequestExceptionInterface`

Request handlers use dependency injection to retrieve the concrete implementation
of the PSR-18_ HTTP client interface :php:`\Psr\Http\Client\ClientInterface`.

The PSR-18_ HTTP Client interface is provided by `psr/http-client` and may be used as
dependency for services in order to perform HTTP requests using PSR-7_ request objects.
PSR-7_ request objects can be created with the :ref:`PSR-17 Request Factory interface<request-handling-psr-17>`.

..  note::

    This does not replace the currently available Guzzle wrapper
    :php:`\TYPO3\CMS\Core\Http\RequestFactory->request()`, but is available as a more generic,
    framework-agnostic alternative. The PSR-18 interface does not allow you to pass
    request-specific guzzle options. But global options defined in :php:`$GLOBALS['TYPO3_CONF_VARS']['HTTP']`
    are taken into account because GuzzleHTTP is used as the backend for this PSR-18 implementation.
    The concrete implementation is internal and will be replaced by a native guzzle PSR-18
    implementation once it is available.

..  _request-handling-psr-18-example:

Example usage
-------------

A middleware might need to request an external service in order to transform the response
into a new response. The PSR-18 HTTP client interface is used to perform the external
HTTP request. The PSR-17 Request Factory Interface is used to create the HTTP request that
the PSR-18 HTTP Client expects. The PSR-7 Response Factory is then used to create a new
response to be returned to the user. All of these interface implementations are injected
as constructor dependencies:

..  literalinclude:: _Middlewares/_ExampleMiddleware.php
    :caption: EXT:some_extension/Classes/Middleware/ExampleMiddleware.php

..  index:: Request handling; Debugging
..  _request-handling-debugging:

Debugging
=========

In order to see which middlewares are configured and to see the order of
execution, TYPO3 offers a the menu entry :guilabel:`HTTP Middlewares (PSR-15)`
within the "Configuration" module:

..  include:: /Images/AutomaticScreenshots/RequestHandling/ConfigurationMiddleware.rst.txt

..  _PSR-18: https://www.php-fig.org/psr/psr-18/
..  _PSR-17: https://www.php-fig.org/psr/psr-17/
..  _PSR-15: https://www.php-fig.org/psr/psr-15/
..  _PSR-7: https://www.php-fig.org/psr/psr-7/
