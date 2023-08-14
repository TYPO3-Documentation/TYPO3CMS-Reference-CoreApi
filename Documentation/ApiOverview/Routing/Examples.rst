.. include:: /Includes.rst.txt
.. index:: Routing; Examples
.. _routing-examples:

======================================
Collection of various routing examples
======================================

.. note::
   If you have additional examples and are willing to share, please create a Pull Request on Github and add it to this page.


.. index:: Routing; EXT: News

EXT: News
=========

**Prerequisites:**

The plugins for *list view* and *detail view* are on separate pages.
If you use the *category menu* or *tag list* plugins to filter news records, their titles (slugs) are used.

**Result:**

* Detail view: :samp:`https://example.org/news/detail/the-news-title`
* Pagination: :samp:`https://example.org/news/page-2`
* Category filter: :samp:`https://example.org/news/my-category`
* Tag filter: :samp:`https://example.org/news/my-tag`

.. code-block:: yaml

   routeEnhancers:
     News:
       type: Extbase
       extension: News
       plugin: Pi1
       routes:
         - routePath: '/page-{page}'
           _controller: 'News::list'
           _arguments:
             page: currentPage
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

For more examples and background information see the
:ref:`routing examples in the "News" manual <ext_news:routing>`.


.. index:: Routing; EXT: Blog

EXT: Blog with custom aspect
============================

Taken from https://typo3.com routing configuration and the blog extension.

Archive
^^^^^^^

.. code-block:: yaml

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
        aspects:
          page:
            type: StaticRangeMapper
            start: '1'
            end: '99'

Posts by Tag
^^^^^^^^^^^^

.. code-block:: yaml

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

                return array_map('strval', array_column($queryBuilder->executeQuery()->fetchAllAssociative(), $this->field));
            }
        }


Usage with imports
^^^^^^^^^^^^^^^^^^

On typo3.com we are using imports to make routing configurations easier to manage:

.. code-block:: yaml

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


.. index:: Routing; EXT: DpnGlossary

EXT: DpnGlossary
================

**Prerequisites:**

* The plugin for *list view* and *detail view* is added on one page.
* The `StaticMultiRangeMapper <https://github.com/featdd/dpn_glossary/blob/master/Classes/Routing/Aspect/StaticMultiRangeMapper.php>`__
  (a custom mapper) is available in the project.

**Result:**

* List view: :samp:`https://example.org/<YOUR_PLUGINPAGE_SLUG>`
* Detail view: :samp:`https://example.org/<YOUR_PLUGINPAGE_SLUG>/term/the-term-title`

.. code-block:: yaml

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

Taken from dpn_glossary extension manual.
