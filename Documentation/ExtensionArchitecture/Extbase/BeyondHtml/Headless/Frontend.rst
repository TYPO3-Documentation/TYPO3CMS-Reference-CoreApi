:navigation-title: Connecting the frontend

..  include:: /Includes.rst.txt
..  index::
    pair: Headless; Frontend
    pair: Headless; CORS
..  _extbase-beyond-html-headless-frontend:

=======================================
Connecting a headless frontend to TYPO3
=======================================

With the JSON page type from the previous pages, TYPO3 delivers every page of
the site as JSON. The frontend requests that JSON and renders the page. How it
does so is up to the frontend framework, but some questions concern TYPO3 as
well: which URLs the frontend requests, whether the browser may request them,
how frontend users stay logged in, how long a response may be cached, and how
editors preview their changes.

A frontend renders its pages either in the browser of the visitor, or on a
server of its own, which sends finished HTML to the browser. The second way is
called :abbr:`SSR (server-side rendering)`, and frameworks such as Next.js and
Nuxt support both. Several of the answers below depend on which way the
frontend works.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-frontend-urls:

Mapping URLs between a headless frontend and TYPO3
==================================================

TYPO3 generates every URL in the JSON from the
`base of the site <https://docs.typo3.org/permalink/t3coreapi:sitehandling-basics-base>`_.
There are two common ways to combine it with the address of the frontend.

TYPO3 and the frontend on hosts of their own
    TYPO3 runs at its own host, for example :samp:`https://cms.example.org/`,
    which is the base of the site. The frontend runs at
    :samp:`https://www.example.org/`. To render the page
    :samp:`https://www.example.org/conferences`, the frontend requests
    :samp:`https://cms.example.org/conferences/page.json`. The links in the
    JSON start with the TYPO3 host, and the frontend replaces it with its own
    before it renders them. Files keep the TYPO3 host, because TYPO3 delivers
    them.

TYPO3 and the frontend behind one host
    A reverse proxy in front of both forwards the requests for the JSON, for
    files, and for the backend to TYPO3, and every other request to the
    frontend. The base of the site is the address of the frontend, so the
    links in the JSON are already the URLs the frontend shows. The browser
    talks to one host only, which also avoids the questions of the next two
    sections. TYPO3 has to know that it runs behind a proxy, see
    :confval:`reverseProxyIP <globals-typo3-conf-vars-sys-reverseproxyip>`.

In both setups, the path of a page is the same in TYPO3 and in the frontend.
The frontend can append the suffix of the page type to any path it is asked
for, and TYPO3 resolves the page, its language, and the detail views of its
plugins. The frontend does not need to know the page tree or the routes.


..  _extbase-beyond-html-headless-frontend-cors:

Allowing requests from a headless frontend in the browser
=========================================================

A frontend that renders in the browser and runs at another host than TYPO3
requests the JSON from another origin. Browsers block the response unless it
allows that origin with the header `Access-Control-Allow-Origin`, a mechanism
called :abbr:`CORS (Cross-Origin Resource Sharing)`, see
`Cross-Origin Resource Sharing on MDN <https://developer.mozilla.org/en-US/docs/Web/HTTP/Guides/CORS>`_.
TYPO3 Core sends no such header. The JSON page type can send it:

..  literalinclude:: _snippets/_setup_cors.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

This header is enough for a plain `GET` request. A request with headers of
its own makes the browser ask for permission first, with an `OPTIONS`
request that needs further headers in its answer. Keep the requests for the
page JSON plain `GET` requests.

A frontend that renders on a server requests the JSON from that server, not
from the browser. CORS does not apply to it, and neither does it to a frontend
behind the same host as TYPO3.


..  _extbase-beyond-html-headless-frontend-users:

Frontend users and access restrictions in a headless frontend
=============================================================

