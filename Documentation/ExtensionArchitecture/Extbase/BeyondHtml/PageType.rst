:navigation-title: typeNum page types

..  include:: /Includes.rst.txt
..  index::
    pair: Extbase; typeNum
    pair: Extbase; Page type
..  _extbase-beyond-html-page-type:

==================================================
Delivering Extbase output with a typeNum page type
==================================================

A typeNum page type delivers another representation of a page: the same page,
in the same site and language, with the same access checks and the same page
cache, rendered by a dedicated TypoScript :typoscript:`PAGE` object instead of
the page template. It is the most widespread way to get JSON, XML or an HTML
fragment out of an Extbase plugin, and a good tool to have at hand.

What the plugin sees in a page type depends on what the :typoscript:`PAGE`
object renders. When it renders the plugin's content element, the plugin
works with the settings and the storage folder an editor chose, exactly as on
the regular page. When it renders the plugin on its own, the plugin works with
its TypoScript configuration.

This page builds an RSS feed for conference lists that editors filter
themselves, and then shows the variants for output that does not belong to a
content element on the page.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-page-type-what:

What a typeNum page type is in TYPO3
====================================

Every TYPO3 frontend page is rendered by a TypoScript
`PAGE <https://docs.typo3.org/permalink/t3tsref:page-datatype>`_ object. The
one that renders the regular HTML page has
`typeNum <https://docs.typo3.org/permalink/t3tsref:confval-page-typenum>`_
`0`. Further :typoscript:`PAGE` objects with other numbers can be defined next
to it. The `type` query parameter selects one of them: `?type=1762214400`
renders the same page, in the same site and language, with the other
:typoscript:`PAGE` object.

The core uses this itself. The
`XML sitemap <https://docs.typo3.org/permalink/t3coreapi:xmlsitemap>`_ of
:file:`EXT:seo` is a :typoscript:`PAGE` object with
:typoscript:`typeNum = 1533906435`.

..  note::

    A typeNum page type is unrelated to the
    `page types <https://docs.typo3.org/permalink/t3coreapi:page-types>`_ an
    editor selects for a page record, such as "Standard", "Folder" or
    "Shortcut". Those are stored in the `doktype` field of the page. Both are
    called "page type" in many places, which makes searching for either one
    harder than it should be.


..  _extbase-beyond-html-page-type-plugin:

Rendering an Extbase plugin in a typeNum page type
==================================================

The example site has several conference lists: all conferences, conferences
in Europe, conferences this year. Each one is a page with a conference list
plugin, and an editor chose the storage folder and the filter in the plugin's
content element. Every list page also offers its selection as an
`RSS feed <https://en.wikipedia.org/wiki/RSS>`_ at a URL ending in
:file:`feed.xml`.

The feed is a second representation of the list page, so a typeNum page type
fits. It renders the conference list content element of the current page and
ignores everything else an editor placed there. Four pieces work together: the
plugins, a :typoscript:`PAGE` object, a template in the XML format, and a
route that maps the URL suffix to the page type.

The list plugin is configured and
:ref:`registered as a content element <extbase-registration-frontend-plugin-register>`
as usual. The feed plugin is only configured: editors never place it, the
:typoscript:`PAGE` object renders it, so it needs no
:php:`registerPlugin()` call:

..  literalinclude:: _snippets/_ext_localconf.php
    :caption: EXT:my_extension/ext_localconf.php

The :typoscript:`PAGE` object selects the list content element with a
`CONTENT <https://docs.typo3.org/permalink/t3tsref:cobj-content>`_ object and
renders the feed plugin for it with
`EXTBASEPLUGIN <https://docs.typo3.org/permalink/t3tsref:cobj-extbaseplugin>`_:

..  literalinclude:: _snippets/_setup.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

*   :typoscript:`CONTENT` searches the current page, in the current language,
    as the page template does. The :typoscript:`where` clause restricts it to
    content elements of the list plugin, so text, images and other plugins on
    the page do not end up in the feed. An RSS document has one channel, so
    :typoscript:`max = 1` takes only the first list.
*   The :typoscript:`renderObj` runs once for the selected content element,
    with the content element as its record. The feed plugin therefore reads the
    storage folder and the FlexForm settings of the list, see
    :ref:`What the PAGE object renders decides the configuration <extbase-beyond-html-page-type-content-element>`.
*   The :typoscript:`renderObj` is :typoscript:`EXTBASEPLUGIN` and not
    :typoscript:`tt_content.myextension_conferencelist`. The content element
    rendering wraps the plugin output in the HTML of the content element
    layout, which has no place in an XML document.
*   `disableAllHeaderCode <https://docs.typo3.org/permalink/t3tsref:confval-config-disableallheadercode>`_
    removes everything TYPO3 adds around the content: the HTML document
    structure, the `<head>` and the `<body>`. Only the plugin output is left.
*   `admPanel <https://docs.typo3.org/permalink/t3tsref:confval-config-admpanel>`_
    keeps the Admin Panel out of the feed for logged-in backend users.
