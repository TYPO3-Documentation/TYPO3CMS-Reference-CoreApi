:navigation-title: Middlewares

..  include:: /Includes.rst.txt
..  index:: Extbase; Middleware
..  _extbase-no-frontend-middleware:

======================
Extbase in middlewares
======================

Middlewares inspect and modify the request and response: adding headers,
short-circuiting with a redirect, answering a route directly. Extensions
sometimes want domain data at that point, like an API endpoint or a
conditional redirect based on a record.

A middleware runs inside a request, but Extbase does not see that request.
Extbase reads its configuration from the request its own bootstrap hands it
when a plugin or a module runs, or from the global request, which TYPO3 sets
only after the whole middleware chain has run. In a middleware, Extbase is
therefore in the same situation as in a command, wherever the middleware sits
in the chain. What differs is how much the request already knows, and with
that, what the middleware can tell Extbase itself.

How middlewares are written, registered and ordered is described in
:ref:`Middlewares (request handling) <request-handling>`.

..  contents:: Table of contents
    :local:


..  _extbase-no-frontend-middleware-chain:

What a middleware has at each point of the frontend chain
=========================================================

The frontend middleware chain adds to the request step by step. For the use of
Extbase, three points matter:

Before the site is resolved
    The request has no `site` and no `language` attribute. The middleware
    cannot tell which site the request belongs to.

After the site is resolved
    The `site` and `language` request attributes are set by the middleware
    `typo3/cms-frontend/site`. The site's settings, its languages and its
    configuration are available. After `typo3/cms-frontend/authentication`,
    the frontend user is known as well.

After the frontend is prepared
    The page, its TypoScript and the language of the page are established.
    The middleware that does this is internal, and the full TypoScript is
    only calculated when the page is not delivered from the cache.

At none of these points can Extbase read its own configuration. Repositories
work, with the same defaults as in a command: storagePid `0`, no
:typoscript:`recursive` setting, and the default language until the frontend
has been prepared. See :ref:`What Extbase persistence does without a request
<extbase-no-frontend-command-persistence>`.

Handing the request to Extbase does not change that reliably. Before the
frontend is prepared there is no TypoScript to read, and every query throws an
exception. Afterwards it depends on whether the page came from the cache.


..  _extbase-no-frontend-middleware-attributes:

Supplying storage pages and language from the request attributes
================================================================

After the site is resolved, the request carries what Extbase is missing, and
a middleware can pass it to the query itself. A middleware that answers a JSON
endpoint with conferences could look like this:

..  literalinclude:: _snippets/_ConferenceApiMiddleware.php
    :caption: EXT:my_extension/Classes/Middleware/ConferenceApiMiddleware.php
    :visible-lines: 17-57

The middleware tests for the attributes rather than assuming them. A URL that
belongs to no site has neither, and the middleware hands the request on.

The storage folder comes from a :ref:`site setting <sitehandling-settings>`.
Each site can then name its own folder, and the middleware needs no
TypoScript. The extension can define the setting in its site set:

..  literalinclude:: _snippets/_settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/settings.definitions.yaml

The language aspect is built from the `language` attribute, the same way the
frontend builds it for the page, see :ref:`Setting the language explicitly
<extbase-localisation-no-frontend-explicit>`. A repository method can take
both as arguments:

..  literalinclude:: _snippets/_ConferenceApiRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php
    :visible-lines: 14-31

It is recommended to pass the language aspect to the query settings like this
rather than to change the language aspect of the global context. The context
is shared by everything that runs later in the request.


..  _extbase-no-frontend-middleware-access:

Records restricted to frontend user groups in a middleware
==========================================================

Extbase decides which visibility rules apply by looking at the global
request. In a middleware there is none yet, so Extbase applies the rules it
uses outside the frontend: hidden records and records outside their start
and end time are left out, but restrictions to frontend user groups are not
checked.

..  warning::

    A middleware that returns records of a table with access restrictions can
    expose records that are meant for logged-in users only. Add a constraint
    for the access field to the query, or read such records with the
    :ref:`database API <database>` and the
    :php:`\TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer`,
    which checks the user groups, see :ref:`Restriction builder
    <database-restriction-builder>`. Either way, the middleware then has to
    run after `typo3/cms-frontend/authentication`, which establishes the
    frontend user.


..  _extbase-no-frontend-middleware-ordering:

Ordering a middleware that uses Extbase
=======================================

A middleware that needs the site has to run after `typo3/cms-frontend/site`,
and it has to say so in its registration. A middleware ordered without
constraints may run anywhere in the chain. An API endpoint can also run
before `typo3/cms-frontend/page-resolver`, so that its URL does not have to
be a page:

..  literalinclude:: _snippets/_RequestMiddlewares.php
    :caption: EXT:my_extension/Configuration/RequestMiddlewares.php

..  warning::

    Do not reference the internal middlewares of the frontend chain by name
    when ordering your own. Several of them, including the one that prepares
    frontend rendering, are marked internal and may be renamed or removed.

The calculated order is shown in the :guilabel:`System > Configuration`
module, see :ref:`Configuring middlewares
<request-handling-configuring-middlewares>`.


..  _extbase-no-frontend-middleware-alternatives:

When the work belongs somewhere else than a middleware
======================================================

Having to supply storage pages, language and access rules by hand is a sign
the work may fit better elsewhere:

*   **An Extbase plugin.** A plugin gets its configuration, its storage pages
    and the frontend's visibility rules from Extbase. Placed on a page of its
    own, with a page type and a route enhancer, it can answer JSON as well,
    see :ref:`Routing in Extbase <extbase-routing>`.
*   **A service called from a controller**, when the middleware only exists to
    prepare data for a plugin.
*   **The database API**, when the middleware only needs a few fields. With
    the frontend restriction container it applies the same visibility rules as
    the frontend, needs no configuration, and costs less than Extbase in a
    request that is otherwise served from the cache,
    see :ref:`Using Extbase <request-handling-middlewares-extbase>` in the
    middleware documentation.


..  _extbase-no-frontend-middleware-next:

Next steps for Extbase in middlewares
=====================================

A command meets the same defaults with no request at all. How to work with
them there is described in :ref:`Extbase on the command line
<extbase-no-frontend-command>`.

The overview of all contexts without a frontend is in :ref:`Using Extbase
outside a frontend request <extbase-no-frontend>`.