TYPO3 checks access to the JSON page type like to any other page. A request
without a logged-in frontend user receives the status `403 Forbidden` for a
page restricted to a user group, and the menu leaves such pages out. The page
cache stores the JSON separately for each combination of user groups.

TYPO3 recognises a logged-in frontend user by the session cookie
`fe_typo_user`. Every request for the JSON has to carry it:

*   A frontend that renders on a server receives the cookie from the browser
    and has to forward it to TYPO3, and it has to pass the cookies TYPO3 sets
    back to the browser.
*   A frontend in the browser at another host does not send the cookie: TYPO3
    sets it with `SameSite=Lax`, which keeps it from requests of other sites.
    Running TYPO3 and the frontend behind one host avoids this.

Logging in is a request of its own. TYPO3 accepts login data only together
with a request token, which is bound to a cookie as well, see
`Request token handling <https://docs.typo3.org/permalink/t3coreapi:csrf-like-request-token-handling>`_.
A login form in the frontend therefore has to get a token from TYPO3 before it
sends the login data, and forward the cookies in both directions.


..  _extbase-beyond-html-headless-frontend-errors:

Error responses of TYPO3 to a headless frontend
===============================================

A URL that does not resolve to a page answers with `404 Not Found`, a
restricted page with `403 Forbidden`. The body of these responses is an
HTML error page, because the
`error handling of the site <https://docs.typo3.org/permalink/t3coreapi:sitehandling-basics-errorhandling>`_
renders it independently of the page type. The frontend decides by the status
code and renders its own error page.


..  _extbase-beyond-html-headless-frontend-caching:

Caching the TYPO3 page JSON in a headless frontend
==================================================

TYPO3 keeps the page JSON in the page cache and clears it when an editor
changes the page or its content. The frontend and the browser know nothing
about these changes.

By default, TYPO3 sends headers that keep browsers and proxies from storing the
response. With
:ref:`config.sendCacheHeaders <t3tsref:confval-config-sendcacheheaders>`,
the JSON page type allows clients to cache a response as long as the page
cache keeps it, and
:ref:`config.sendCacheHeadersForSharedCaches <t3tsref:confval-config-sendcacheheadersforsharedcaches>`
does the same for shared caches such as a reverse proxy only. TYPO3 never
sends such headers for a page with non-cacheable plugins, or for a logged-in
frontend user. A response a client has cached cannot be cleared from TYPO3,
so a long lifetime means that changes appear late.

A frontend that caches pages itself, for example as static files, needs to
know when a page changes. The system extension :composer:`typo3/cms-webhooks`
sends a request to another system when something happens in TYPO3. Out of the
box, it reports changes to page records. Changes to content elements need a
`trigger of your own <https://docs.typo3.org/permalink/typo3/cms-webhooks:custom-triggers>`_.


..  _extbase-beyond-html-headless-frontend-preview:

Previewing pages of a headless frontend from the TYPO3 backend
==============================================================

The :guilabel:`View` button of the backend opens the page at the URL TYPO3
generates from the site base. With TYPO3 and the frontend behind one host,
that is the page of the frontend. With separate hosts, it is the HTML page of
TYPO3, which a headless site may not render at all. A listener to
:ref:`BeforePagePreviewUriGeneratedEvent
<beforepagepreviewurigeneratedevent>` can set the URL of the frontend instead.

A preview of hidden pages, hidden content, or a workspace depends on the
session of the backend user: TYPO3 shows such content only to requests that
carry the backend user's session cookie. A frontend that renders on a server
has to forward that cookie to TYPO3 as well, and must not store the result in
a cache that other visitors receive.


..  _extbase-beyond-html-headless-frontend-next:

Next steps after connecting a headless frontend to TYPO3
========================================================

The chapter has built a headless site with TYPO3 Core alone. Community
extensions solve the same tasks with ready-made configuration.
:ref:`Using a headless extension for TYPO3
<extbase-beyond-html-headless-extensions>` maps their concepts to the parts of
this chapter, and lists what to check before relying on one.
