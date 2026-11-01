:navigation-title: Troubleshooting

..  include:: /Includes.rst.txt
..  index:: Routing; Troubleshooting
..  _routing-troubleshooting:

=======================
Troubleshooting routing
=======================

A route enhancer that does not fit a request or a link rarely raises an error.
TYPO3 uses the next route that fits, and in the end the plain page URL. The
symptoms are therefore a page where a 404 error was expected, or a URL that
still contains query parameters.

..  contents:: Table of contents

..  _routing-troubleshooting-missing-404:

An invalid URL shows a page instead of a 404 error
==================================================

A :yaml:`routePath` that consists of nothing but a variable matches every
single path segment below a page. With the following configuration,
`https://example.org/does-not-exist` shows the root page with the HTTP status
code 200, and `does-not-exist` is passed to the plugin as an argument:

..  literalinclude:: _codesnippets/_routeWithoutSegment.yaml
    :caption: config/sites/my-site/config.yaml (excerpt)

Without further information, TYPO3 cannot tell whether a value is valid.
:yaml:`limitToPages` limits the problem to the listed pages, but does not solve
it. Use at least one of these options, so that an invalid value leads to a 404
error:

*   Add a static segment to the route, for example `/show/{news_title}`.
*   Add an aspect to the variable, for example a
    `PersistedAliasMapper <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-persistedaliasmapper>`_,
    which only accepts values of existing records.
*   Add a :yaml:`requirements` rule for the variable.

..  literalinclude:: _codesnippets/_routeWithSegment.yaml
    :caption: config/sites/my-site/config.yaml (excerpt)

..  note::
    :yaml:`requirements` of an Extbase plugin enhancer belong on the level of
    the enhancer. Inside an entry of :yaml:`routes` they have no effect.

..  _routing-troubleshooting-query-parameters:

A generated URL still contains query parameters
===============================================

If no route fits the arguments of a link, TYPO3 generates the URL of the page
and appends the arguments as query parameters. Check the following causes:

*   No route contains this combination of arguments. You need a separate
    :yaml:`routePath` for each combination, for example for a list with and
    without pagination.
*   The value is unknown to the aspect. A
    `StaticValueMapper <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-staticvaluemapper>`_
    with the entry :yaml:`march: '03'` generates `/news/march` for the value
    `03`, but not for the value `3`. Compare the format of the value in the
    link with the values of the aspect, including leading zeros.
*   The value is empty. Leave out the argument instead of linking with an empty
    value such as `tx_news_pi1[category]=`.

..  _routing-troubleshooting-optional-variable:

An optional variable does not work with the PageType decorator
==============================================================

:yaml:`defaults` make a variable optional only if it is at the very end of the
:yaml:`routePath`. The
`PageType decorator <https://docs.typo3.org/permalink/t3coreapi:routing-pagetype-decorator>`_
appends its suffix, such as `/` or `.html`, to the path of each route, so the
variable is no longer the last part and a value is required.

Weakening the rule with :yaml:`requirements` and `.*` is not a solution. It
leads to URLs like `/news/category//` and `/news/category/.html`.

Configure one route with the variable and one route without it, and do not use
:yaml:`defaults` for this variable. This generates `/news/category/` and
`/news/category/my-category/`:

..  literalinclude:: _codesnippets/_routesInsteadOfDefaults.yaml
    :caption: config/sites/my-site/config.yaml (excerpt)

..  _routing-troubleshooting-ambiguous-routes:

The wrong route is used
=======================

Several routes can fit the same URL. For an incoming URL, the routes of an
enhancer are tested in the order of their configuration, and the first match
wins. A route is skipped if an aspect of the route cannot resolve the value.

This has the following consequences for routes like `/{news_title}` and
`/{category_name}`, which have the same structure:

*   If all of them have an aspect, the URL resolves to the route with the
    matching record or value.
*   A route without an aspect accepts every value, so the routes after it are
    never reached. Add an aspect, or move this route to the end of the list.

When generating a URL, :yaml:`defaults` make a route fit even though the link
does not supply all of its arguments. With a default value for `page` and the
route `/page-{page}`, a list view without any argument can get the URL
`/news/page` instead of `/news/`. Avoid :yaml:`defaults` where possible, and
configure a separate route for each case, such as `/` for the list view.

..  _routing-troubleshooting-same-plugin:

Only the last enhancer of an Extbase plugin works
=================================================

If two Extbase plugin enhancers for the same plugin apply to a page, only the
last one has an effect, both for generating and for resolving URLs. The routes
of the first one lead to a 404 error.

Use :yaml:`limitToPages` to assign each enhancer to different pages. This way,
one plugin can use different URLs in different areas of the website:

..  literalinclude:: _codesnippets/_samePluginLimitToPages.yaml
    :caption: config/sites/my-site/config.yaml (excerpt)

..  _routing-troubleshooting-mapper-range:

Possible range of all mappers is larger than 10000 items
========================================================

To prevent cache flooding, the number of combinations in a route is limited.
TYPO3 multiplies the number of items of all static, countable mappers of a
route, such as the
`StaticRangeMapper <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-staticrangemapper>`_.
If the result is larger than 10000, the exception `1537696772` is thrown, when
generating as well as when resolving URLs:

*   12 months × 30 years × 25 pages = 9000 combinations are allowed.
*   12 months × 30 years × 30 pages = 10800 combinations are not allowed.

Reduce one of the ranges, or use a
`custom aspect <https://docs.typo3.org/permalink/t3coreapi:routing-custom-aspects>`_
that does not implement :php:`\Countable`.

A single :yaml:`StaticRangeMapper` is limited to 1000 items. A larger range
throws the exception `1537696771`.
