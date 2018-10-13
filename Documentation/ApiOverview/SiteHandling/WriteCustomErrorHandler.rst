.. include:: ../../Includes.txt

.. _sitehandling-customErrorHandler:

Writing a custom Page Error Handler
===================================

The error handling configuration for sites allows implementing a custom error handler if the existing
options of rendering a fluid template or page are not enough. An example would be an error page
that uses the requested page or its parameters to search for relevant content on the web site.

A custom error handler needs to implement the :php:`PageErrorHandlerInterface`
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