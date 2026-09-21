:navigation-title: URL factory

..  include:: /Includes.rst.txt
..  index:: JavaScript (Backend); URL factory
..  _js-url-factory:

=====================================
URL factory backend JavaScript module
=====================================

..  versionadded:: 14.0
    See `Feature: #107104 - Introduce UrlFactory JavaScript module
    <https://docs.typo3.org/permalink/changelog:feature-107104-1752673630>`_.

The module :js:`@typo3/core/factory/url-factory.js` creates
:js:`URL` and :js:`URLSearchParams` objects for the TYPO3 backend.

..  _js-url-factory-create-url:

Create a URL object with the JavaScript URL factory
===================================================

:js:`UrlFactory.createUrl(url, parameters)` builds a :js:`URL` object from
the relative URL resolved from the origin of the current page. If there are any
parameters, they are added to the query string, as described in
:ref:`createSearchParams() <js-url-factory-create-search-params>`.

The following example creates a URL for an
:ref:`Ajax route <ajax-backend>` using query parameters and then passes it to
an :ref:`AjaxRequest <ajax-request>`:

..  literalinclude:: _create-url.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/search.js

..  _js-url-factory-create-search-params:

Create URL query parameters with the JavaScript URL factory
===========================================================

:js:`UrlFactory.createSearchParams(parameters)` creates a
:js:`URLSearchParams` object from a query string, an existing
:js:`URLSearchParams` object, or a plain object. Nested objects turn into
bracket-notation parameters, for example `filter[type]`. Values that are
:js:`null` or :js:`undefined` are skipped. It does not accept an array of
entries like the native constructor (built in to the browser) does —
convert an array first with :js:`Object.fromEntries()`:

..  literalinclude:: _create-search-params.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/parameters.js
