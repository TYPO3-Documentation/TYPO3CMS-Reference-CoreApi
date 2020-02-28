.. include:: ../../Includes.txt

.. _routing-examples:

======================================
Collection of various routing examples
======================================

.. note::
   If you have additional examples and are willing to share, please create a Pull Request on Github and add it to this page.


EXT: News
=========

**Prerequisites:**

The plugins for *list view* and *detail view* are on separate pages.
If you use the *category menu* or *tag list* plugins to filter news records, their titles (slugs) are used.

**Result:**

* Detail view: ``https://www.example.com/news/detail/the-news-title``
* Pagination: ``https://www.example.com/news/page-2``
* Category filter: ``https://www.example.com/news/my-category``
* Tag filter: ``https://www.example.com/news/my-tag``

.. code-block:: yaml
   :linenos:

   routeEnhancers:
     News:
       type: Extbase
       extension: News
       plugin: Pi1
       routes:
         - routePath: '/page-{page}'
           _controller: 'News::list'
           _arguments:
             page: '@widget_0/currentPage'
         - routePath: '/{news-title}'
           _controller: 'News::detail'
           _arguments:
             news-title: news
         - routePath: '/{category-name}'
           _controller: 'News::list'
           _arguments:
             category-name: overwriteDemand/categories
         - routePath: '/{tag-name}'
           _controller: 'News::list'
           _arguments:
             tag-name: overwriteDemand/tags
       defaultController: 'News::list'
       defaults:
         page: '0'
       aspects:
         news-title:
           type: PersistedAliasMapper
           tableName: tx_news_domain_model_news
           routeFieldName: path_segment
         page:
           type: StaticRangeMapper
           start: '1'
           end: '100'
         category-name:
           type: PersistedAliasMapper
           tableName: sys_category
           routeFieldName: slug
         tag-name:
           type: PersistedAliasMapper
           tableName: tx_news_domain_model_tag
           routeFieldName: slug

For more examples and background information see `News manual <https://docs.typo3.org/p/georgringer/news/master/en-us/AdministratorManual/BestPractice/Routing/Index.html>`__.

EXT: Blog with custom Aspect
============================

Taken from https://typo3.com routing configuration and the blog extension.

Archive
^^^^^^^

.. code-block:: yaml
   :linenos:

   routeEnhancers:
     BlogArchive:
        type: Extbase
        extension: Blog
        plugin: Archive
        routes:
        -
            routePath: '/{year}'
            _controller: 'Post::listPostsByDate'
            _arguments:
            year: year
        -
            routePath: '/{year}/page-{page}'
            _controller: 'Post::listPostsByDate'
            _arguments:
            year: year
            page: '@widget_0/currentPage'
        -
            routePath: '/{year}/{month}'
            _controller: 'Post::listPostsByDate'
            _arguments:
            year: year
            month: month
        -
            routePath: '/{year}/{month}/page-{page}'
            _controller: 'Post::listPostsByDate'
            _arguments:
            year: year
            month: month
            page: '@widget_0/currentPage'
        defaultController: 'Post::listPostsByDate'
        requirements:
        year: '[0-9]{1..4}'
        month: '[a-z]+'
        page: '\d+'
        aspects:
        year:
            type: BlogStaticDatabaseMapper
            table: 'pages'
            field: 'crdate_year'
            groupBy: 'crdate_year'
            where:
            doktype: 137
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
            -
                locale: 'de_.*'
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
            -
                locale: 'fr_.*'
                map:
                janvier: 1
                fevrier: 2
                mars: 3
                avril: 4
                mai: 5
                juin: 6
                juillet: 7
                aout: 8
                septembre: 9
                octobre: 10
                novembre: 11
                decembre: 12
        page:
            type: StaticRangeMapper
            start: '1'
            end: '99'

Posts by Author
^^^^^^^^^^^^^^^