*   The TypoScript settings of the feed plugin provide the defaults for the
    channel. The FlexForm settings of the list element are merged on top of
    them.

The controller applies the same filter the list uses. It sets the request
format to `xml` before the view is created, and returns the rendered view with
the content type of an RSS feed:

..  literalinclude:: _snippets/_ConferenceFeedController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceFeedController.php

:php:`findFiltered()` stands for the repository method the list action calls
with the same settings, see
:ref:`Queries in Extbase <extbase-persistence-queries>`. The storage folder
needs no code: Extbase takes it from the list element and restricts every
query to it.

The format decides which template file Extbase looks for. With format `xml`,
the action :php:`feedAction()` renders
:file:`Templates/ConferenceFeed/Feed.fluid.xml` instead of
:file:`Feed.fluid.html`, see
:ref:`Fluid template file resolution <extbase-view-templates>`. Setting the
format in :php:`initializeFeedAction()` ties it to this one action. The
TypoScript option :confval:`format <extbase-configuration-typoscript-format>`
would change the default for every action of the plugin.

The template is plain XML with Fluid syntax. Fluid escapes every variable it
outputs, so titles and descriptions containing `&` or `<` stay valid XML:

..  literalinclude:: _snippets/_Feed.fluid.xml
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceFeed/Feed.fluid.xml

The :php:`Content-Type` header of the action's response becomes the
content type of the whole page. TYPO3 stores it with the page in the page
cache, so cached deliveries keep it. A :typoscript:`PAGE` object that renders
an Extbase plugin therefore does not need
`config.additionalHeaders <https://docs.typo3.org/permalink/t3tsref:confval-config-additionalheaders>`_
to set the content type. The sitemap of :file:`EXT:seo` needs it, because its
renderer is not an Extbase plugin.

Finally, the
`PageType decorator <https://docs.typo3.org/permalink/t3coreapi:routing-pagetype-decorator>`_
maps the page type to a URL suffix, so the feed of the page
:samp:`https://example.org/conferences/europe` is available at
:samp:`https://example.org/conferences/europe/feed.xml` instead of
:samp:`https://example.org/conferences/europe?type=1762214400`:

..  literalinclude:: _snippets/_route-enhancers.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

If the site already defines a PageType decorator, add the entry to its
:yaml:`map` rather than defining a second one.

The list template links to the feed of its own page by passing the page type
to a page link:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <f:link.page pageType="1762214400">Subscribe to this list as a feed</f:link.page>

A new list page needs nothing but the list content element. The feed follows
the editor's filter without any further configuration, and on a page without
a conference list the :typoscript:`CONTENT` object finds nothing to render.


..  _extbase-beyond-html-page-type-content-element:

What the PAGE object renders decides the configuration
======================================================

A plugin takes part of its configuration from the record its content object
is rendered for: the
:ref:`FlexForm settings <extbase-configuration-reference>` an editor filled in,
and the :guilabel:`Record Storage Page` that sets the
:ref:`storagePid <extbase-persistence-storagepid>`. The page type itself does
not change this. Only the :typoscript:`PAGE` object's content does:

*   On the regular page, the page template renders the content elements, and
    every plugin is rendered for its own content element. The same is true in
    a page type that renders content elements with :typoscript:`CONTENT` or
    :typoscript:`RECORDS`.
*   :typoscript:`EXTBASEPLUGIN` placed directly in the :typoscript:`PAGE`
    object is rendered for the page record, which carries no FlexForm and no
    storage page. The plugin then works with its TypoScript settings, and its
    queries use the storagePid from TypoScript, or page `0` if none is set.

Which one fits depends on where the configuration lives. The following
sections show the two variants that do not take it from a content element on
the current page.


..  _extbase-beyond-html-page-type-plugin-only:

Rendering the plugin without a content element
----------------------------------------------

A page type that renders :typoscript:`EXTBASEPLUGIN` directly suits output
of one plugin that is configured in TypoScript, for example the next page of
a paginated list that a script loads without reloading the page:

..  literalinclude:: _snippets/_setup_plugin.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The links of the pagination carry the page type and the plugin arguments, so
the plugin receives the requested page number as it does on the regular page,
and each page of the list is cached on its own. When editors configure the
list in its content element instead, select that element with
:typoscript:`CONTENT` as in the feed example.


..  _extbase-beyond-html-page-type-records:

Rendering one known content element on every page
-------------------------------------------------

A `RECORDS <https://docs.typo3.org/permalink/t3tsref:cobj-records>`_ object
renders a content element by its uid, wherever it is stored. That suits a
fragment that is the same on every page, for example a short list of upcoming
conferences in the sidebar, which a small script in the page layout loads
from the page type:

..  literalinclude:: _snippets/_setup_records.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

An editor configures the short list in content element `123`, and the plugin
is rendered for exactly that element on whatever page requests the page type.
The uid is fixed in TypoScript, so it fits a content element that is known
and stays in place, not one that editors create and delete.


