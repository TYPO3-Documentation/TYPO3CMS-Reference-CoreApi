.. include:: /Includes.rst.txt
.. index::
   Routing; Advanced configuration
   pair: Routing; Extensions
.. _routing-advanced-routing-configuration:

===============================================
Advanced routing configuration (for extensions)
===============================================

While Page based routing works out of the box, routing for extensions has to be configured explicitely in your site configuration.

.. note::
    There is currently no graphical user interface available to configure extended routing. All adjustments need to be done via
    manually editing your web sites' site configuration :file:`config.yaml` file (located in :file:`config/sites/<yoursite>/config.yaml`).

To map `$_GET` parameters to routes, a concept called `Enhancers and Aspects` has been introduced.

An enhancer creates variants of a specific page-based route for a specific purpose (e.g. one plugin, one Extbase plugin)
and enhances the existing route path which can then contain flexible values, so-called "placeholders".

On top, aspects can be registered to a specific enhancer to modify a specific placeholder, like static human readable names
within the route path, or dynamically generated values.

To give you an overview of what the distinction is, we take a regular page which is available at

:samp:`https://example.org/path-to/my-page`

to access the Page with ID *13*.

Enhancers are a way to extend this route with placeholders on top of this specific route to a page.

:samp:`https://example.org/path-to/my-page/products/<product-name>`

The suffix `/products/<product-name>` to the base route of the page is added by an enhancer. The placeholder variable
which is added by the curly braces can then be statically or dynamically resolved or built by an Aspect (more
commonly known as a Mapper).

It is possible to use the same enhancer multiple times with different configurations. However, be aware that
it is not possible to combine multiple variants / enhancers matching multiple configurations.

However, custom enhancers can be built to overcome special use cases where e.g. two plugins with multiple parameters
each could be configured. Otherwise, the first variant matching the URL parameters is used for generation and
resolving.


.. index:: Routing; Enhancers

Enhancers
=========

There are two types of enhancers: decorators and route enhancers. An route enhancer is there to replace a set of placeholders and fill in URL parameters on URL generation and resolving them properly
later-on. Substitution of the values with aliases can be achieved by Aspects. To simplify: A route enhancer specifies how the full
route path looks like and which variables are available whereas an aspect takes care of mapping a single variable to a value.

TYPO3 comes with the following route enhancers out of the box:

- Simple Enhancer (enhancer type "Simple")
- Plugin Enhancer (enhancer type "Plugin")
- Extbase Plugin Enhancer (enhancer type "Extbase")

TYPO3 provides the following decorators out of the box:

- PageTypeDecorator (enhancer type "PageType")

Custom enhancers can be registered by adding an entry to an extensions :file:`ext_localconf.php`.

:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['enhancers']['CustomEnhancer'] = \MyVendor\MyPackage\Routing\CustomEnhancer::class;`

Within a configuration, an enhancer always evaluates the following properties:

`type`
   The short name of the enhancer as registered within :php:`$GLOBALS['TYPO3_CONF_VARS']`. This is mandatory.

`limitToPages`
   An array of page IDs where this enhancer should be called. This is optional. This property (array)
   only triggers an enhancer for specific pages. In case of special plugin pages it is
   recommended to only enhance those pages with the plugin, to speed up performance for building page routes of all other pages.

All enhancers allow to configure at least one route with the following
configuration:

`defaults`
   Defines which URL parameters are optional.
   If the parameters are omitted on generation, they can receive a default value, and do not need a placeholder
   - it is possible to add them at the very end of the `routePath`.

`requirements`
   Exactly specifies what kind of parameter should be added to that route as regular expression.
   This way, it is configurable to only allow integer values for e.g. pagination.

   Make sure you define your requirements as strict as possible.
   This is necessary to not loose performance and allow TYPO3 to match the expected route.

`_arguments`
   Defines what Route Parameters should be available to the system. In this example,
   the placeholder is called `category_id` but the URL generation receives the argument `category`,
   so this is mapped to that name (so you can access/use it as `category` in your custom code).

TYPO3 will add the parameter ``cHash`` to URLs when necessary, see :ref:`chash`.
The ``cHash`` can be removed by converting dynamic arguments into static arguments.
All captured arguments are dynamic by default. They can be converted to static arguments by defining the possible expected values for these arguments.
This is done by adding Aspects for those arguments to provide a static list of expected values, see :ref:`routing-advanced-routing-configuration-aspects`.

.. index:: Routing; Simple Enhancer

Simple Enhancer
^^^^^^^^^^^^^^^

The Simple Enhancer works with various route arguments to map them to an argument to be used later-on.

`index.php?id=13&category=241&tag=Benni`
results in
:samp:`https://example.org/path-to/my-page/show-by-category/241/Benni`

The configuration looks like this:

.. code-block:: yaml

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

The configuration option `routePath` defines the static keyword and the available placeholders.

.. note::
    For people coming from RealURL usage in previous versions: The `routePath` can be loosely compared to some as
    "postVarSets".

.. index:: Routing; Plugin Enhancer

Plugin Enhancer
^^^^^^^^^^^^^^^