.. code-block:: yaml
   :linenos: 

    routeEnhancers:
        AuthorPosts:
            type: Extbase
            extension: Blog
            plugin: AuthorPosts
            routes:
            -
                routePath: '/{author_title}'
                _controller: 'Post::listPostsByAuthor'
                _arguments:
                    author_title: author
            -
                routePath: '/{author_title}/page-{page}'
                _controller: 'Post::listPostsByAuthor'
                _arguments:
                    author_title: author
                    page: '@widget_0/currentPage'
            defaultController: 'Post::listPostsByAuthor'
            requirements:
            author_title: '^[a-z0-9].*$'
            page: '\d+'
            aspects:
            author_title:
                type: PersistedAliasMapper
                tableName: 'tx_blog_domain_model_author'
                routeFieldName: 'slug'
            page:
                type: StaticRangeMapper
                start: '1'
                end: '99'

Category pages
^^^^^^^^^^^^^^^

.. code-block:: yaml
   :linenos: 

    routeEnhancers:
        BlogCategory:
            type: Extbase
            extension: Blog
            plugin: Category
            routes:
            -
                routePath: '/{category_title}'
                _controller: 'Post::listPostsByCategory'
                _arguments:
                    category_title: category
            -
                routePath: '/{category_title}/page-{page}'
                _controller: 'Post::listPostsByCategory'
                _arguments:
                    category_title: category
                    page: '@widget_0/currentPage'
            defaultController: 'Post::listPostsByCategory'
            requirements:
                category_title: '^[a-z0-9].*$'
                page: '\d+'
            aspects:
                category_title:
                    type: PersistedAliasMapper
                    tableName: sys_category
                    routeFieldName: 'slug'
                page:
                    type: StaticRangeMapper
                    start: '1'
                    end: '99'

Blog Feeds
^^^^^^^^^^

.. code-block:: yaml
   :linenos:

   routeEnhancers:
      PageTypeSuffix:
        type: PageType
        map:
            'blog.recent.xml': 200
            'blog.category.xml': 210
            'blog.tag.xml': 220
            'blog.archive.xml': 230
            'blog.comments.xml': 240
            'blog.author.xml': 250

Blog Posts
^^^^^^^^^^

.. code-block:: yaml
   :linenos:

   routeEnhancers:
     BlogPosts:
        type: Extbase
        extension: Blog
        plugin: Posts
        routes:
        -
            routePath: '/page-{page}'
            _controller: 'Post::listRecentPosts'
            _arguments:
                page: '@widget_0/currentPage'
        defaultController: 'Post::listRecentPosts'
        requirements:
            page: '\d+'
        aspects:
            page:
                type: StaticRangeMapper
                start: '1'
                end: '99'

Posts by Tag
^^^^^^^^^^^^

.. code-block:: yaml
   :linenos:

   routeEnhancers:
      BlogTag:
        type: Extbase
        extension: Blog
        plugin: Tag
        routes:
        -
            routePath: '/{tag_title}'
            _controller: 'Post::listPostsByTag'
            _arguments:
            tag_title: tag
        -
            routePath: '/{tag_title}/page-{page}'
            _controller: 'Post::listPostsByTag'
            _arguments:
            tag_title: tag
            page: '@widget_0/currentPage'
        defaultController: 'Post::listPostsByTag'
        requirements:
            tag_title: '^[a-z0-9].*$'
            page: '\d+'
        aspects:
            tag_title:
                type: PersistedAliasMapper
                tableName: tx_blog_domain_model_tag
                routeFieldName: 'slug'
            page:
                type: StaticRangeMapper
                start: '1'
                end: '99'

