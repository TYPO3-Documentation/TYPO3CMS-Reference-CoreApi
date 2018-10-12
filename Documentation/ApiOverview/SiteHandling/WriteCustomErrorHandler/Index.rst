.. include:: ../../../Includes.txt


.. _sitehandling-customErrorHandler:

Writing a custom Page Error Handler
-----------------------------------

The error handling configuration for sites allows implementing a custom error handler if the existing 
options of rendering a fluid template or page are not enough. An example would be an error page
that uses the requested page or its parameters to search for relevant content on the web site. 

A custom error handler needs to implement the `PageErrorHandlerInterface` (`\TYPO3\CMS\Core\Error\PageErrorHandler\PageErrorHandlerInterface`).
The interface specifies only one method: `handlePageError(ServerRequestInterface $request, string $message, array $reasons = []): ResponseInterface`

Let's take a closer look:

The method `handlePageError` get's three parameters:

- `$request`: the current HTTP request - we can for example access query parameters and the request path via this object
- `$message`: an error message string (for example `Cannot connect to the configured database.` or `Page not found`
- `$reasons`: an arbitrary array of failure reasons - see for example `\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::getPageAccessFailureReasons`

What you do with these variables is left to you, but you need to return a valid `ResponseInterface` response - most usually an
`HtmlResponse`.

For an example implementation of the `PageErrorHandlerInterface` take a look at `\TYPO3\CMS\Core\Error\PageErrorHandler\PageContentErrorHandler` or
`\TYPO3\CMS\Core\Error\PageErrorHandler\FluidPageErrorHandler`.