:navigation-title: Non-cacheable actions

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Non-cacheable actions
..  _extbase-caching-noncacheable:

=================================================================
Non-cacheable Extbase plugin actions and developer responsibility
=================================================================

Consider a real project: a shop with a large product catalogue and an extensive
filter form, whose visitors abandon a page that does not respond almost
immediately. Rendered fully uncached, the product list takes *tens of seconds*.
Rendered from cache, it comes back in a fraction of a second. That gap is not a
benchmark curiosity — on a shop it is the difference between a sale and a closed
tab. Performance is not an optimisation to add later; it is the feature.

Because the filter runs over POST, none of TYPO3's built-in caching applies to
that list — the same situation as the first example below. The performance has to
be rebuilt by hand, with a custom two-level cache. This is the point the older
Extbase books quietly skipped: they told you to mark an action non-cacheable and
stopped there, as if that were the end of the story. It is the beginning of one.
**The moment the framework's caching no longer applies, keeping the page fast
becomes your job** — and, as that shop showed, the cost of getting it wrong is
measured in real money, not milliseconds.

By default every Extbase plugin action is cacheable: it runs once, and its
rendered output is stored in the page cache and reused for every following
visitor. Some actions cannot work that way — a form that must issue a fresh
token on every request, or a view that shows per-user or live data. For those,
Extbase lets you declare an action **non-cacheable**.

Declaring an action non-cacheable is a small change with a large consequence:
that action is rendered on *every* request, and the performance the page cache
gave you for free becomes your responsibility. This page explains how to make an
action non-cacheable, what it really costs, and how to avoid reaching for it when
a cheaper option exists.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-caching-noncacheable-declare:

Declaring an Extbase plugin action non-cacheable
================================================

Non-cacheable actions are declared in the fourth argument of
:php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()`, using the
same structure as the third (cacheable) argument: an array keyed by controller
class name, with a comma-separated list of action names as the value.

..  literalinclude:: _snippets/_configurePlugin.php
    :caption: EXT:my_extension/ext_localconf.php

Here :php:`list` and :php:`show` are cacheable, while :php:`create` — which
persists a new conference and must not be served from cache — is listed again in
the fourth argument to mark it non-cacheable. An action named in the fourth
argument must also appear in the third; the fourth argument does not *add*
actions, it only flags which of the registered actions are non-cacheable.

..  seealso::

    `Registering a frontend plugin <https://docs.typo3.org/permalink/extbase-registration-frontend-plugin-configure>`_ — the full
    :php:`configurePlugin()` signature and the other arguments.


..  _extbase-caching-noncacheable-userint:

What a non-cacheable Extbase action means: `USER` versus `USER_INT`
===================================================================

An Extbase plugin is rendered on the page as a content object. In its normal,
cacheable state it is a :ref:`USER <t3tsref:cobj-user>` object: TYPO3 runs it
once, writes the result into the page cache, and later requests for that page
never execute the plugin again.

Every request to the plugin resolves to exactly one controller and one action —
that combination is what the request carries. When the resolved action is
non-cacheable, Extbase converts the plugin into a
:ref:`USER_INT <t3tsref:cobj-user-int>` object instead. A USER_INT object is
*non-cached* — it is rendered fresh on every single request, after the page
cache has been read, so its output is never stored. This is the same mechanism
TYPO3 uses for any dynamic content element.

The caching state is therefore decided **per action**, not per plugin. A plugin
that registers :php:`list`, :php:`show` and :php:`create` serves :php:`list` and
:php:`show` from the cache, while a request that resolves to :php:`create` is
rendered uncached — the action the request resolves to is what decides. Actions
that a listed action forwards to, or redirects into, are a separate step; it is
always the primary action of the incoming request that determines whether that
render is cached.

