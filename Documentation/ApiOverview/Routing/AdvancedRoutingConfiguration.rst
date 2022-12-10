.. include:: /Includes.rst.txt
.. index::
   Routing; Advanced configuration
   pair: Routing; Extensions
.. _routing-advanced-routing-configuration:

===============================================
Advanced routing configuration (for extensions)
===============================================

..  contents::
    :local:


Introduction
============

While page-based routing works out of the box, routing for extensions has to be
configured explicitly in your :ref:`site configuration <sitehandling>`.

..  note::
    There is no graphical user interface available to configure extended
    routing. All adjustments need to be done via manual editing your website's
    :file:`config.yaml` site configuration file (located in
    :file:`config/sites/<yoursite>/config.yaml`).

To map GET parameters to routes, a concept called "enhancers and aspects" has
been introduced.

An :ref:`enhancer <routing-advanced-routing-configuration-enhancers>` creates
variants of a specific page-based route for a specific purpose (e.g. an
:ref:`Extbase <extbase>` plugin) and enhances the existing route path, which
can then contain flexible values, so-called "placeholders".

On top, :ref:`aspects <routing-advanced-routing-configuration-aspects>` can be
registered for a specific enhancer to modify a specific placeholder, like static
human readable names within the route path or dynamically generated values.

To give you an overview of what the distinction is, we take a regular page which
is available at

:samp:`https://example.org/path-to/my-page`

to access the page with ID *13*.

Enhancers are a way to extend this route with placeholders on top of this
specific route to a page:

:samp:`https://example.org/path-to/my-page/products/<product-name>`

The suffix `/products/<product-name>` to the base route of the page is added by
an enhancer. The placeholder variable added by the curly braces can then be
resolved statically or dynamically, or built by an aspect (more commonly
known as a "mapper").

It is possible to use the same enhancer multiple times with different
configurations. Be aware that it is not possible to combine multiple variants /
enhancers matching multiple configurations.

However, custom enhancers can be created to overcome special use cases, for
example, when two plugins with multiple parameters each could be configured.
Otherwise, the first variant matching the URL parameters is used for generation
and resolving.


.. index:: Routing; Enhancers

.. _routing-advanced-routing-configuration-enhancers:

Enhancers
=========

There are two types of enhancers: decorators and route enhancers. A route
enhancer is there to replace a set of placeholders and fill in URL parameters
during URL generation and resolve them properly later. The substitution of
values with aliases can be achieved by aspects. To simplify, a route enhancer
specifies how the full route path looks like and which variables are available,
whereas an aspect takes care of mapping a single variable to a value.

TYPO3 comes with the following route enhancers out of the box:

-   :ref:`Simple enhancer <routing-simple-enhancer>`
    (enhancer type :yaml:`Simple`)
-   :ref:`Plugin enhancer <routing-plugin-enhancer>`
    (enhancer type :yaml:`Plugin`)
-   :ref:`Extbase plugin enhancer <routing-extbase-plugin-enhancer>`
    (enhancer type :yaml:`Extbase`)

TYPO3 provides the following decorator out of the box:

-   :ref:`Page type decorator <routing-pagetype-decorator>`
    (enhancer type :yaml:`PageType`)

Custom enhancers can be registered by adding an entry to an extension's
:file:`ext_localconf.php` file:

..  code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['enhancers']['CustomEnhancer']
        = \MyVendor\MyPackage\Routing\CustomEnhancer::class;

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
    regular expression. This way it is configurable to allow only integer
    values, e.g. for pagination.

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

.. index:: Routing; Simple Enhancer
.. _routing-simple-enhancer:

Simple enhancer
---------------

The simple enhancer works with various route arguments to map them to an
argument to be used later.

..  code-block:: none

    index.php?id=13&category=241&tag=Benni

results in

..  code-block:: none

    https://example.org/path-to/my-page/show-by-category/241/Benni

The configuration looks like this:

..  code-block:: yaml

    routeEnhancers:
      # Unique name for the enhancers, used internally for referencing
      CategoryListing:
        type: Simple
        limitToPages: [13]
        routePath: '/show-by-category/{category_id}/{tag}'
        defaults:
          tag: ''
        requirements:
          category_id: '[0-9]{1,3}'
          tag: '[a-zA-Z0-9].*'
        _arguments:
          category_id: 'category'

The configuration option :yaml:`routePath` defines the static keyword and the
available placeholders.

..  note::
    For people coming from :t3ext:`realurl` in previous TYPO3 versions: The
    :yaml:`routePath` can be loosely compared to some as "postVarSets".