BlogStaticDatabaseMapper
^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php
   :linenos: 
   
   <?php
        declare(strict_types = 1);

        /*
        * This file is part of the package t3g/blog.
        *
        * For the full copyright and license information, please read the
        * LICENSE file that was distributed with this source code.
        */

        namespace T3G\AgencyPack\Blog\Routing\Aspect;

        use TYPO3\CMS\Core\Database\ConnectionPool;
        use TYPO3\CMS\Core\Routing\Aspect\StaticMappableAspectInterface;
        use TYPO3\CMS\Core\Utility\GeneralUtility;

        class StaticDatabaseMapper implements StaticMappableAspectInterface, \Countable
        {
            /**
            * @var array
            */
            protected $settings;

            /**
            * @var string
            */
            protected $field;

            /**
            * @var string
            */
            protected $table;

            /**
            * @var string
            */
            protected $groupBy;

            /**
            * @var array
            */
            protected $where;

            /**
            * @var array
            */
            protected $values;

            /**
            * @param array $settings
            * @throws \InvalidArgumentException
            */
            public function __construct(array $settings)
            {
                $field = $settings['field'] ?? null;
                $table = $settings['table'] ?? null;
                $where = $settings['where'] ?? [];
                $groupBy = $settings['groupBy'] ?? '';

                if (!is_string($field)) {
                    throw new \InvalidArgumentException('field must be string', 1550156808);
                }
                if (!is_string($table)) {
                    throw new \InvalidArgumentException('table must be string', 1550156812);
                }
                if (!is_string($groupBy)) {
                    throw new \InvalidArgumentException('groupBy must be string', 1550158149);
                }
                if (!is_array($where)) {
                    throw new \InvalidArgumentException('where must be an array', 1550157442);
                }

                $this->settings = $settings;
                $this->field = $field;
                $this->table = $table;
                $this->where = $where;
                $this->groupBy = $groupBy;
                $this->values = $this->buildValues();
            }

            /**
            * {@inheritdoc}
            */
            public function count(): int
            {
                return count($this->values);
            }

            /**
            * {@inheritdoc}
            */
            public function generate(string $value): ?string
            {
                return $this->respondWhenInValues($value);
            }

            /**
            * {@inheritdoc}
            */
            public function resolve(string $value): ?string
            {
                return $this->respondWhenInValues($value);
            }

            /**
            * @param string $value
            * @return string|null
            */
            protected function respondWhenInValues(string $value): ?string
            {
                if (in_array($value, $this->values, true)) {
                    return $value;
                }
                return null;
            }

            /**
            * Builds range based on given settings and ensures each item is string.
            * The amount of items is limited to 1000 in order to avoid brute-force
            * scenarios and the risk of cache-flooding.
            *
            * In case that is not enough, creating a custom and more specific mapper
            * is encouraged. Using high values that are not distinct exposes the site
            * to the risk of cache-flooding.
            *
            * @return string[]
            * @throws \LengthException
            */
            protected function buildValues(): array
            {
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getQueryBuilderForTable($this->table);

                $queryBuilder
                    ->select($this->field)
                    ->from($this->table);

                if ($this->groupBy !== '') {
                    $queryBuilder->groupBy($this->groupBy);
                }

                if (!empty($this->where)) {
                    foreach ($this->where as $key => $value) {
                        $queryBuilder->andWhere($key, $queryBuilder->createNamedParameter($value));
                    }
                }

                return array_map('strval', array_column($queryBuilder->execute()->fetchAll(), $this->field));
            }
        }


Usage with imports
^^^^^^^^^^^^^^^^^^

On typo3.com we are using imports to make routing configurations easier to manage:

.. code-block:: yaml
   :linenos: 

    imports:
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogCategory.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogTag.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogArchive.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogAuthorPosts.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogFeedWidget.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Blog/BlogPosts.yaml" }

Full project example config
===========================

Taken from an anonymous live project:

