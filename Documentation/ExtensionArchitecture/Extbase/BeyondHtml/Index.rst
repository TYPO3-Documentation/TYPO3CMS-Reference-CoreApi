:navigation-title: Beyond HTML

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; AJAX
..  _extbase-beyond-html:

====================
Beyond HTML delivery
====================

An Extbase plugin usually renders HTML into a page. Sooner or later an
extension might need something else: JSON for a script that updates part of the
page, XML for a feed, an HTML fragment that replaces a list without reloading
the page, or data for a frontend built with a separate JavaScript framework.

TYPO3 offers several ways to deliver such output. They differ in what they
have available when they run: the site and language, the frontend
user information, the TypoScript configuration, the page cache, and the Extbase plugin
machinery itself. Choosing between them is mostly a question of which of these
the output actually needs.

..  _extbase-beyond-html-options:

Ways to deliver non-HTML output from TYPO3
==========================================

..  list-table::
    :header-rows: 1
    :widths: 25 45 30

    *   -   Option
        -   What it has available
        -   Suited for

    *   -   :ref:`The regular page <extbase-beyond-html-option-regular-page>`
        -   Everything a page has, including the page cache
        -   Reloading part of a page

    *   -   :ref:`A typeNum page type <extbase-beyond-html-option-page-type>`
        -   Everything a page has, including the page cache
        -   Feeds, sitemaps, exports, parts of a page loaded by a script

    *   -   :ref:`A plugin action returning non-HTML on a regular page
            <extbase-beyond-html-option-plugin-on-page>`
        -   Everything a page has
        -   Custom: yours to decide

    *   -   :ref:`throwStatus() in an Extbase action
            <extbase-beyond-html-option-throw-status>`
        -   Everything a page has, up to the action
        -   Error responses

    *   -   :ref:`A PSR-15 middleware <extbase-beyond-html-option-middleware>`
        -   Depends on its position in the middleware chain; no page cache, no
            Extbase controller
        -   Small data endpoints

    *   -   :ref:`An eID script <extbase-beyond-html-option-eid>`
        -   Site; no frontend user, page or TypoScript
        -   Maintaining existing code

    *   -   :ref:`A backend AJAX route <extbase-beyond-html-option-backend-ajax>`
        -   Backend user and backend context
        -   Backend modules only

    *   -   :ref:`A headless setup <extbase-beyond-html-option-headless>`
        -   Depends on the solution
        -   A frontend built separately from TYPO3

..  _extbase-beyond-html-option-regular-page:

Requesting the regular page and using part of it
================================================

A script can request the regular page URL, for example with
`fetch() <https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API>`_, and
take the element it needs out of the returned HTML. A filter or a pagination
that reloads a list without reloading the page works this way. Nothing has to
be configured: the plugin, its content element, its links and the page cache
behave exactly as they do for a visitor. The cost is that the whole page is
transferred, which is cheap when it comes from the page cache. Because the page
works without the script as well, this also suits
`progressive enhancement <https://developer.mozilla.org/en-US/docs/Glossary/Progressive_Enhancement>`_.

..  _extbase-beyond-html-option-page-type:

Rendering the plugin in a typeNum page type
===========================================

A dedicated TypoScript :typoscript:`PAGE` object with its own
:typoscript:`typeNum` renders the plugin instead of the page template. It is
the most widespread approach. The output is another representation of the
page, with its site, language, access checks and page cache. Rendering the
plugin's content element keeps the settings an editor chose, so a list page
can offer its own selection as a feed. A page type also delivers parts of a
page that a script loads, such as the next page of a list.

..  seealso::

    `Delivering Extbase output with a typeNum page type <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-page-type>`_
    — how it works, what it costs, and when it is the right tool.

..  _extbase-beyond-html-option-plugin-on-page:

Returning non-HTML from a plugin action on a regular page
=========================================================

An action of a plugin placed on a regular page can return
:php:`$this->jsonResponse()`. Extbase does not replace the page with it. The
JSON is inserted into the page HTML like any other plugin output, and the
:php:`Content-Type` header of the action's response becomes the content type
of the whole page. The visitor receives an HTML page that declares itself as
JSON. This is a common mistake rather than an option, see
the pitfall :ref:`An action returning JSON breaks the page <extbase-appendix-pitfalls-json-on-html-page>`.
Proceeding that way or with another output format might be a suitable course
of action, but the handling of how the frontend copes is fully up to the
developer.

..  _extbase-beyond-html-option-throw-status:

Ending the request from an Extbase action with throwStatus()
============================================================

:php:`ActionController::throwStatus()` stops the rendering of the page and
sends a response with the given status code and content instead. It is meant
for an action that has to answer with an error, such as `404 Not Found` or
`403 Forbidden`. It accepts content, which makes it look like a way to send
data. It sets no content type, though, and the exception it throws is
internal to TYPO3, so it is not an endpoint for data.

..  _extbase-beyond-html-option-middleware:

Answering in a PSR-15 middleware
================================

A `middleware <https://docs.typo3.org/permalink/t3coreapi:request-handling>`_
can answer a request before any page is rendered. For a small endpoint that
returns a few values, it is the lightest option: no page rendering, no
TypoScript evaluation, and a response that is entirely under the extension's
control.

What a middleware has available depends on where it is placed in the chain.
After the site has been resolved, the site and language are available as
request attributes; after frontend user authentication, the frontend user is.
No Extbase controller is dispatched there, and repositories need their
configuration established first, see
:ref:`Extbase in middlewares <extbase-no-frontend-middleware>`.

..  _extbase-beyond-html-option-eid:

Using an eID script
===================

A request with the query parameter `eID` is dispatched to the target
registered for that name in
:confval:`$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include'] <typo3-conf-vars-fe-eid-include>`.
The core uses this itself, for example to
`deliver files of non-public storages <https://docs.typo3.org/permalink/t3coreapi:fal-using-fal-examples-file-folder-eid>`_.

eID is not deprecated, but it is not a choice for new code. It is handled by a
middleware that the core marks as internal and as possibly removed in the
future. In the current order of the middleware chain it runs after the site
has been resolved, although nothing in its registration guarantees that, and
before maintenance mode, frontend user authentication, page resolution, and
TypoScript. An eID script therefore has no frontend user and no TypoScript,
and it answers even while the site is in maintenance mode. A middleware of
the extension's own, placed where it has what it needs, does the same job
without these limitations.

..  _extbase-beyond-html-option-backend-ajax:

Backend AJAX routes are for the backend only
============================================

`Backend AJAX routes <https://docs.typo3.org/permalink/t3coreapi:ajax-backend>`_
answer requests from backend modules. They require a logged-in backend user
and run in the backend context, so they are not available to the frontend,
however convenient their registration looks.

..  _extbase-beyond-html-option-headless:

Delivering content to a headless frontend
=========================================

In a headless or decoupled setup, a frontend built separately, for example
with a JavaScript framework such as `Next.js <https://nextjs.org/>`_ or
`Nuxt <https://nuxt.com/>`_, requests content from TYPO3 as JSON and renders
it itself. The community extension :composer:`friendsoftypo3/headless`
outputs TYPO3 content in JSON format for such setups. Extbase can supply the
data, while Fluid templates have no role in the output.

..  Planned pages of this chapter, placement and order TBD: AJAX with fetch()
    and a non-cacheable action, JsonView (moved here from View/Index.rst), a
    middleware endpoint, and headless delivery.

..  toctree::
    :titlesonly:
    :hidden:

    PageType
