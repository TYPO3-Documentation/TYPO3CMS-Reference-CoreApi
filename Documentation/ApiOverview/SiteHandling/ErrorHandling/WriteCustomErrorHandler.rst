..  include:: /Includes.rst.txt
..  index:: pair: Site handling; Custom error handler
..  _sitehandling-customErrorHandler:

===================================
Writing a custom page error handler
===================================

The error handling configuration for sites allows implementing a custom error
handler, if the existing options of rendering a
:ref:`Fluid template <sitehandling-errorHandling_fluid>` or
:ref:`page <sitehandling-errorHandling_page>` are not enough. An example would
be an error page that uses the requested page or its parameters to search for
relevant content on the website.

A custom error handler needs to have a constructor that takes exactly two
arguments:

*   :php:`$statusCode`: an integer holding the status code TYPO3 expects the
    handler to use
*   :php:`$configuration`: an array holding the configuration of the handler

Furthermore it needs to implement the :php:`PageErrorHandlerInterface`
(:t3src:`core/Classes/Error/PageErrorHandler/PageErrorHandlerInterface.php`).
The interface specifies only one method:
:php:`handlePageError(ServerRequestInterface $request, string $message, array $reasons = []): ResponseInterface`

Let us take a closer look:

The method :php:`handlePageError()` gets three parameters:

*   :php:`$request`: the current HTTP request - for example, we can access
    query parameters and the request path via this :ref:`object <typo3-request>`
*   :php:`$message`: an error message string - for example, "Cannot connect to
    the configured database." or "Page not found"
*   :php:`$reasons`: an arbitrary array of failure reasons - see
    :t3src:`frontend/Classes/Page/PageAccessFailureReasons.php`

What you do with these variables is left to you, but you need to return a
valid :php:`\Psr\Http\Message\ResponseInterface` response - most usually an
:php:`\TYPO3\CMS\Core\Http\HtmlResponse`.

For an example implementation of the :php:`PageErrorHandlerInterface`, take a
look at :t3src:`core/Classes/Error/PageErrorHandler/PageContentErrorHandler.php`
or :t3src:`core/Classes/Error/PageErrorHandler/FluidPageErrorHandler.php`.

For a custom 403 error handler with redirect to a login form, please see
:ref:`Custom error handler implementation for 403 redirects
<typo3/cms-felogin:felogin-how-to-implement-403redirect-error-handler>`.

Properties
==========

The custom error handlers have the properties
:ref:`sitehandling-errorHandling_errorCode` and
:ref:`sitehandling-errorHandling_errorHandler` and the following:

..  option:: errorPhpClassFQCN

    :type: string
    :Example: `\MyVendor\MySitePackage\Error\MyErrorHandler`

    Fully-qualified class name of a custom error handler implementing
    :php:`PageErrorHandlerInterface`.


Example for a simple 404 error handler
======================================

The configuration:

..  literalinclude:: _custom-error-handler.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

The error handler class:

..  literalinclude:: _MyErrorHandler.php
    :caption: EXT:my_sitepackage/Classes/Error/MyErrorHandler.php