The Plugin Enhancer works with plugins on a page that are commonly known as `Pi-Based Plugins`, where previously
the following GET/POST variables were used:

`index.php?id=13&tx_felogin_pi1[forgot]=1&&tx_felogin_pi1[user]=82&tx_felogin_pi1[hash]=ABCDEFGHIJKLMNOPQRSTUVWXYZ012345`

The base for the plugin enhancer is to configure a so-called "namespace", in this case `tx_felogin_pi1` - the plugin's
namespace.

The Plugin Enhancer explicitly sets exactly one additional variant for a specific use-case. In case of Frontend Login,
we would need to set up multiple configurations of Plugin Enhancer for forgot and recover passwords.

.. code-block:: yaml

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

If a URL is generated with the given parameters to link to a page, the result will look like this:

:samp:`https://example.org/path-to/my-page/forgot-password/82/ABCDEFGHIJKLMNOPQRSTUVWXYZ012345`

.. note::
    If the input given to generate the URL does not meet the requirements, the route enhancer does not offer the
    variant and the parameters are added to the URL as regular query parameters. If e.g. the user parameter would be more
    than three characters, or non-numeric, this enhancer would not match anymore.

As you see, the Plugin Enhancer is used to specify placeholders and requirements, with a given namespace.

If you want to replace the user ID (in this example "82") with the username, you would need an aspect that can be
registered within any enhancer, see below for details.


.. index:: Routing; Extbase Plugin Enhancer

Extbase Plugin enhancer
^^^^^^^^^^^^^^^^^^^^^^^

When creating Extbase plugins, it is very common to have multiple controller/action combinations. The Extbase Plugin
Enhancer is therefore an extension to the regular Plugin Enhancer, providing the functionality of generating multiple variants,
typically based on the available controller/action pairs.

.. warning::
   Do not set `features.skipDefaultArguments` in your Extbase plugin configuration as that will result in missing parameters to
   be mapped - then no matching route configuration can be found.

The Extbase Plugin enhancer with the configuration below would now apply to the following URLs:

* `index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list`
* `index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list&tx_news_pi1[page]=5`
* `index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=list&tx_news_pi1[year]=2018&tx_news_pi1[month]=8`
* `index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=detail&tx_news_pi1[news]=13`
* `index.php?id=13&tx_news_pi1[controller]=News&tx_news_pi1[action]=tag&tx_news_pi1[tag]=11`

And generate the following URLs

* :samp:`https://example.org/path-to/my-page/list/`
* :samp:`https://example.org/path-to/my-page/list/5`
* :samp:`https://example.org/path-to/my-page/list/2018/8`
* :samp:`https://example.org/path-to/my-page/detail/in-the-year-2525`
* :samp:`https://example.org/path-to/my-page/tag/future`

.. code-block:: yaml

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

In this example, the `_arguments` parameter is used to set sub properties of an array,
which is typically used within demand objects for filtering functionality. Additionally, it is using both the short
and the long form of writing route configurations.

To understand what's happening in the `aspects` part, read on.

.. note::
    For the Extbase Plugin Enhancer, it is also possible to configure the namespace directly by skipping `extension`
    and `plugin` properties and just using the `namespace` property as in the regular Plugin Enhancer.

.. attention::
    Please ensure not to register the same `routePath` more than once, for example through multiple extensions.
    In that case, the enhancer imported last will override any duplicate routes that are in place.


.. index:: Routing; PageType decorator

PageType decorator
^^^^^^^^^^^^^^^^^^^

The PageType Enhancer (Decorator) allows to add a suffix to the existing route (including existing other enhancers)
to map a page type (GET parameter &type=) to a suffix.

It is possible to map various page types to endings:

Example TypoScript:

.. code-block:: typoscript

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

Now configure the Enhancer in your site's :file:`config.yaml` file like this:

.. code-block:: yaml

   routeEnhancers:
      PageTypeSuffix:
         type: PageType
         default: ''
         map:
            'rss.feed': 13
            '.json': 26


The :yaml:`map` allows to add a filename or a file ending and map this to a :typoscript:`page.typeNum` value.

It is also possible to set :yaml:`default` to e.g. ".html" to add a ".html" suffix to all default pages.

.. code-block:: yaml

   routeEnhancers:
      PageTypeSuffix:
         type: PageType
         default: '.json'
         index: 'index'
         map:
            'rss.feed': 13
            '.json': 26

The :yaml:`index` property is used when generating links on root-level page, thus, instead of e.g. having
`/en/.json` thus would then result in `/en/index.json`.


.. note::
    Please note that the implementation is a Decorator Enhancer, which means that the PageTypeEnhancer
    is only there for adding suffixes to an existing route / variant, but not to substitute something
    within the middle of a human readable URL segment.

.. index:: Routing; Aspects
.. _routing-advanced-routing-configuration-aspects:

Aspects
=======

Now that we've looked into ways on how to extend a route to a page with arguments, and to put them into the URL
path as segments, the detailed logic within one placeholder is in an aspect. The most common practice of an aspect
is a so-called mapper. For example mapping a parameter `{news}` which is a UID within TYPO3 to the actual news slug, which is a field
within the database table containing the cleaned/sanitized title of the news (e.g. "software-updates-2019" maps to news ID 10).

