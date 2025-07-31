:navigation-title: Examples
..  include:: /Includes.rst.txt
..  index:: Routing; Examples
..  _routing-examples:

======================================
Collection of various routing examples
======================================

..  contents:: Table of contents

..  note::
    If you have additional examples and are willing to share, please create a
    Pull Request on Github and add it to this page.


..  index:: Routing; EXT: News
..  _routing-examples-news:

EXT: News
=========

**Prerequisites:**

The plugins for *list view* and *detail view* are on separate pages.
If you use the *category menu* or *tag list* plugins to filter news records, their titles (slugs) are used.

**Result:**

*   Detail view: :samp:`https://example.org/news/detail/the-news-title`
*   Pagination: :samp:`https://example.org/news/page-2`
*   Category filter: :samp:`https://example.org/news/my-category`
*   Tag filter: :samp:`https://example.org/news/my-tag`

..  literalinclude:: _codesnippets/_news.yaml
    :caption: config/my_site/config.yaml (excerpt)

For more examples and background information see the
:ref:`routing examples in the "News" manual <georgringer/news:routing>`.


..  index:: Routing; EXT: Blog
..  _routing-examples-blog:

EXT: Blog with custom aspect
============================

Taken from https://typo3.com routing configuration and the blog extension.

Blog Archive:

..  literalinclude:: _codesnippets/_blog_archive.yaml
    :caption: config/my_site/config.yaml (excerpt)

Posts by Author:

..  literalinclude:: _codesnippets/_blog_author.yaml
    :caption: config/my_site/config.yaml (excerpt)


Category pages:

..  literalinclude:: _codesnippets/_blog_category.yaml
    :caption: config/my_site/config.yaml (excerpt)

Blog Feeds:

..  literalinclude:: _codesnippets/_blog_feeds.yaml
    :caption: config/my_site/config.yaml (excerpt)


Blog Posts:

..  literalinclude:: _codesnippets/_blog_posts.yaml
    :caption: config/my_site/config.yaml (excerpt)

Posts by Tag:

..  literalinclude:: _codesnippets/_blog_tags.yaml
    :caption: config/my_site/config.yaml (excerpt)


BlogStaticDatabaseMapper:

..  literalinclude:: _codesnippets/_StaticDatabaseMapper.php
    :caption: packages/my_extension/Classes/Routing/Aspect/StaticDatabaseMapper.php

..  _routing-examples-imports:

Usage with imports
~~~~~~~~~~~~~~~~~~

On typo3.com we are using imports to make routing configurations easier to manage:

..  literalinclude:: _codesnippets/_imports.yaml
    :caption: config/my_site/config.yaml (excerpt)

..  _routing-examples-project:

Full project example config
===========================

Taken from an anonymous live project:

..  literalinclude:: _codesnippets/_full.yaml
    :caption: config/my_site/config.yaml (excerpt)

..  index:: Routing; EXT: DpnGlossary
..  _routing-examples-glossary:

EXT: DpnGlossary
================

**Prerequisites:**

*   The plugin for *list view* and *detail view* is added on one page.
*   The `StaticMultiRangeMapper <https://github.com/featdd/dpn_glossary/blob/master/Classes/Routing/Aspect/StaticMultiRangeMapper.php>`__
    (a custom mapper) is available in the project.

**Result:**

*   List view: :samp:`https://example.org/<YOUR_PLUGINPAGE_SLUG>`
*   Detail view: :samp:`https://example.org/<YOUR_PLUGINPAGE_SLUG>/term/the-term-title`

..  literalinclude:: _codesnippets/_glossary.yaml
    :caption: config/my_site/config.yaml (excerpt)

Taken from dpn_glossary extension manual.
