..  include:: /Includes.rst.txt
..  index:: pair: Error handling; Page
..  _sitehandling-errorHandling_page:

========================
Page-based error handler
========================

The page error handler displays the content of a page in case of a certain
HTTP status. The content of this page is generated via a TYPO3-internal
sub-request.

The page-based error handler is defined in
:t3src:`core/Classes/Error/PageErrorHandler/PageContentErrorHandler.php`.

In order to prevent possible denial-of-service attacks when the page-based error
handler is used with the cURL-based approach, the content of the error page is
cached in the TYPO3 page cache. Any dynamic content on the error page (for
example, content created by TypoScript or uncached plugins) will therefore also
be cached.

If the error page contains dynamic content, TYPO3 administrators must
ensure that no sensitive data (for example, username of logged-in frontend user)
will be shown on the error page.

If dynamic content is required on the error page, it is recommended
to implement a :ref:`custom PHP based error
handler <sitehandling-customErrorHandler>`.

Error pages are always generated via a TYPO3-internal sub-request instead
of an external HTTP request (cURL over Guzzle).

Properties
==========

The page-based error handler has the properties
:ref:`sitehandling-errorHandling_errorCode` and
:ref:`sitehandling-errorHandling_errorHandler` and the following:

..  option:: errorContentSource

    :type: string
    :Example: `t3://page?uid=123`

    Either an external URL or a TYPO3 page that will be fetched with an
    internal sub-request and displayed in case of an error.


Examples
========

Internal error page
-------------------

Show the internal page with uid `145` on all errors with HTML status code `404`.

..  literalinclude:: _page-error-handler-internal.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

External error page
-------------------

Shows an external page on all errors with a HTTP status code not defined
otherwise.

..  literalinclude:: _page-error-handler-external.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml
