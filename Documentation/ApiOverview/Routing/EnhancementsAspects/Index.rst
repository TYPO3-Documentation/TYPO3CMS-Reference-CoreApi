:navigation-title: Route Enhancements and Aspects
..  include:: /Includes.rst.txt
..  index::
    Routing; Advanced configuration
    pair: Routing; Extensions
..  _routing-advanced-routing-configuration:

==============================================
Route Enhancements and Aspects: for extensions
==============================================

..  contents:: Table of contents
    :local:

While page-based routing works out of the box, routing for extensions has to be
configured explicitly in your :ref:`site configuration <sitehandling>`.

..  note::
    There is no graphical user interface for configuring extended
    routing. All adjustments need to be made by manually editing your website's
    :file:`config.yaml` site configuration file (located in
    :file:`config/sites/<yoursite>/config.yaml`).

Enhancers and aspects are an important concept in TYPO3 and they are used to map
GET parameters to routes.

An :ref:`enhancer <routing-advanced-routing-configuration-enhancers>` creates
variations of a specific page-based route for a specific purpose (e.g. an
:ref:`Extbase <extbase>` plugin) and "enhances" an existing route path, which
can contain flexible values, so-called "placeholders".

:ref:`Aspects <routing-advanced-routing-configuration-aspects>` can
be registered for a specific enhancer to modify placeholders, adding static,
human readable names within the route path or dynamically generated values.

To give you an overview of what the distinction is, imagine a web page which
is available at

:samp:`https://example.org/path-to/my-page`

(the path mirrors the page structure in the backend) and has page ID *13*.

Enhancers can transform this route to:

:samp:`https://example.org/path-to/my-page/products/<product-name>`

An enhancer adds the suffix `/products/<product-name>` to the base route of the
page. The enhancer uses a placeholder variable which is resolved statically,
dynamically or built by an aspect or "mapper".

It is possible to use the same enhancer multiple times with different
configurations. Be aware that it is not possible to combine multiple variants /
enhancers matching multiple configurations.

However, custom enhancers can be created for special use cases, for
example, when two plugins with multiple parameters each could be configured.
Otherwise, the first variant matching the URL parameters is used for generating
and resolving the route.

..  index:: Routing; Enhancers

..  _routing-advanced-routing-configuration-enhancers:

Routing Enhancers
=================

..  tip::

    See :ref:`routing-terminology` for an introduction to the used
    terminology here.

There are two types of enhancers: route decorators and route enhancers. A route
enhancer replaces a set of placeholders, inserts URL parameters
during URL generation and then resolves them properly later. The substitution of
values with aliases can be done by aspects. To simplify, a route enhancer
specifies what the full route path looks like and which variables are available,
whereas an aspect maps a single variable to a value.

TYPO3 comes with the following route enhancers out of the box:

-   :ref:`Simple enhancer <routing-simple-enhancer>`
    (enhancer type :yaml:`Simple`)
-   :ref:`Plugin enhancer <routing-plugin-enhancer>`
    (enhancer type :yaml:`Plugin`)
-   :ref:`Extbase plugin enhancer <routing-extbase-plugin-enhancer>`
    (enhancer type :yaml:`Extbase`)

TYPO3 provides the following route decorator out of the box:

-   :ref:`Page type decorator <routing-pagetype-decorator>`
    (enhancer type :yaml:`PageType`)

Custom enhancers can be registered by adding an entry to an extension's
:file:`ext_localconf.php` file:


..  literalinclude:: _codesnippets/_ext_localconf.php
    :caption: EXT:my_extension/ext_localconf.php

Within a configuration, an enhancer always evaluates the following properties:

:yaml:`type`
    The short name of the enhancer as registered within
    :php:`$GLOBALS['TYPO3_CONF_VARS']`. This is mandatory.

:yaml:`limitToPages`
    An array of page IDs where this enhancer should be called. This is optional.
    This property (array) triggers an enhancer only for specific pages. In case
    of special plugin pages, it is recommended to enhance only those pages with
    the plugin to speed up performance of building page routes of all other
    pages.