..  note::

    Within a single non-cacheable render, the whole output of that render is
    uncached — :typoscript:`USER_INT` is all or nothing for the request it applies to. You
    cannot keep *part* of a non-cached action's output in the page cache through
    this mechanism. To avoid repeating expensive work inside such an action, cache
    it yourself — see :ref:`extbase-caching-noncacheable-optimise`.

A redirect or an error response is also never cached, even from an action you
declared cacheable: Extbase avoids caching a plugin whose action redirects, so
that the redirect is re-evaluated on every request. The surrounding page cache
is left untouched in that case.


..  _extbase-caching-noncacheable-cost:

The cost of a non-cacheable Extbase action: it runs on every request
====================================================================

A cacheable action pays its cost once. A non-cacheable action pays it on every
request, for every visitor.

Consider a conference list. As a cacheable action, the repository query runs on
the first visit to the page; the resulting HTML is cached and served to everyone
else without touching the database or Extbase again. As a non-cacheable action,
the same query — and the template rendering, and any service calls or API
requests the action makes — runs afresh for every page view. On a busy page that
is the difference between one query and thousands.

..  warning::

    When an action is non-cacheable, TYPO3's page cache no longer protects your
    site from the cost of that action. Every expensive thing the action does —
    database queries, remote API calls, heavy computation — happens on every
    request. Keeping a non-cached action fast is **your** responsibility, not the
    framework's. This is the single most important thing to understand before
    disabling caching.


..  _extbase-caching-noncacheable-when:

When an Extbase action needs to be non-cacheable — and when it does not
=======================================================================

Reach for a non-cacheable action only when the output genuinely cannot be shared
between requests or visitors:

*   a form that must render a fresh :abbr:`CSRF (Cross-Site Request Forgery)`
    token on every request;
*   output that depends on the currently logged-in frontend user;
*   data that must be live on every view (a live counter, a real-time status).

Most plugin actions are **not** in this category. A list or detail view that
shows the same records to everyone is a natural fit for the cache — even when
those records change from time to time. The problem such views actually have is
not "the output is dynamic" but "the cache must be refreshed when the underlying
records change". That is a cache *invalidation* problem, and disabling the cache
is the wrong tool for it:

*   To refresh cached pages when records change, use
    :ref:`cache tags and automatic clearing <extbase-caching-cachetags>` — you
    keep the performance of the cache and give up staleness, instead of giving up
    the cache entirely.

*   Only when the output truly differs per request does non-cacheable rendering
    become the right choice — and then the optimisation techniques below keep the
    cost down.


..  _extbase-caching-noncacheable-optimise:

Keeping a non-cached Extbase plugin fast
========================================

A non-cacheable action loses the page cache, but it does not have to redo *all*
of its work on every request. You can cache the expensive parts yourself. TYPO3
ships a :ref:`caching framework <caching>` for exactly this: you store a computed
value under an identifier and read it back on the next request instead of
recomputing it.

The one decision that shapes everything is, for each piece of output: **does the
cached value need to survive the request?** Output that every visitor shares and
that only changes when a record changes should outlive the request and be reused
across visitors — that calls for a persistent cache of your own, invalidated with
:ref:`cache tags <extbase-caching-cachetags>`. Output that must differ per visitor
and only needs to stay consistent *within* one render should die with the request
— that is what the built-in runtime cache is for. The two examples below apply
this test: the first uses a persistent cache throughout; the second combines both,
a persistent layer for the stable part and a runtime layer for the volatile one.


..  _extbase-caching-noncacheable-optimise-persistent:

Caching rendered HTML in your own persistent cache
--------------------------------------------------

Consider a conference list plugin with a filter form: a free-text search, a set
of filters fed from the conference's own properties (categories, location, …),
sorting options, and pagination. The form submits by **POST**.

