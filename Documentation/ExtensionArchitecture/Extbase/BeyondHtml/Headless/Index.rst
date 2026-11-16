:navigation-title: Headless

..  include:: /Includes.rst.txt
..  index::
    pair: Extbase; Headless
    pair: TYPO3; Headless
..  _extbase-beyond-html-headless:

=========================================
Delivering TYPO3 content headless as JSON
=========================================

In a headless setup, TYPO3 does not render the pages a visitor sees. A
frontend built separately, for example with a JavaScript framework such as
`Next.js <https://nextjs.org/>`_ or `Nuxt <https://nuxt.com/>`_, requests the
content as JSON and renders it itself. TYPO3 stays the place where editors
maintain pages, content, and records. Such a setup is also called *decoupled*.

Dedicated headless content management systems are built around a content
:abbr:`API (Application Programming Interface)`: the frontend asks for
entries of a content type, and the system answers with JSON. TYPO3 works
differently. It is built around the page tree and renders a page for every
URL. TYPO3 Core ships no ready-made JSON API for pages and content, but it
ships the parts to build one: page types, the :typoscript:`PAGEVIEW` content
object, record objects, and Extbase plugins that can render JSON. This
chapter shows how these parts deliver a site headless, with TYPO3 Core alone.

A headless frontend can use TYPO3 in two ways, which differ in which side owns
the pages and their URLs: TYPO3 delivers every page as JSON, or TYPO3 delivers
only data from endpoints.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-model-page:

Delivering every TYPO3 page as JSON to a headless frontend
==========================================================

TYPO3 keeps owning the pages. For every URL of the site, the frontend requests
the same URL from TYPO3 in a JSON representation: the page title, the menu,
the content elements of each content area, and the output of the plugins on
the page. The frontend renders that JSON instead of HTML.

Everything TYPO3 does for a page still applies: the page tree defines the URLs,
routing resolves them, languages and access restrictions are respected, and the
page cache stores the result. Editors keep working as they do on any other
site, and a new page or content element appears in the frontend without a
change to its code. This is the model the community extension
:composer:`friendsoftypo3/headless` implements.

Use this model when TYPO3 is the content source of the whole site.

..  _extbase-beyond-html-headless-model-endpoints:

Delivering only data from TYPO3 endpoints to a headless frontend
================================================================

The frontend owns the pages and their URLs. TYPO3 delivers only data, such as
a list of conferences or the seats left in each one, at URLs of its own. Each
endpoint is one of the
`ways to deliver non-HTML output <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-options>`_
from TYPO3:

*   a `typeNum page type <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-page-type>`_
    that renders an Extbase plugin, with the page cache and the TypoScript
    configuration,
*   an Extbase action that returns JSON, as described in
    `Loading Extbase data with fetch() <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-ajax>`_,
*   a `PSR-15 middleware <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-middleware>`_
    for small endpoints that answer before any page is rendered.

Use this model when the frontend is an application that uses TYPO3 as one data
source among others, or when only some data comes from TYPO3. The rest of this
chapter is about the first model, delivering every page as JSON.


..  _extbase-beyond-html-headless-map:

Building a headless TYPO3 site with Core features
=================================================

The pages of this chapter build the first model step by step:

:ref:`Delivering a TYPO3 page as JSON <extbase-beyond-html-headless-page-json>`
    A page type renders the page with a JSON template instead of the HTML
    template: title, language, menu, and content areas.

:ref:`Delivering content elements as JSON <extbase-beyond-html-headless-content-elements>`
    How the fields of a content element end up in the JSON: text, rich text
    with links, images, and relations.

:ref:`Delivering Extbase plugins in a headless page <extbase-beyond-html-headless-extbase-plugins>`
    How an Extbase plugin renders JSON for its content element, keeps the
    settings the editor chose, and works with or without the page cache.

:ref:`Connecting a headless frontend to TYPO3 <extbase-beyond-html-headless-frontend>`
    What the frontend has to take care of: URLs, cross-origin requests,
    frontend users, caching, and previews.

:ref:`Using a headless extension for TYPO3 <extbase-beyond-html-headless-extensions>`
    How existing headless extensions solve the same tasks, and what to check
    before relying on one.

..  _extbase-beyond-html-headless-extensions-status:

..  note::

    Community extensions provide a JSON API for TYPO3 out of the box. When
    this chapter was written in November 2026, none of them had a stable
    release for TYPO3 v14:

    *   :composer:`friendsoftypo3/headless` supports TYPO3 v14 with the
        release candidate 5.0.0-rc2. Its latest stable release supports
        TYPO3 v12 and v13.
    *   :composer:`friendsoftypo3/headless_news`, which provides JSON
        templates for the news extension, supports TYPO3 up to v13.
    *   :composer:`sourcebroker/t3api` and :composer:`nng/nnrestapi` support
        TYPO3 up to v13.

    Check the current state on their project pages before you decide.


..  _extbase-beyond-html-headless-next:

Next steps for a headless TYPO3 site
====================================

Start with :ref:`Delivering a TYPO3 page as JSON
<extbase-beyond-html-headless-page-json>`: it sets up the page type that the
other pages of this chapter build on. If the frontend needs only some data,
:ref:`Ways to deliver non-HTML output from TYPO3
<extbase-beyond-html-options>` compares the endpoints that deliver it.

..  toctree::
    :titlesonly:
    :hidden:

    PageJson
    ContentElements
    ExtbasePlugins
    Frontend
    Extensions