.. code-block:: yaml
   :linenos:

    routeEnhancers:
        news:
            type: Extbase
            extension: mynews
            plugin: mynews
            routes:
                - routePath: '/news/detail/{news}'
                    _controller: 'News::show'
                    _arguments:
                    news: news
                - routePath: '/search-result/{searchFormHash}'
                    _controller: 'News::list'
                    _arguments:
                        searchForm: searchForm
            defaultController: 'News::show'
            aspects:
                news:
                    routeValuePrefix: ''
                    type: PersistedAliasMapper
                    tableName: 'tx_mynews_domain_model_news'
                    routeFieldName: slug
                    valueFieldName: uid
        videos:
            type: Extbase
            extension: myvideos
            plugin: myvideos
            routes:
                - 
                    routePath: '/video-detail/detail/{videos}'
                    _controller: 'Videos::show'
                    _arguments:
                        videos: videos
                -
                    routePath: '/search-result/{searchFormHash}'
                    _controller: 'Videos::list'
                    _arguments:
                        searchForm: searchForm
            defaultController: 'Videos::show'
            aspects:
                videos:
                    routeValuePrefix: ''
                    type: PersistedAliasMapper
                    tableName: 'tx_myvideos_domain_model_videos'
                    routeFieldName: slug
                    valueFieldName: uid
        discipline:
            type: Extbase
            extension: myvideos
            plugin: overviewlist
            routes:
               - 
                    routePath: '/video-uebersicht/disziplin/{discipline}'
                    _controller: 'Overview::discipline'
                    _arguments:
                        discipline: discipline
            defaultController: 'Overview::discipline'
            aspects:
                discipline:
                    routeValuePrefix: ''
                    type: PersistedAliasMapper
                    tableName: 'tx_mytaxonomy_domain_model_discipline'
                    routeFieldName: slug
                    valueFieldName: uid
        events:
            type: Extbase
            extension: myapidata
            plugin: events
            routes:
                - 
                    routePath: '/events/detail/{uid}'
                    _controller: 'Events::showByUid'
                    _arguments:
                        uid: uid
                - 
                    routePath: '/events/search-result/{searchFormHash}'
                    _controller: 'Events::list'
                    _arguments:
                        searchForm: searchForm
            defaultController: 'Events::showByUid'
            requirements:
                uid: '[a-zA-Z0-9-_]+'
            aspects:
                uid:
                    routeValuePrefix: ''
                    type: PersistedAliasMapper
                    tableName: 'tx_myapidata_domain_model_event'
                    routeFieldName: slug
                    valueFieldName: uid
        results:
            type: Extbase
            extension: myapidata
            plugin: results
            routes:
            - 
                routePath: '/resultset/detail/{uid}'
                _controller: 'Results::showByUid'
                _arguments:
                    uid: uid
            -   
                routePath: '/resultset/search-result/{searchFormHash}'
                _controller: 'Results::list'
                _arguments:
                    searchForm: searchForm
            defaultController: 'Results::showByUid'
            aspects:
            uid:
                routeValuePrefix: ''
                type: PersistedAliasMapper
                tableName: 'tx_myapidata_domain_model_event'
                routeFieldName: slug
                valueFieldName: uid
        teams:
            type: Extbase
            extension: myapidata
            plugin: teams
            routes:
              - 
                routePath: '/detail/{team}'
                _controller: 'Team::show'
                _arguments:
                    team: team
              - 
                routePath: '/player/result/{searchFormHash}'
                _controller: 'Team::list'
                _arguments:
                    searchForm: searchForm
            defaultController: 'Team::show'
            requirements:
                team: '[a-zA-Z0-9-_]+'
            aspects:
                team:
                    routeValuePrefix: ''
                    type: PersistedAliasMapper
                    tableName: 'tx_myapidata_domain_model_team'
                    routeFieldName: slug
                    valueFieldName: uid
        moreLoads:
            type: PageType
            map:
                'videos/events/videos.json': 1381404385
                'videos/categories/videos.json': 1381404386
                'videos/favorites/videos.json': 1381404389
                'videos/newest/videos.json': 1381404390


REST API with Custom Enhancer
=============================

**Registration** of custom enhancer in `ext_localconf.php`:

.. code-block:: php
   :linenos:

   (function (): void {
    $GLOBALS['TYPO3_CONF_VARS'] = \array_replace_recursive(
         $GLOBALS['TYPO3_CONF_VARS'],
            [
                'SYS' => [
                    'routing' => [
                        'enhancers' => [
                            'RestApi' => \Custom\Restapi\Routing\RestApiEnhancer::class
                        ]
                    ]
                ]
            ]
        );
    })();

**Route configuration**

.. code-block:: yaml
   :linenos: 

   routeEnhancers:
        RestApiPage:
            type: RestApi
            limitToPages:
                - 3
            routes:
                -
                    routePath: '/v1/page/header'
                    _method: GET
                    _controller: 'Custom\Restapi\Provider\Page\HeaderProvider::request'
                    _arguments:
                        pageUid: '1'
                -
                    routePath: '/v1/page/header/{pageUid}'
                    _method: GET
                    _controller: 'Custom\Restapi\Provider\Page\HeaderProvider::request'
                    _arguments:
                        pageUid: pageUid
                -
                    routePath: '/v1/page/footer'
                    _method: GET
                    _controller: 'Custom\Restapi\Provider\Page\FooterProvider::request'
                    _arguments:
                        pageUid: '1'
                -
                    routePath: '/v1/page/footer/{pageUid}'
                    _method: GET
                    _controller: 'Custom\Restapi\Provider\Page\FooterProvider::request'
                    _arguments:
                        pageUid: pageUid
            defaults:
                pageUid: '1'
            requirements:
                pageUid: \d+


**Enhancer**

Based on the plugin enhancer and extbase plugin enhancer, extended with parameters `method` and `restApi`:

.. code-block:: php
   :linenos:

   <?php
        declare(strict_types = 1);

        namespace Custom\Restapi\Routing;

        use TYPO3\CMS\Core\Routing\Enhancer\PluginEnhancer;
        use TYPO3\CMS\Core\Routing\Route;
        use TYPO3\CMS\Core\Routing\RouteCollection;

        /**
        * Class RestApiEnhancer
        * @package Custom\Restapi\Routing
        * @codeCoverageIgnore
        */
        class RestApiEnhancer extends PluginEnhancer
        {
            /**
            * @var array
            */
            protected $routesOfPlugin;

            /**
            * ByPassEnhancer constructor.
            * @param array $configuration
            */
            public function __construct(array $configuration)
            {
                parent::__construct($configuration);
                $this->namespace = \md5(\json_encode($configuration));
                $this->routesOfPlugin = $this->configuration['routes'] ?? [];
            }

            /**
            * {@inheritdoc}
            */
            public function enhanceForMatching(RouteCollection $collection): void
            {
                $i = 0;
                /** @var Route $defaultPageRoute */
                $defaultPageRoute = $collection->get('default');
                foreach ($this->routesOfPlugin as $configuration) {
                    $route = $this->getVariant($defaultPageRoute, $configuration);
                    $collection->add($this->namespace . '_' . $i++, $route);
                }
            }

            /**
            * {@inheritdoc}
            */
            protected function getVariant(Route $defaultPageRoute, array $configuration): Route
            {
                $arguments = $configuration['_arguments'] ?? [];
                unset($configuration['_arguments']);

                $namespacedRequirements = $this->getNamespacedRequirements();
                $routePath = $this->modifyRoutePath($configuration['routePath']);
                $routePath = $this->getVariableProcessor()->deflateRoutePath($routePath, '', $arguments);
                unset($configuration['routePath']);
                $defaults = \array_merge_recursive($defaultPageRoute->getDefaults(), $configuration);
                $options = \array_merge(
                    $defaultPageRoute->getOptions(),
                    ['_enhancer' => $this, 'utf8' => true, '_arguments' => $arguments]
                );
                $route = new Route(
                    \rtrim($defaultPageRoute->getPath(), '/') . '/' . ltrim($routePath, '/'),
                    $defaults,
                    [],
                    $options
                );
                $this->applyRouteAspects($route, $this->aspects ?? [], '');

                if ($namespacedRequirements) {
                    $compiledRoute = $route->compile();
                    $variables = $compiledRoute->getPathVariables();
                    $variables = \array_flip($variables);
                    $requirements = \array_filter(
                        $namespacedRequirements,
                        function ($key) use ($variables) {
                            return isset($variables[$key]);
                        },
                        ARRAY_FILTER_USE_KEY
                    );
                    $route->setRequirements($requirements);
                }
                return $route;
            }

            /**
            * {@inheritdoc}
            */
            public function enhanceForGeneration(RouteCollection $collection, array $originalParameters): void
            {
                if (!\is_array($originalParameters ?? null)) {
                    return;
                }

                $i = 0;
                /** @var Route $defaultPageRoute */
                $defaultPageRoute = $collection->get('default');
                foreach ($this->routesOfPlugin as $configuration) {
                    $variant = $this->getVariant($defaultPageRoute, $configuration);
                    // The enhancer tells us: This given route does not match the parameters
                    if (!$this->verifyRequiredParameters($variant, $originalParameters)) {
                        continue;
                    }
                    $parameters = $originalParameters;
                    unset(
                        $parameters['action'],
                        $parameters['controller'],
                        $parameters['method']
                    );

                    $compiledRoute = $variant->compile();
                    $deflatedParameters = $this->deflateParameters($variant, $parameters);
                    $variables = \array_flip($compiledRoute->getPathVariables());
                    $mergedParams = \array_replace($variant->getDefaults(), $deflatedParameters);
                    // all params must be given, otherwise we exclude this variant
                    if ($diff = \array_diff_key($variables, $mergedParams)) {
                        continue;
                    }
                    $variant->addOptions(['deflatedParameters' => $deflatedParameters]);
                    $collection->add($this->namespace . '_' . $i++, $variant);
                }
            }

            /**
            * A route has matched the controller/action/method combination
            *
            * @param array $parameters Actual parameter payload to be used
            * @param array $internals Internal instructions (_route, _controller, _method, ...)
            * @return array
            */
            public function inflateParameters(array $parameters, array $internals = []): array
            {
                $parameters = $this->getVariableProcessor()->inflateParameters($parameters) ?? [];

                $this->applyControllerActionValues(
                    $internals['_controller'],
                    $internals['_method'] ?? 'GET',
                    $parameters
                );

                return $parameters;
            }

            /**
            * Check if controller+action combination matches
            *
            * @param Route $route
            * @param array $parameters
            * @return bool
            */
            protected function verifyRequiredParameters(Route $route, array $parameters): bool
            {
                if (!\is_array($parameters)) {
                    return false;
                }
                if (!$route->hasDefault('_controller')) {
                    return false;
                }
                if (!$route->hasDefault('_method')) {
                    return false;
                }
                $controller = $route->getDefault('_controller');
                list($controllerName, $actionName) = explode('::', $controller);
                if ($controllerName !== $parameters['controller']) {
                    return false;
                }
                if ($actionName !== $parameters['action']) {
                    return false;
                }
                return true;
            }

            /**
            * Add controller and action parameters so they can be used later-on.
            *
            * @param string $controllerActionValue
            * @param string $methodName
            * @param array $target
            */
            protected function applyControllerActionValues(string $controllerActionValue, string $methodName, array &$target): void
            {
                if (\strpos($controllerActionValue, '::') === false) {
                    return;
                }
                [$controllerName, $actionName] = explode('::', $controllerActionValue, 2);
                $target['controller'] = $controllerName;
                $target['action'] = $actionName;
                $target['method'] = $methodName;
                $target['restApi'] = true;
            }
        }

