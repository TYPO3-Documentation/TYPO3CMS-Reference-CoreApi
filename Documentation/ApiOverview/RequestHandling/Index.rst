.. include:: ../../Includes.txt

.. highlight:: php

.. _request-handling:

================
Request Handling
================

TYPO3 CMS has implemented `PSR-15`_ for handling incoming HTTP Requests. The
implementation within TYPO3 is often called "Middlewares", as PSR-15 consists of
two Interfaces where one is called Middleware.

.. _request-handling-basic-concept:

Basic concept
=============

The most important information are available at
https://www.php-fig.org/psr/psr-15/ and https://www.php-fig.org/psr/psr-15/meta/
where the standard itself is explained.

The idea is to use `PSR-7`_ Request and Response as a base, and wrap the execution
of application using PSR-15. PSR-15 will receive the incoming request and return
the created response. Within PSR-15 multiple Request Handlers and Middlewares
can be executed. Each of them can adjust the request and response.

.. _request-handling-typo3-implementation:

TYPO3 implementation
====================

TYPO3 has implemented the PSR-15 approach in the following way:

.. figure:: flow-of-middleware-execution.svg
   :align: center

   Figure 1-1: Application flow

.. rst-class:: bignums

#. TYPO3 will create a PSR-7 request.

#. TYPO3 will collect and order all configured PSR-15 middlewares.

#. TYPO3 will convert all middlewares to PSR-15 request handler.

#. TYPO3 will call the first middleware with request and next middleware.

#. Each middleware is processed, see :ref:`request-handling-middleware`.

#. In the end each middleware has to return an PSR-7 response.

#. This response is passed back to the execution flow.

.. _request-handling-middlewares:

Middlewares
===========

Each middleware has to implement the PSR-15 :php:`MiddlewareInterface`::

   namespace Psr\Http\Server;

   use Psr\Http\Message\ResponseInterface;
   use Psr\Http\Message\ServerRequestInterface;

   /**
    * Participant in processing a server request and response
    *
    * An HTTP middleware component participates in processing an HTTP message:
    * by acting on the request, generating the response, or forwarding the
    * request to a subsequent middleware and possibly acting on its response.
    */
   interface MiddlewareInterface
   {
       /**
        * Process an incoming server request
        *
        * Processes an incoming server request in order to produce a response.
        * If unable to produce the response itself, it may delegate to the provided
        * request handler to do so.
        */
       public function process(
           ServerRequestInterface $request,
           RequestHandlerInterface $handler
       ): ResponseInterface;
   }

By doing so, the middleware can do one or multiple of the following:

* Adjust the incoming request, e.g. add further information.

* Create and return a PSR-7 response.

* Call next request handler (which again will be a middleware).

* Adjust response received from calling next request handler.

.. _request-handling-middleware-examples:

Middleware examples
===================

The following list shows typical use cases for middlewares.

.. _request-handling-returning-custom-response:

Returning custom response
-------------------------

This middleware will check whether TYPO3 is in maintenance mode and will return
an unavailable response in that case. Otherwise the next middleware will be
called, and their response is returned instead.

::

   public function process(
       ServerRequestInterface $request,
       RequestHandlerInterface $handler
   ): ResponseInterface {
       if (/* if logic */) {
           return GeneralUtility::makeInstance(ErrorController::class)
               ->unavailableAction(
                   $request,
                   'This page is temporarily unavailable.'
               );
       }

       return $handler->handle($request);
   }

.. _request-handling-enriching-request:

Enriching request
-----------------

The current request can be extended with further information, e.g. the current
resolved site and language could be attached to the request.

In order to do so, a new request is built with additional attributes, before
calling the next request handler with enhanced request.

::

   public function process(
       ServerRequestInterface $request,
       RequestHandlerInterface $handler
   ): ResponseInterface {
       $routeResult = $this->matcher->matchRequest($request);

       $request = $request->withAttribute('site', $routeResult->getSite());
       $request = $request->withAttribute('language', $routeResult->getLanguage());

       return $handler->handle($request);
   }

.. _request-handling-enriching-response:

Enriching response
-----------------

This middleware will check the length of generated output, and add an header
with this information to the response.

In order to do so, next request handler is called. He will return the generated
response, which can be enriched before it gets returned.

::

   public function process(
       ServerRequestInterface $request,
       RequestHandlerInterface $handler
   ): ResponseInterface {
       $response = $handler->handle($request);

       if (/* if logic */) {
           $response = $response->withHeader(
               'Content-Length',
               (string)$response->getBody()->getSize()
           );
       }

       return $response;
   }

.. _request-handling-configuring-middlewares:

Configuring middlewares
=======================

In order to implement a custom middleware, this middleware has to be configured.
TYPO3 already provides some middlewares pre configured. Beside adding own
middlewares, it's also possible to remove existing middlewares from
configuration.

The configuration is provided within
:file:`Configuration/RequestMiddlewares.php` of an extensions::

   return [
       'frontend' => [
           'middleware-identifier' => [
               'target' => \Vendor\ExtName\Middleware\ConcreteClass::class,
               'before' => [
                   'another-middleware-identifier',
               ],
               'after' => [
                   'yet-another-middleware-identifier',
               ],
           ],
       ],
       'backend' => [
           'middleware-identifier' => [
               'target' => \Vendor\ExtName\Middleware\AnotherConcreteClass::class,
               'before' => [
                   'another-middleware-identifier',
               ],
               'after' => [
                   'yet-another-middleware-identifier',
               ],
           ],
       ],
   ];

TYPO3 has multiple stacks where one middleware might only be necessary in one
of them. Therefore the configuration first introduces an level to define the
context. Within each context each middleware is registered as new php array with
an unique identifier as key.

Possible stacks are: `frontend` and `backend`.

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

.. _request-handling-debugging:

Debugging
=========

In order to see which middlewares are configured, and to see the order of
execution TYPO3 offers a new function menu entry within "Configuration" module:

.. figure:: /Images/ConfigurationMiddleware.png
   :align: center

   Figure 1-2: TYPO3 configuration module listing configured middlewares.

.. _PSR-15: https://www.php-fig.org/psr/psr-15/
.. _PSR-7: https://www.php-fig.org/psr/psr-7/