.. index:: Routing; Plugin Enhancer
.. _routing-plugin-enhancer:

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

The plugin enhancer explicitly sets exactly one additional variant for a
specific use case. In case of the :doc:`frontend login <ext_felogin:Index>`, we
would need to set up multiple configurations of the plugin enhancer for
"forgot password" and "recover password".

..  code-block:: yaml

    routeEnhancers:
      ForgotPassword:
        type: Plugin
        limitToPages: [13]
        routePath: '/forgot-password/{user}/{hash}'
        namespace: 'tx_felogin_pi1'
        defaults:
          forgot: '1'
        requirements:
          user: '[0-9]{1,3}'
          hash: '^[a-zA-Z0-9]{32}$'

If a URL is generated with the given parameters to link to a page, the result
will look like this:

..  code-block:: none

    https://example.org/path-to/my-page/forgot-password/82/ABCDEFGHIJKLMNOPQRSTUVWXYZ012345

..  note::
    If the input given to generate the URL does not meet the requirements, the
    route enhancer does not offer the variant, and the parameters are added to
    the URL as regular query parameters. For example, if the user parameter
    would be more than three characters or non-numeric, this enhancer would not
    match anymore.

As you see, the plugin enhancer is used to specify placeholders and
requirements with a given namespace.

If you want to replace the user ID (in this example "82") with the username,
you would need an aspect that can be registered within any enhancer, see
:ref:`below for details <routing-advanced-routing-configuration-aspects>`.


.. index:: Routing; Extbase Plugin Enhancer
.. _routing-extbase-plugin-enhancer:

Extbase plugin enhancer
-----------------------

When creating :ref:`Extbase <extbase>` plugins, it is very common to have
multiple controller/action combinations. Therefore, the Extbase plugin enhancer
is an extension to the :ref:`regular plugin enhancer
<routing-plugin-enhancer>` and provides the
functionality to generate multiple variants, typically based on the available
controller/action pairs.

..  warning::
    Do not set :typoscript:`features.skipDefaultArguments` in your Extbase
    plugin configuration as this will result in missing parameters to be mapped
    - then no matching route configuration can be found.

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

..  code-block:: yaml

    routeEnhancers:
      NewsPlugin:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - routePath: '/list/'
            _controller: 'News::list'
          - routePath: '/list/{page}'
            _controller: 'News::list'
            _arguments:
              page: '@widget_0/currentPage'
          - routePath: '/detail/{news_title}'
            _controller: 'News::detail'
            _arguments:
              news_title: 'news'
          - routePath: '/tag/{tag_name}'
            _controller: 'News::list'
            _arguments:
              tag_name: 'overwriteDemand/tags'
          - routePath: '/list/{year}/{month}'
            _controller: 'News::list'
            _arguments:
              year: 'overwriteDemand/year'
              month: 'overwriteDemand/month'
            requirements:
              year: '\d+'
              month: '\d+'
        defaultController: 'News::list'
        defaults:
          page: '0'
        aspects:
          news_title:
            type: PersistedAliasMapper
            tableName: tx_news_domain_model_news
            routeFieldName: path_segment
          page:
            type: StaticRangeMapper
            start: '1'
            end: '100'
          month:
            type: StaticRangeMapper
            start: '1'
            end: '12'
          year:
            type: StaticRangeMapper
            start: '1984'
            end: '2525'
          tag_name:
            type: PersistedAliasMapper
            tableName: tx_news_domain_model_tag
            routeFieldName: slug

In this example, the :yaml:`_arguments` parameter is used to set sub-properties
of an array, which is typically used within demand objects for filtering
functionality. Additionally, it is using both the short and the long form of
writing route configurations.

To understand what's happening in the :yaml:`aspects` part, read on.

..  note::
    For the Extbase plugin enhancer, it is also possible to configure the
    namespace directly by skipping :yaml:`extension` and :yaml:`plugin`
    properties and just using the :ayml:`namespace` property as in the
    :ref:`regular plugin enhancer <routing-plugin-enhancer>`.

..  attention::
    Please ensure not to register the same :yaml:`routePath` more than once, for
    example through multiple extensions. In that case, the enhancer imported
    last will override any duplicate routes that are in place.


.. index:: Routing; PageType decorator
.. _routing-pagetype-decorator:

PageType decorator
------------------

The PageType enhancer (decorator) allows to add a suffix to the existing route
(including existing other enhancers) to map a page type (GET parameter `&type=`)
to a suffix.

It is possible to map various page types to endings:

Example in TypoScript:

..  code-block:: typoscript

    page = PAGE
    page.typeNum = 0
    page.10 = TEXT
    page.10.value = Default page

    rssfeed = PAGE
    rssfeed.typeNum = 13
    rssfeed.10 < plugin.tx_myplugin
    rssfeed.config.disableAllHeaderCode = 1
    rssfeed.config.additionalHeaders.10.header = Content-Type: xml/rss

    jsonview = PAGE
    jsonview.typeNum = 26
    jsonview.10 = USER
    jsonview.10.userFunc = MyVendor\MyExtension\Controller\JsonPageController->renderAction
    jsonview.10.config.disableAllHeaderCode = 1
    jsonview.10.config.additionalHeaders.10.header = Content-Type: application/json

Now we configure the enhancer in your site's :file:`config.yaml` file like this:

..  code-block:: yaml

    routeEnhancers:
      PageTypeSuffix:
        type: PageType
        default: ''
        map:
          'rss.feed': 13
          '.json': 26


The :yaml:`map` allows to add a filename or a file ending and map this to
a :typoscript:`page.typeNum` value.

It is also possible to set :yaml:`default`, for example to :yaml:`.html` to add
a ".html" suffix to all default pages:

..  code-block:: yaml

    routeEnhancers:
      PageTypeSuffix:
        type: PageType
        default: '.html'
        index: 'index'
        map:
          'rss.feed': 13
          '.json': 26

The :yaml:`index` property is used when generating links on root-level page,
so instead of having `/en/.html` it would then result in
`/en/index.html`.

..  note::
    The implementation is a decorator enhancer, which means that the
    PageType enhancer is only there for adding suffixes to an existing route /
    variant, but not to substitute something within the middle of a
    human-readable URL segment.

.. index:: Routing; Aspects
.. _routing-advanced-routing-configuration-aspects:

Aspects
=======

Now that we have looked at how to extend a route to a page with arguments and
insert them as segments in the URL, the detailed logic within a placeholder is
in an aspect. The most common practice of an aspect is called a mapper. For
example, a parameter :yaml:`{news}`, which is a UID within TYPO3, is mapped to
the actual news slug, which is a field within the database table containing the
cleaned/sanitized title of the news (for example, "software-updates-2022" maps
to news ID 10).

An aspect can be a way to modify, beautify or map an argument from the URL
generation into a placeholder. That's why the terms "mapper" and "modifier" will
pop up, depending on the different cases.

Aspects are registered within one single enhancer configuration with the option
:yaml:`aspects` and can be used with any enhancer.

Let us start with some examples first:


.. index:: Routing; StaticValueMapper

StaticValueMapper
-----------------

The static value mapper replaces values on a 1:1 mapping list of an argument
into a speaking segment, useful for a checkout process to define the steps into
"cart", "shipping", "billing", "overview" and "finish", or in another example to
create human-readable segments for all available months.

The configuration could look like this:

..  code-block:: yaml

    routeEnhancers:
      NewsArchive:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - { routePath: '/{year}/{month}', _controller: 'News::archive' }
        defaultController: 'News::list'
        defaults:
          month: ''
        aspects:
          month:
            type: StaticValueMapper
            map:
              january: 1
              february: 2
              march: 3
              april: 4
              may: 5
              june: 6
              july: 7
              august: 8
              september: 9
              october: 10
              november: 11
              december: 12


You see the placeholder :yaml:`month` where the aspect replaces the value to a
human-readable URL path segment.

It is possible to add an optional :yaml:`localeMap` to that aspect to use the
locale of a value to use in multi-language setups:

..  code-block:: yaml

    routeEnhancers:
      NewsArchive:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - { routePath: '/{year}/{month}', _controller: 'News::archive' }
        defaultController: 'News::list'
        defaults:
          month: ''
        aspects:
          month:
            type: StaticValueMapper
            map:
              january: 1
              february: 2
              march: 3
              april: 4
              may: 5
              june: 6
              july: 7
              august: 8
              september: 9
              october: 10
              november: 11
              december: 12
            localeMap:
              - locale: 'de_.*'
                map:
                  januar: 1
                  februar: 2
                  maerz: 3
                  april: 4
                  mai: 5
                  juni: 6
                  juli: 7
                  august: 8
                  september: 9
                  oktober: 10
                  november: 11
                  dezember: 12


.. index:: Routing; LocaleModifier

LocaleModifier
--------------

The enhanced part of a route path could be `/archive/{year}/{month}` - however,
in multi-language setups, it should be possible to rename `/archive/` depending
on the language that is given for this page translation. This modifier is a
good example where a route path is modified, but is not affected by arguments.

The configuration could look like this:

..  code-block:: yaml

    routeEnhancers:
      NewsArchive:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - { routePath: '/{localized_archive}/{year}/{month}', _controller: 'News::archive' }
        defaultController: 'News::list'
        aspects:
          localized_archive:
            type: LocaleModifier
            default: 'archive'
            localeMap:
              - locale: 'fr_FR.*|fr_CA.*'
                value: 'archives'
              - locale: 'de_DE.*'
                value: 'archiv'

You will see the placeholder :yaml:`localized_archive` where the aspect
replaces the localized archive based on the locale of the language of that page.


.. index:: Routing; StaticRangeMapper

StaticRangeMapper
-----------------

A static range mapper allows to avoid the `cHash` and narrow down the available
possibilities for a placeholder. It explicitly defines a range for a value,
which is recommended for all kinds of pagination functionality.

..  code-block:: yaml

    routeEnhancers:
      NewsPlugin:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - { routePath: '/list/{page}', _controller: 'News::list', _arguments: {'page': '@widget_0/currentPage'} }
        defaultController: 'News::list'
        defaults:
          page: '0'
        aspects:
          page:
            type: StaticRangeMapper
            start: '1'
            end: '100'

This limits down the pagination to a maximum of 100 pages. If a user calls the
news list with page 101, the route enhancer does not match and would not apply
the placeholder.

..  note::
    A range larger than 1000 is not allowed.


.. index:: Routing; PersistedAliasMapper

PersistedAliasMapper
--------------------

If an extension ships with a slug field or a different field used for the
speaking URL path, this database field can be used to build the URL:

..  code-block:: yaml

    routeEnhancers:
      NewsPlugin:
        type: Extbase
        limitToPages: [13]
        extension: News
        plugin: Pi1
        routes:
          - { routePath: '/detail/{news_title}', _controller: 'News::detail', _arguments: {'news_title': 'news'} }
        defaultController: 'News::detail'
        aspects:
          news_title:
            type: PersistedAliasMapper
            tableName: 'tx_news_domain_model_news'
            routeFieldName: 'path_segment'
            routeValuePrefix: '/'

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


.. index:: Routing; PersistedPatternMapper

PersistedPatternMapper
----------------------

When a placeholder should be fetched from multiple fields of the database, the
persisted pattern mapper is for you. It allows to combine various fields into
one variable, ensuring a unique value, for example by adding the UID to the
field without having the need of adding a custom slug field to the system.

..  code-block:: yaml

    routeEnhancers:
      Blog:
        type: Extbase
        limitToPages: [13]
        extension: BlogExample
        plugin: Pi1
        routes:
          - { routePath: '/blog/{blogpost}', _controller: 'Blog::detail', _arguments: {'blogpost': 'post'} }
        defaultController: 'Blog::detail'
        aspects:
          blogpost:
            type: PersistedPatternMapper
            tableName: 'tx_blogexample_domain_model_post'
            routeFieldPattern: '^(?P<title>.+)-(?P<uid>\d+)$'
            routeFieldResult: '{title}-{uid}'

The :yaml:`routeFieldPattern` option builds the title and uid fields from the
database, the :yaml:`routeFieldResult` shows how the placeholder will be output.
However, as mentioned above special characters in the title might still be a
problem. The persisted pattern mapper` might be a good choice if you are
upgrading from a previous version and had URLs with an appended UID for
uniqueness.


.. index:: Routing; Aspect precedence

Aspect precedence
=================

Route :yaml:`requirements` are ignored for route variables having a
corresponding setting in :yaml:`aspects`. Imagine an aspect that is mapping an
internal value `1` to route value `one` and vice versa - it is not possible to
explicitly define the :yaml:`requirements` for this case - which is why
:yaml:`aspects` take precedence.

The following example illustrates the mentioned dilemma between route generation
and resolving:

..  code-block:: yaml

    routeEnhancers:
      MyPlugin:
        type: 'Plugin'
        namespace: 'my'
        routePath: 'overview/{month}'
        requirements:
          # note: it does not make any sense to declare all values here again
          month: '^(\d+|january|february|march|april|...|december)$'
        aspects:
          month:
            type: 'StaticValueMapper'
            map:
              january: '1'
              february: '2'
              march: '3'
              april: '4'
              may: '5'
              june: '6'
              july: '7'
              august: '8'
              september: '9'
              october: '10'
              november: '11'
              december: '12'

The :yaml:`map` in the previous example is already defining all valid values.
That is why :yaml:`aspects` take precedence over :yaml:`requirements` for a
specific :yaml:`routePath` definition.


.. index::
   Routing; PageArguments
   Routing; cHash
   Routing; typolink

Behind the Scenes
=================

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