All enhancers allow to configure at least one route with the following
configuration:

:yaml:`defaults`
    Defines which URL parameters are optional. If the parameters are omitted
    during generation, they can receive a default value and do not need a
    placeholder - it is possible to add them at the very end of the
    :yaml:`routePath`.

:yaml:`requirements`
    Specifies exactly what kind of parameter should be added to that route as a
    `regular expressions <https://regex101.com/>`__. This way it is configurable
    to allow only integer values, for example for pagination.

    Make sure you define your requirements as strict as possible. This is
    necessary so that performance is not reduced and to allow TYPO3 to match the
    expected route.

:yaml:`_arguments`
    Defines what route parameters should be available to the system. In the
    following example, the placeholder is called :yaml:`category_id`, but the
    URL generation receives the argument :yaml:`category`. It is mapped to that
    name (so you can access/use it as :php:`category` in your custom code).

TYPO3 will add the parameter ``cHash`` to URLs when necessary, see :ref:`chash`.
The ``cHash`` can be removed by converting dynamic arguments into static
arguments. All captured arguments are dynamic by default. They can be converted
to static arguments by defining the possible expected values for these
arguments. This is done by adding :ref:`aspects
<routing-advanced-routing-configuration-aspects>` for those arguments to provide
a static list of expected values.

..  index:: Routing; Simple Enhancer
..  _routing-simple-enhancer:

Simple enhancer
---------------

The simple enhancer works with route arguments. It maps them to an
argument to make a URL that can be used later.

..  code-block:: none

    index.php?id=13&category=241&tag=Benni

results in

..  code-block:: none

    https://example.org/path-to/my-page/show-by-category/241/Benni

The configuration looks like this:

..  literalinclude:: _codesnippets/_routeEnhancers.yaml

:yaml:`routePath`
    defines the static keyword and the placeholders.
:yaml:`requirements`
    defines parts that should be replaced in the :yaml:`routePath`. `Regular
    expressions <https://regex101.com/>`__ limit the allowed chars to be used in those parts.
:yaml:`_arguments`
    defines the mapping from the placeholder in the :yaml:`routePath` to the
    name of the parameter in the URL as it would appear without enhancement.
    Note that it is also possible to map to nested parameters by providing a
    path-like parameter name. For example, specifying `my_array/my_key` as the
    parameter name would set the GET parameter `my_array[my_key]` to the value
    of the specified placeholder.

..  note::
    For people coming from :composer:`dmitryd/typo3-realurl` in previous TYPO3 versions: The
    :yaml:`routePath` can be loosely compared to some as "postVarSets".

..  index:: Routing; Plugin Enhancer
..  _routing-plugin-enhancer:

Plugin enhancer
---------------

The plugin enhancer works with plugins based on Core functionality.

In this example we will map the raw parameters of an URL like this:

..  code-block:: none

    https://example.org/path-to/my-page?id=13&tx_felogin_pi1[forgot]=1&tx_felogin_pi1[user]=82&tx_felogin_pi1[hash]=ABCDEFGHIJKLMNOPQRSTUVWXYZ012345

The result will be an URL like this:

..  code-block:: none

    https://example.org/path-to/my-page/forgot-password/82/ABCDEFGHIJKLMNOPQRSTUVWXYZ012345

The base for the plugin enhancer is the configuration of a so-called
"namespace", in this case `tx_felogin_pi1` - the plugin's namespace.

The plugin enhancer explicitly sets exactly one additional variation for a
specific use case. For the :doc:`frontend login <ext_felogin:Index>`, we
would need to set up two configurations of the plugin enhancer for
"forgot password" and "recover password".

..  literalinclude:: _codesnippets/_pluginEnhancer.yaml
    :caption: config/sites/my-site/config.yaml

If a URL is generated with the above parameters the resulting link
will be this:

..  code-block:: none

    https://example.org/path-to/my-page/forgot-password/82/ABCDEFGHIJKLMNOPQRSTUVWXYZ012345

