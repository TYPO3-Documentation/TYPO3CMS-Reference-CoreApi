:navigation-title: Middlewares

..  include:: /Includes.rst.txt
..  index:: Extbase; Middleware
..  _extbase-no-frontend-middleware:

======================
Extbase in middlewares
======================

..  note::

    This page is a work in progress. Content will be added as part of the
    Extbase documentation overhaul.

..  todo::
    Stub page. Planned content: what is available at each point of the
    middleware chain, building a context where none exists, and the
    alternatives that usually fit better. A worked example exists in
    :file:`_snippets/_ConferenceApiMiddleware.php`.

Middlewares inspect and modify the request and response: adding headers,
short-circuiting with a redirect, answering a route directly. Extensions
sometimes want domain data at that point like an API endpoint or a conditional
redirect based on a record.

Whether Extbase can provide it depends entirely on where in the chain the
middleware runs.

The essentials:

*   The site, the language and the frontend TypoScript configuration are
    established by the frontend middleware chain. A middleware running before
    that point has none of them, and Extbase cannot resolve its configuration.
*   A middleware running after the frontend has been prepared has all of it.
    The resolved site and language are available as request attributes, and
    can be tested for rather than assumed.
*   A middleware ordered without constraints may run anywhere in the chain, so
    one that depends on the frontend having been prepared has to say so in its
    registration.
*   Needing to establish a context before Extbase works is a sign the work may
    belong elsewhere: in a plugin behind a route enhancer, in a service called
    from a controller, or expressed directly against the
    :ref:`database API <database>`.

..  warning::

    Do not reference the internal middlewares of the frontend chain by name
    when ordering your own. Several of them, including the one that prepares
    frontend rendering, are marked internal and may be renamed or removed.

..  seealso::

    :ref:`request-handling` for the middleware chain and how middlewares are
    registered and ordered.