..  _extbase-beyond-html-page-type-page-fields:

Configuring the plugin in the page record as a last resort
----------------------------------------------------------

Extbase does not check which table the record comes from. It reads the fields
:sql:`pages`, :sql:`recursive` and :sql:`pi_flexform` by name. When the page
record has fields with these names, a plugin rendered directly by
:typoscript:`EXTBASEPLUGIN` uses them as it would use the fields of a content
element. Adding the three fields to the :sql:`pages` table in
:ref:`TCA <t3tca:start>`, showing them for a dedicated
`page type <https://docs.typo3.org/permalink/t3coreapi:page-types-example>`_,
and restricting the typeNum page type to that page type with a condition lets
editors configure the output in the page properties.

The field names are dictated by Extbase and end up as generic names in a core
table that every extension extends, where another extension can add a field
with the same name. Use it only when the output needs editor input and there
is no content element to take it from.


..  _extbase-beyond-html-page-type-caching:

Caching an Extbase plugin in a typeNum page type
================================================

A typeNum page type is cached like any other page. The page type is part of
the page cache identifier, so the feed and the HTML page are cached
separately, and the feed is rendered once and then delivered from the cache
until the cache is cleared. Extbase plugin arguments in the URL create one
cache entry per argument combination, protected by the
`cHash <https://docs.typo3.org/permalink/t3coreapi:chash>`_.

An action listed as non-cacheable turns the plugin into a
:ref:`USER_INT object <extbase-caching-noncacheable-userint>` automatically,
exactly as it does in a content element. Wrapping the plugin in a
:typoscript:`COA_INT`, as some tutorials do, is not necessary.

To refresh the feed when a conference changes, use
:ref:`cache tags <extbase-caching-cachetags>` as for any other cached plugin
output.


..  _extbase-beyond-html-page-type-cost:

What to keep in mind with a typeNum page type
=============================================

A page type is a full frontend page, with everything that brings. A few
consequences are worth knowing before adding one.

The frontend rendering runs for every uncached request
    TYPO3 resolves the site and the page, checks access, evaluates the site's
    TypoScript and renders the :typoscript:`PAGE` object. From the page cache
    that is fast. Output that cannot be cached, such as anything depending on
    the logged-in frontend user, goes through all of it on every request.

The page type inherits the site's configuration
    The :typoscript:`PAGE` object starts from the global :typoscript:`config`
    of the site, which is why page type examples switch off options such as
    :typoscript:`disableAllHeaderCode` and :typoscript:`admPanel`. A
    site-wide option added later reaches the page type as well.

The page type exists on every page
    A :typoscript:`PAGE` object applies wherever its TypoScript applies,
    usually to the whole site. Selecting the content with
    :typoscript:`CONTENT`, as in the feed example, keeps the output empty
    where it does not belong. TypoScript conditions can restrict a page type
    to some pages.

The typeNum is a number nothing reserves
    Every :typoscript:`PAGE` object needs a number that is unique in the site's
    TypoScript, and two extensions choosing the same number overwrite each
    other's page type without an error. A number derived from a timestamp,
    such as `1533906435` in :file:`EXT:seo`, makes a collision unlikely.

The configuration spans several places
    The plugin configuration in :file:`ext_localconf.php`, the
    :typoscript:`PAGE` object in TypoScript, and the PageType decorator in the
    site's routing work together. A site set ships the TypoScript and the
    routing in one place.


..  _extbase-beyond-html-page-type-when:

When a typeNum page type is the right tool
==========================================

A typeNum page type fits when the output belongs to a page or benefits from
what a page brings: a site, a language, access checks, and the page cache.

*   **Feeds and exports** such as RSS or Atom feeds, calendar files in the
    `iCalendar <https://en.wikipedia.org/wiki/ICalendar>`_ format, or a
    :abbr:`CSV (Comma-Separated Values)` export of a list on the page.
*   **Sitemaps and other machine-readable views of the page tree**, as in
    :file:`EXT:seo`.
*   **Alternative views of a page**, such as a print version.
*   **Parts of a page that a script loads**, such as the next page of a
    list or a fragment shown on every page.

It is also the natural approach outside Extbase. A page type does not need a
plugin at all: TypoScript content objects such as
`CONTENT <https://docs.typo3.org/permalink/t3tsref:cobj-content>`_ or
`PAGEVIEW <https://docs.typo3.org/permalink/t3tsref:cobj-pageview>`_ can
produce JSON or XML on their own, and the page type delivers their output
under its own URL.

For small data that needs neither a page nor TypoScript, such as a live status
or search suggestions, an endpoint that answers before the page rendering
starts can be the lighter choice.


..  _extbase-beyond-html-page-type-next:

Alternatives to a typeNum page type
===================================

TYPO3 offers several other ways to deliver output that is not an HTML page,
from requesting the regular page to answering in a middleware before any page
is rendered. :ref:`Ways to deliver non-HTML output from TYPO3
<extbase-beyond-html-options>` compares them, including what each one has
available and what each one is suited for.