..  note::
    If the input given to generate the URL does not match, the
    route enhancer is not triggered, and the parameters are added to
    the URL as normal query parameters. For example, if the user parameter
    is more than three characters or non-numeric, this enhancer would not
    match.

As you see, the plugin enhancer is used to specify placeholders and
requirements with a given namespace.

If you want to replace the user ID (in this example "82") with a username,
you would need an aspect that can be registered within any enhancer, see
:ref:`below for details <routing-advanced-routing-configuration-aspects>`.

..  index:: Routing; Extbase Plugin Enhancer
..  _routing-extbase-plugin-enhancer:

Extbase plugin enhancer
-----------------------

When creating :ref:`Extbase <extbase>` plugins, it is very common to have
multiple controller/action combinations. Therefore, the Extbase plugin enhancer
is an extension to the :ref:`regular plugin enhancer
<routing-plugin-enhancer>` and provides the
functionality to generate multiple variants, typically based on the available
controller/action pairs.

The Extbase plugin enhancer with the configuration below would now apply to the
following URLs:

..  code-block:: none

    index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list
    index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list&tx_news_pi1[page]=5
    index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list&tx_news_pi1[year]=2018&tx_news_pi1[month]=8
    index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=13
    index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=tag&tx_news_pi1[tag]=11

And generate the following URLs:

..  code-block:: none

    https://example.org/path-to/my-page/list/
    https://example.org/path-to/my-page/list/5
    https://example.org/path-to/my-page/list/2018/8
    https://example.org/path-to/my-page/detail/in-the-year-2525
    https://example.org/path-to/my-page/tag/future

..  literalinclude:: _codesnippets/_extbasePluginEnhancer.yaml

In this example, the :yaml:`_arguments` parameter is used to set sub-properties
of an array, which is typically used within demand objects for filtering
functionality. Additionally, it is using both the short and the long form of
writing route configurations.

Instead of using the combination of :yaml:`extension` and :yaml:`plugin` one can
also provide the :yaml:`namespace` property as in the
:ref:`regular plugin enhancer <routing-plugin-enhancer>`:

..  literalinclude:: _codesnippets/_extbasePluginEnhancerNamespace.yaml
    :emphasize-lines: 5
    :caption: config/sites/my-site/config.yaml

..  versionchanged:: 12.2
    Prior to version 12.2 the combination of :yaml:`extension` and
    :yaml:`plugin` was preferred when all three properties are given. Since
    v12.2 the :yaml:`namespace` property has precedence.


To understand what is happening in the :yaml:`aspects` part, read on.

..  attention::
    Please ensure not to register the same :yaml:`routePath` more than once, for
    example through multiple extensions. In that case, the enhancer imported
    last will override any duplicate routes that are in place.

..  index:: Routing; PageType decorator
..  _routing-pagetype-decorator:

PageType decorator
------------------

The PageType enhancer (route decorator) allows to add a suffix to the existing route
(including existing other enhancers) to map a page type (GET parameter `&type=`)
to a suffix.

It is possible to map various page types to endings:

Example in TypoScript:

..  literalinclude:: _codesnippets/_pages.typoscript
    :caption: config/sites/my-site/setup.typoscript

Now we configure the enhancer in your site's :file:`config.yaml` file like this:

..  literalinclude:: _codesnippets/_pageTypeSuffix.yaml
    :caption: config/sites/my-site/config.yaml

The :yaml:`map` allows to add a filename or a file ending and map this to
a :typoscript:`page.typeNum` value.

It is also possible to set :yaml:`default`, for example to :yaml:`.html` to add
a ".html" suffix to all default pages:

..  literalinclude:: _codesnippets/_pageTypeSuffixDefault.yaml
    :caption: config/sites/my-site/config.yaml

The :yaml:`index` property is used when generating links on root-level page,
so instead of having `/en/.html` it would then result in
`/en/index.html`.

..  note::
    The implementation is a decorator enhancer, which means that the
    PageType enhancer is only there for adding suffixes to an existing route /
    variant, but not to substitute something within the middle of a
    human-readable URL segment.