This is the case that forces you off the page cache. TYPO3 builds the page cache
identifier from the page arguments — the page ID, the page type, and the
:abbr:`GET (query string)` parameters covered by the :ref:`cHash <caching-architecture-identifier>`.
The `POST` body is **not** part of that identifier. Two visitors who POST different
searches to the same URL therefore resolve to the *same* page cache entry: the
second visitor would be served the first visitor's results. A detail view that
selects its record through a GET parameter with a valid cHash does not have this
problem — that value *is* in the identifier — but a POST filter form does. So the
list action must be non-cacheable, and caching its output becomes your job.

Cache it on two layers:

*   **The outer layer** is the whole rendered list. Its identifier is built from
    every option that shapes the result — the search word, every active filter,
    the sorting, and the pagination page. Hashing the whole normalised demand
    object captures all of them at once. The first visitor with a given
    combination waits for the list to render; the next visitor with the same
    combination is served the stored HTML.

*   **The inner layer** caches each conference teaser separately under its own
    :sql:`<table>_<uid>` identifier. When the outer list has to be rebuilt, the
    teasers that did not change are reused from this layer instead of being
    rendered again.

Tie the two together with :ref:`cache tags <extbase-caching-cachetags>`: tag each
teaser with its own :sql:`<table>_<uid>`, and tag the outer list entry with the
identifier of every teaser it contains. This is what makes invalidation
automatic. Register both caches into the :php:`pages` cache **group**, and
:ref:`Extbase's automatic cache clearing <extbase-caching-autoclearing>` will
flush them by tag on the same record change that flushes the page cache — a
changed conference drops its teaser entry and every list entry that contained it,
with no manual flush code. The next request rebuilds only what was dropped: the
changed conference is rendered afresh, every other teaser still comes from the
inner cache.

..  literalinclude:: _snippets/_ConferenceListCache.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

Both caches here are ones you register yourself, because their entries must
survive the request and be shared between visitors. Registering a custom cache is
a caching-framework task, not an Extbase one — just make sure
to put them in the :php:`pages` group so record changes clear them along with the
page cache. See :ref:`caching-quickstart` and :ref:`caching-developer-registration`
for the :php:`ext_localconf.php` configuration and the service names used above.


..  _extbase-caching-noncacheable-optimise-lifetime:

Setting a lifetime for a self-managed Extbase cache
---------------------------------------------------

A self-managed cache has three settings that together decide whether it serves
the right content, and the lifetime is as important as the other two. The
**identifier** decides *which* entry a request reads. The **tags** decide *when*
an entry is actively flushed. The **lifetime** decides how long an entry may be
served if nothing flushes it — and for the outer list, something crucial does
*not*.

Tag-based flushing is not symmetric. Tagging the list entry with each teaser it
contains means that when a conference **changes or is removed**, its
:sql:`<table>_<uid>` tag flushes every list entry that included it, through
:ref:`automatic cache clearing <extbase-caching-autoclearing>`. But a conference
that is **added** carries no tag that any existing list entry was built with —
the new record was not part of any cached list, so nothing references it and
nothing is flushed. The filtered lists that should now include it keep serving
their old contents until they expire. The same blind spot applies to any change
that bypasses Extbase's write path, and completely to data that lives outside
TYPO3 altogether, so no write event ever fired.
The only saving grace for this scenario is to include the page into the :ref:`TCEMAIN.clearCacheCmd <t3tsref:pagetcemain-clearcachecmd>`
list, but this comes with the cost, that absolutely each change in the storage folder will invalidate
absolutely all cache entries, which is usually expensive and therefor not wanted.

The lifetime is what closes that gap, which is why it is worth choosing
deliberately. We recommend not relying on the backend's default lifetime: if you
omit the fourth argument of :php:`set()`, the entry inherits whatever the cache
backend is configured with — a value the *integrator* chose for scenarios you may
know nothing about, and possibly unlimited. Passing an explicit lifetime, sized to
how the data actually changes, keeps that decision in your hands:

*   The **outer list** works well with a rather short lifetime — a day in the example,
    less for a busy, fast-moving catalogue — because an addition will not flush
    it. That lifetime becomes the ceiling on how long a newly added record can
    stay invisible. Decide by how long stale or invisible data is acceptable and set this
    as the value.