EXT: DpnGlossary
================

**Prerequisites:**

The plugin for *list view* and *detail view* is added on one page.

**Result:**

* List view: ``https://www.example.com/[YOUR_PLUGINPAGE_SLUG]``
* Detail view: ``https://www.example.com/[YOUR_PLUGINPAGE_SLUG]/term/the-term-title``

.. code-block:: yaml
   :linenos: 

   routeEnhancers:
     DpnGlossary:
        type: Extbase
        limitToPages: [YOUR_PLUGINPAGE_UID]
        extension: DpnGlossary
        plugin: glossary
        routes:
        - { routePath: '/{character}', _controller: 'Term::list', _arguments: {'character': '@widget_0/character'} }
        - { routePath: '/{localized_term}/{term_name}', _controller: 'Term::show', _arguments: {'term_name': 'term'} }
        defaultController: 'Term::list'
        defaults:
          character: ''
        aspects:
          term_name:
            type: PersistedAliasMapper
            tableName: 'tx_dpnglossary_domain_model_term'
            routeFieldName: 'url_segment'
          character:
            type: StaticMultiRangeMapper
            ranges:
              - start: 'A'
                end: 'Z'
          localized_term:
            type: LocaleModifier
            default: 'term'
            localeMap:
            - locale: 'de_DE.*'
              value: 'begriff'

Taken from `dpn_glossary manual <https://docs.typo3.org/typo3cms/extensions/dpn_glossary/3.0.2/Configuration/ExampleTypoScriptSetup/Index.html#configure-routing-for-terms-and-pagination>`__.