..  index:: Routing; Aspects
..  _routing-advanced-routing-configuration-aspects:

Routing aspects
===============

Now that we have looked at how to transform a route to a page by using arguments
inserted into a URL, we will look at aspects. An aspect handles
the detailed logic within placeholders. The most common part of an aspect is
called a mapper. For example, parameter :yaml:`{news}`, is a UID within TYPO3,
and is mapped to the current news slug, which is a field within the database
table containing the cleaned/sanitized title of the news (for example,
"software-updates-2022" maps to news ID 10).

An aspect is a way to modify, beautify or map an argument into a placeholder.
That's why the terms "mapper" and "modifier" will pop up, depending on the
different cases.

Aspects are registered within a single enhancer configuration with the option
:yaml:`aspects` and can be used with any enhancer.

Let us start with some examples first:


..  _routing-aspect-StaticValueMapper:
..  index:: Routing; StaticValueMapper

StaticValueMapper
-----------------

The static value mapper replaces values on a 1:1 mapping list of an argument
into a speaking segment, useful for a checkout process to define the steps into
"cart", "shipping", "billing", "overview" and "finish", or in another example to
create human-readable segments for all available months.

The configuration could look like this:

..  literalinclude:: _codesnippets/_StaticValueMapper.yaml

You see the placeholder :yaml:`month` where the aspect replaces the value to a
human-readable URL path segment.

It is possible to add an optional :yaml:`localeMap` to that aspect to use the
locale of a value to use in multi-language setups:

..  literalinclude:: _codesnippets/_localeMap.yaml

..  _routing-aspect-LocaleModifier:
..  index:: Routing; LocaleModifier

LocaleModifier
--------------

If we have an enhanced route path such as `/archive/{year}/{month}`
it should be possible in multi-language setups to change `/archive/` depending
on the language of the page. This modifier is a
good example where a route path is modified, but not affected by arguments.

The configuration could look like this:

..  literalinclude:: _codesnippets/_LocaleModifier.yaml

This aspect replaces the placeholder :yaml:`localized_archive` depending on the
locale of the language of that page.

..  _routing-aspect-StaticRangeMapper:
..  index:: Routing; StaticRangeMapper

StaticRangeMapper
-----------------

A static range mapper allows to avoid the `cHash` and narrow down the available
possibilities for a placeholder. It explicitly defines a range for a value,
which is recommended for all kinds of pagination functionality.

..  literalinclude:: _codesnippets/_StaticRangeMapper.yaml

This limits down the pagination to a maximum of 100 pages. If a user calls the
news list with page 101, the route enhancer does not match and would not apply
the placeholder.

..  note::
    A range larger than 1000 is not allowed.

..  _routing-aspect-PersistedAliasMapper:
..  index:: Routing; PersistedAliasMapper

PersistedAliasMapper
--------------------

If an extension ships with a slug field or a different field used for the
speaking URL path, this database field can be used to build the URL:

..  literalinclude:: _codesnippets/_PersistedAliasMapper.yaml

The persisted alias mapper looks up the table and the field to map the given
value to a URL. The property :yaml:`tableName` points to the database table,
the property :yaml:`routeFieldName` is the field which will be used within the
route path, in this example :yaml:`path_segment`.

The special :yaml:`routeValuePrefix` is used for TCA type :php:`slug` fields
where the prefix :yaml:`/` is within all fields of the field names, which should
be removed in the case above.

If a field is used for :yaml:`routeFieldName` that is not prepared to be put
into the route path, e.g. the news title field, you **must** ensure that this is
unique and suitable for the use in an URL. On top, special characters like
spaces will not be converted automatically. Therefore, usage of a slug TCA field
is recommended.

..  _routing-aspect-PersistedPatternMapper:
..  index:: Routing; PersistedPatternMapper

PersistedPatternMapper
----------------------

When a placeholder should be fetched from multiple fields of the database, the
persisted pattern mapper is for you. It allows to combine various fields into
one variable, ensuring a unique value, for example by adding the UID to the
field without having the need of adding a custom slug field to the system.

