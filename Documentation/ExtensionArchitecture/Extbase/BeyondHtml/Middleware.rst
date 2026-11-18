:navigation-title: Middleware endpoint

..  include:: /Includes.rst.txt
..  index::
    pair: Extbase; Middleware
    pair: Extbase; JSON endpoint
..  _extbase-beyond-html-middleware:

===========================================
Answering a script from a PSR-15 middleware
===========================================

A `middleware <https://docs.typo3.org/permalink/t3coreapi:request-handling>`_
can answer a request before TYPO3 resolves a page. No page is rendered, no
TypoScript is evaluated, and the response is entirely under the extension's
control. For small data that a script requests often, this is the lightest way
TYPO3 offers.

This page shows what such an endpoint needs to deliver its data: a URL within
the site, a place in the middleware chain, and a response. How Extbase
repositories behave in a middleware, and what they need to be told, is
described in :ref:`Extbase in middlewares <extbase-no-frontend-middleware>`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-middleware-when:

When a middleware endpoint fits better than a page type
=======================================================

The :ref:`seats example <extbase-beyond-html-ajax-example>` loads the free
seats of each conference once per page view, from a
:ref:`typeNum page type <extbase-beyond-html-page-type>`. If the list should
stay current while a visitor looks at it, the script asks again every 30
seconds. Every one of these requests runs the frontend of a page type: TYPO3
resolves the page, checks access and loads the TypoScript, only to run one
small query.

A middleware answers the same request with the query alone. In exchange, it
does without what the page brings:

*   No page cache. The middleware runs on every request, and caching is up to
    the extension.
*   No plugin. There is no Extbase controller, no
    :ref:`JsonView <extbase-beyond-html-jsonview>`, no FlexForm and no
    TypoScript configuration. Extbase repositories use their defaults unless
    the middleware supplies storage pages and language itself.
*   No page access checks. The endpoint decides who may read its data.

A middleware fits when the data needs none of these: values that change often,
are requested often, and are the same for everybody or depend only on the site,
the language or the frontend user. When the data depends on what an editor
configured in a content element, a page type is the better tool.


..  _extbase-beyond-html-middleware-endpoint:

A middleware that answers with JSON from Extbase data
=====================================================

The middleware below answers requests to :file:`api/seats.json` with the
same JSON array as the seats action of the page type. Any other request is
passed on to the next middleware:

..  literalinclude:: _snippets/_ConferenceSeatsMiddleware.php
    :caption: EXT:my_extension/Classes/Middleware/ConferenceSeatsMiddleware.php

*   The storage folder comes from a site setting, and the repository method
    passes it to the query, as described in
    :ref:`Supplying storage pages and language from the request attributes
    <extbase-no-frontend-middleware-attributes>`.
    :php:`findUpcomingInFolders()` stands for such a method, and
    :php:`getSeatsLeft()` for the model method of the seats example.
*   :php:`\TYPO3\CMS\Core\Http\JsonResponse` encodes the array and sets the
    content type :php:`application/json`.
*   The response can carry any status code. A request with another method than
    `GET` receives `405 Method Not Allowed` with an `Allow` header.
*   `Cache-Control: no-store` tells browsers and proxies not to keep the
    numbers, because they are meant to be current. Data that may be a little
    older can send a `max-age` instead, and the endpoint can keep expensive
    results in a cache of the
    :ref:`caching framework <caching>`.

The numbers in this example are public. When a table restricts records to
frontend user groups, the middleware has to check the restrictions itself, see
:ref:`Records restricted to frontend user groups in a middleware
<extbase-no-frontend-middleware-access>`.


..  _extbase-beyond-html-middleware-url:

Matching the endpoint URL within the site and language
======================================================

The site middleware stores the result of its URL matching in the
:ref:`routing request attribute <typo3-request-attribute-routing>`. Its method
:php:`getTail()` returns the part of the path that follows the base of the
site language. For :samp:`https://example.org/de/api/seats.json`, with the
language base :samp:`https://example.org/de/`, the tail is
:file:`api/seats.json`.

Comparing the tail instead of the whole path makes the endpoint available in
every site and every language under the same relative URL, and the request
attributes :php:`site` and :php:`language` tell the middleware which one was
requested. A language base without a trailing slash leaves a slash at the start
of the tail, which :php:`trim()` removes.

The list template receives the URL of the endpoint from its action, built from
the base of the current language:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php (excerpt)

    public function listAction(): ResponseInterface
    {
        $language = $this->request->getAttribute('language');
        $this->view->assignMultiple([
            'conferences' => $this->conferenceRepository->findUpcoming(),
            'seatsUrl' => rtrim((string)$language->getBase(), '/') . '/api/seats.json',
        ]);
        return $this->htmlResponse();
    }

The template writes it into the same `data-` attribute as before,
:html:`data-seats-url="{seatsUrl}"`, and the
:ref:`script of the seats example <extbase-beyond-html-ajax-script>` works
unchanged. To ask again every 30 seconds, it calls its function on an
interval:

..  code-block:: javascript
    :caption: EXT:my_extension/Resources/Public/JavaScript/conference-seats.js (excerpt)

    const list = document.querySelector('[data-seats-url]');
    if (list) {
      showSeatsLeft(list);
      setInterval(() => showSeatsLeft(list), 30000);
    }


..  _extbase-beyond-html-middleware-ordering:

Placing the endpoint middleware in the frontend chain
=====================================================

Where the middleware sits in the chain decides what it has available and
which of the frontend's checks apply to it:

..  literalinclude:: _snippets/_RequestMiddlewares_seats.php
    :caption: EXT:my_extension/Configuration/RequestMiddlewares.php

*   After `typo3/cms-frontend/authentication`, the site and the language are
    resolved and the frontend user is known. The frontend authentication runs
    after the maintenance mode, so the endpoint does not answer while the site
    is in maintenance mode.
*   Before `typo3/cms-frontend/page-resolver`, the URL does not have to belong
    to a page. TYPO3 would otherwise answer :file:`api/seats.json` with
    "page not found" before the middleware sees the request.

Middlewares that run later in the chain do not run at all for a request the
endpoint answers. Middlewares that run earlier still process its response on
the way back.

The ordering of middlewares in general, and how to check the calculated order,
is described in :ref:`Ordering a middleware that uses Extbase
<extbase-no-frontend-middleware-ordering>`.


..  _extbase-beyond-html-middleware-next:

Next steps after answering from a middleware
============================================

The endpoint in this example runs Extbase without any of its configuration.
:ref:`Extbase in middlewares <extbase-no-frontend-middleware>` describes what
the repositories do in that situation and what the middleware has to supply.
:ref:`Ways to deliver non-HTML output from TYPO3
<extbase-beyond-html-options>` compares the middleware with the other options.