An aspect can be a way to modify, beautify or map an argument from the URL generation into a placeholder. That's why
the terms "Mapper" and "Modifier" will pop up, depending on the different cases.

Aspects are registered within one single enhancer configuration with the option `aspects` and can be used with any
enhancer.

Let's start with some simpler examples first:


.. index:: Routing; StaticValueMapper

StaticValueMapper
^^^^^^^^^^^^^^^^^

The StaticValueMapper replaces values simply on a 1:1 mapping list of an argument into a speaking segment, useful
for a checkout process to define the steps into "cart", "shipping", "billing", "overview" and "finish", or in a
simpler example to create human readable segments for all available months.

The configuration could look like this:

.. code-block:: yaml

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


You see the placeholder "month" where the aspect replaces the value to a human readable url path segment.

It is possible to add an optional `localeMap` to that aspect to use the locale of a value to use in multi-language
setups.

.. code-block:: yaml

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
^^^^^^^^^^^^^^

The enhanced part of a route path could be `/archive/{year}/{month}` - however, in multi-language setups, it should be
possible to rename `/archive/` depending on the language that is given for this page translation. This modifier is a
good example where a route path is modified but is not affected by arguments.

The configuration could look like this:

.. code-block:: yaml

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

You'll see the placeholder "localized_archive" where the aspect replaces the localized archive based on the locale of
the language of that page.


.. index:: Routing; StaticRangeMapper

StaticRangeMapper
^^^^^^^^^^^^^^^^^

A static range mapper allows to avoid the `cHash` and narrow down the available possibilities for a placeholder,
and to explicitly define a range for a value, which is recommended for all kinds of pagination functionality.

.. code-block:: yaml

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

This limits down the pagination to max. 100 pages, if a user calls the news list with page 101, then the route enhancer
does not match and would not apply the placeholder.

A range larger than 1000 is not allowed.


.. index:: Routing; PersistedAliasMapper

PersistedAliasMapper
^^^^^^^^^^^^^^^^^^^^

If an extension ships with a slug field, or a different field used for the speaking URL path, this database field
can be used to build the URL:

.. code-block:: yaml

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

The PersistedAliasMapper looks up the table and field to map the given value to a URL.
The property `tableName` points to the database table, the property `routeFieldName` is the field which will be
used within the route path for example.

The special `routeValuePrefix` is used for TCA type `slug` fields where the prefix `/` is within all fields of the
field names, which should be removed in the case above.

If a field is used for `routeFieldName` that is not prepared to be put into the route path, e.g. the news title field,
you *must* ensured that this is unique and suitable for the use in an URL. On top, if there are special characters
like spaces will not be converted automatically. Therefor, usage of a slug TCA field is recommended.


.. index:: Routing; PersistedPatternMapper

PersistedPatternMapper
^^^^^^^^^^^^^^^^^^^^^^

When a placeholder should be fetched from multiple fields of the database, the PersistedPatternMapper is for you.
It allows to combine various fields into one variable, ensuring a unique value by e.g. adding the UID to the field
without having the need of adding a custom slug field to the system.

.. code-block:: yaml

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

The `routeFieldPattern` option builds the title and uid fields from the database, the `routeFieldResult` shows
how the placeholder will be output. As mentioned above however, special characters in the title might still be
a problem. The `PersistedPatternMapper` might be a good choice if you are upgrading from a previous version and had
URLs with an appended UID for uniqueness.


.. index:: Routing; Aspect precedence

Aspect precedence
=================

Route `requirements` are ignored for route variables having a corresponding
setting in `aspects`. Imagine an aspect that is mapping internal
value `1` to route value `one` and vice versa - it is not possible to explicitly
define the `requirements` for this case - which is why `aspects` take precedence.

The following example illustrates the mentioned dilemma between route generation
and resolving:

.. code-block:: yaml

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

The `map` in the previous example is already defining all valid values.
That's why `aspects` take precedence over `requirements` for a specific
`routePath` definition.


.. index::
   Routing; PageArguments
   Routing; cHash
   Routing; typolink

Behind the Scenes
=================

While accessing a page in TYPO3 in the Frontend, all arguments are currently built back into the global
GET parameters, but are also available as so-called `PageArguments` object. The `PageArguments` object
is then used to sign and verify the parameters, to ensure that they are valid,
when handing them further down the frontend request chain.

If there are dynamic parameters (= parameters which are not strictly limited), a verification GET parameter `cHash`
is added, which *can and should not be removed* from the URL. The concept of manually activating or deactivating
the generation of a `cHash` is not optional anymore, but strictly built-in to ensure proper URL handling. If you
really have the requirement to not have a cHash argument, ensure that all placeholders are having strict definitions
on what could be the result of the page segment (e.g. pagination), and feel free to build custom mappers.

All existing APIs like `typolink` or functionality evaluate the new Page Routing API directly.

.. note::
    Please note that if you update the Site configuration with enhancers that you need to clear all caches.