..  literalinclude:: _codesnippets/_PersistedPatternMapper.yaml

The :yaml:`routeFieldPattern` option builds the title and uid fields from the
database, the :yaml:`routeFieldResult` shows how the placeholder will be output.
However, as mentioned above special characters in the title might still be a
problem. The persisted pattern mapper might be a good choice if you are
upgrading from a previous version and had URLs with an appended UID for
uniqueness.

..  _routing-aspect-aspect-precedence:
..  index:: Routing; Aspect precedence

Aspect precedence
=================

Route :yaml:`requirements` are ignored for route variables having a
corresponding setting in :yaml:`aspects`. Imagine an aspect that is mapping an
internal value `1` to route value `one` and vice versa - it is not possible to
explicitly define the :yaml:`requirements` for this case - which is why
:yaml:`aspects` take precedence.

The following example illustrates the mentioned dilemma between route generation
and resolving:

..  literalinclude:: _codesnippets/_AspectPrecedence.yaml

The :yaml:`map` in the previous example is already defining all valid values.
That is why :yaml:`aspects` take precedence over :yaml:`requirements` for a
specific :yaml:`routePath` definition.


..  _routing-aspect-fallback-handling:
..  index:: Routing; Aspect fallback value handling

Aspect fallback value handling
==============================

..  versionadded:: 12.1

Imagine a route like `/news/{news_title}` that has been filled with an "invalid"
value for the `news_title` part. Often these are outdated, deleted or hidden
records. Usually TYPO3 reacts to these "invalid" URL sections at a very early
stage with an HTTP status code "404" (resource not found).

The property :yaml:`fallbackValue = [string|null]` can prevent the above
scenario in several ways. By specifying an alternative value, a different
record, language or other detail can be represented. Specifying :yaml:`null`
removes the corresponding parameter from the route result. In this way, it is
up to the developer to react accordingly.

In the case of :ref:`Extbase <extbase>` extensions, the developer can define the
parameters in his calling controller action as nullable and deliver
corresponding :ref:`flash messages <flash-messages-api>` that explain the current
scenario better than a "404" HTTP status code.

..  rubric:: Examples

..  literalinclude:: _codesnippets/_NewsPlugin.yaml

Custom mapper implementations can incorporate this behavior by implementing
the :php:`\TYPO3\CMS\Core\Routing\Aspect\UnresolvedValueInterface` which is
provided by :php:`\TYPO3\CMS\Core\Routing\Aspect\UnresolvedValueTrait`:

..  literalinclude:: _codesnippets/_MyCustomEnhancer.php
    :caption: EXT:my_extension/Classes/Routing/Enhancer/MyCustomEnhancer.php

In another example we handle the null value in an Extbase show action
separately, for instance, to redirect to the list page:

..  literalinclude:: _codesnippets/_MyController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

..  index::
    Routing; PageArguments
    Routing; cHash
    Routing; typolink

Behind the scenes of routing in TYPO3
=====================================

While accessing a page in TYPO3 in the frontend, all arguments are currently
built back into the global GET parameters, but are also available as so-called
:php:`\TYPO3\CMS\Core\Routing\PageArguments` object. The :php:`PageArguments`
object is then used to sign and verify the parameters, to ensure that they are
valid, when handing them further down the frontend request chain.

If there are dynamic parameters (= parameters which are not strictly limited), a
verification GET parameter `cHash` is added, which **can and should not be
removed** from the URL. The concept of manually activating or deactivating
the generation of a `cHash` is not optional anymore, but strictly built-in to
ensure proper URL handling. If you really have the requirement to not have a
cHash argument, ensure that all placeholders are having strict definitions
on what could be the result of the page segment (e.g. pagination), and feel
free to build custom mappers.

All existing APIs like :typoscript:`typolink` or functionality evaluate the
page routing API directly.

..  note::
    If you update the site configuration with enhancers you have to to clear
    all caches, for example via the upper menu bar in the backend.