*   Each **teaser** can take a long lifetime — a year in the example — because it
    is flushed by its own tag the moment its conference changes, and if the
    conference is removed it will simply never requested again.
    A stale cache entry does not hurt, so a long lifetime costs nothing here.

The right values are a trade-off between freshness and load, and only you know the
data. The guideline is simply to let each :php:`set()` state its lifetime on
purpose, rather than inherit one by leaving the argument out.


..  _extbase-caching-noncacheable-optimise-runtime:

Mixing a persistent and a runtime cache in one non-cacheable action
-------------------------------------------------------------------

Now the harder case: a conference detail view that is fully cacheable — except for
one section in the middle of the content, "conferences you might find
interesting", that must be picked fresh for every visitor.

First, the reassuring part: **a detail view with no dynamic parts needs none of
this.** If everything on the page is the same for every visitor, leave the action
cacheable and let the page cache do its job — a GET record id with a valid cHash
already gives each record its own page cache entry. Reach for the techniques below
only when a genuinely per-visitor fragment is mixed into otherwise stable output.

It is tempting to keep the detail action cacheable and render just the strip as a
:ref:`USER_INT <t3tsref:cobj-user-int>` island. **This does not work from inside
the plugin's template.** A ViewHelper such as
:ref:`f:cObject <t3viewhelper:typo3-fluid-cobject>` renders its target
inline, at the moment the detail plugin is rendered — which is cache-generation
time. Its output is baked into the plugin's cached HTML, exactly as if it had
never been dynamic. TYPO3 only promotes a *top-level* content object to USER_INT;
it cannot turn a fragment nested inside an already-cached plugin into a live
island, and core ships no ViewHelper that suppresses caching for a wrapped block.
Rendering the strip through a *separate* plugin would work — a separate content
object can be USER_INT — but for the sake of this example the strip sits in the thick of the detail
content, not at its edge, so a second content element the editor places elsewhere
is not a realistic layout. The detail action therefore has to be non-cacheable,
and, as in the list example, caching becomes your job.

The trick is to rebuild, by hand, what the page cache does with its own USER_INT
markers: cache the stable HTML **with a placeholder** where the dynamic strip
belongs, and substitute the freshly rendered strip into that placeholder on every
request. This uses both cache lifetimes at once:

*   **The outer layer** is the whole detail view, including a fixed placeholder
    marker (an HTML comment such as :html:`<!--###RECOMMENDATIONS###-->`) rendered by
    the template where the strip should appear. This HTML is identical for every
    visitor and changes only when the record changes, so it goes in a
    **persistent** cache, tagged with the record's :sql:`<table>_<uid>` so a
    change flushes exactly this entry. It is rendered once and reused across
    visitors.

*   **The inner layer** is the recommendations strip. It must differ per visitor
    and per revisit, so it goes in the **runtime** cache: computed at most once
    per request, consistent wherever the render refers to it, and gone when the
    request ends.

The final step is a plain :php:`str_replace()` of the placeholder with the strip.
The substituted result is passed straight to the response and is **never written
back to the cache** — only the placeholder version is stored — so the marker
survives in the cached copy and every request can splice again. String
substitution is all core itself does here.

..  literalinclude:: _snippets/_RecommendationsCache.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The runtime cache is registered by TYPO3 out of the box; you inject it by its
service name and use it immediately. The persistent detail cache is one you
register yourself, exactly as in the list example.

..  seealso::

    *   `Caching framework: register your own cache <https://docs.typo3.org/permalink/t3coreapi:caching-quickstart>`_
        — how to add a persistent cache in :php:`ext_localconf.php`.

    *   `Extbase cache tags and automatic clearing <https://docs.typo3.org/permalink/extbase-caching-cachetags>`_
        — tagging cache entries and flushing them when records change.
