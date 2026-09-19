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

The module :js:`@typo3/core/factory/url-factory.js` creates the native
:js:`URL` and :js:`URLSearchParams` objects the TYPO3 backend works with.

..  _js-url-factory-create-url:

Create a URL object with the JavaScript URL factory
===================================================

:js:`UrlFactory.createUrl(url, parameters)` creates a :js:`URL` object. A
relative URL is resolved against the origin of the current page. The optional
parameters are added to the query string, as described for
:ref:`createSearchParams() <js-url-factory-create-search-params>`.

The following example creates the URL of an
:ref:`Ajax route <ajax-backend>` with some query parameters and passes it to
:ref:`AjaxRequest <ajax-request>`:

..  literalinclude:: _create-url.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/search.js

..  _js-url-factory-create-search-params:

Create URL query parameters with the JavaScript URL factory
===========================================================

:js:`UrlFactory.createSearchParams(parameters)` creates a
:js:`URLSearchParams` object. It accepts a query string, a
:js:`URLSearchParams` object, or an object. Nested objects become parameters
in bracket notation, such as `filter[type]`, and values that are :js:`null` or
:js:`undefined` are left out. Unlike the native constructor, it does not
accept an array of entries. Convert them with :js:`Object.fromEntries()`
first:

..  literalinclude:: _create-search-params.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/parameters.js
