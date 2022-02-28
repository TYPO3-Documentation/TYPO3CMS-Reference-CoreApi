.. include:: /Includes.rst.txt
.. index:: pair: Site handling; Custom error handler
.. _sitehandling-customErrorHandler:

===================================
Writing a custom page error handler
===================================

The error handling configuration for sites allows implementing a custom error handler if the existing
options of rendering a Fluid template or page are not enough. An example would be an error page
that uses the requested page or its parameters to search for relevant content on the web site.

A custom error handler needs to have a constructor that takes exactly two arguments:

* :php:`$statusCode`: an integer holding the status code TYPO3 expects the handler to use
* :php:`$configuration`: an array holding the configuration of the handler

Furthermore it needs to implement the :php:`PageErrorHandlerInterface`
(:php:`\TYPO3\CMS\Core\Error\PageErrorHandler\PageErrorHandlerInterface`). The interface specifies only one method:
:php:`handlePageError(ServerRequestInterface $request, string $message, array $reasons = []): ResponseInterface`

Let's take a closer look:

The method :php:`handlePageError` get's three parameters:

* :php:`$request`: the current HTTP request - we can for example access query parameters and
  the request path via this object
* :php:`$message`: an error message string - for example `Cannot connect to the configured database.`
  or `Page not found`
* :php:`$reasons`: an arbitrary array of failure reasons - see for
  example :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::getPageAccessFailureReasons`

What you do with these variables is left to you, but you need to return a valid :php:`ResponseInterface`
response - most usually an :php:`HtmlResponse`.

For an example implementation of the :php:`PageErrorHandlerInterface` take a look
at :php:`\TYPO3\CMS\Core\Error\PageErrorHandler\PageContentErrorHandler` or
:php:`\TYPO3\CMS\Core\Error\PageErrorHandler\FluidPageErrorHandler`.

Properties
==========

The custom error handlers have the properties
:ref:`sitehandling-errorHandling_errorCode` and
:ref:`sitehandling-errorHandling_errorHandler` and the following:

errorPhpClassFQCN
-----------------

:aspect:`Datatype`
   string

:aspect:`Description`
   Fully qualified class name of a custom error handler implementing
   `PageErrorHandlerInterface`.

:aspect:`Example`
   `My\Site\Error\Handler`


Examples
========

Example for a simple 404 ErrorHandler
-------------------------------------

The configuration in *config.yaml*:

.. code-block:: yaml

   errorHandling:
      -
         errorCode: '404'
         errorHandler: PHP
         errorPhpClassFQCN: My\ExtensionName\Error\ErrorHandler

The ErrorHandler class:

.. code-block:: php

   <?php

   namespace My\ExtensionName\Error;

   use Psr\Http\Message\ResponseInterface;
   use Psr\Http\Message\ServerRequestInterface;
   use TYPO3\CMS\Core\Error\PageErrorHandler\PageErrorHandlerInterface;
   use TYPO3\CMS\Core\Http\HtmlResponse;

   final class ErrorHandler implements PageErrorHandlerInterface
   {
       /**
        * @var int
        */
       protected $statusCode;

       /**
        * @var array
        */
       protected $errorHandlerConfiguration;

       public function __construct(int $statusCode, array $configuration)
       {
           $this->statusCode = $statusCode;
           // This contains the configuration of the error handler which is
           // set in site configuration - this example does not use it.
           $this->errorHandlerConfiguration = $configuration;
       }

       /**
        * @param ServerRequestInterface $request
        * @param string $message
        * @param array $reasons
        * @return ResponseInterface
        */
       public function handlePageError(
           ServerRequestInterface $request,
           string $message,
           array $reasons = []
       ): ResponseInterface {
              return new HtmlResponse('<h1>Not found, sorry</h1>', $this->statusCode);
       }

   }
