:navigation-title: Routing

..  include:: /Includes.rst.txt
..  index::
    Routing
    SEO-friendly URLs
    Speaking URLs
    Readable URLs
    see: Speaking URLs; Routing
..  _routing:
..  _routing-introduction:

=====================================
Routing - readable, SEO-friendly URLs
=====================================

When TYPO3 serves a request, it maps the incoming URL to a specific page or action.
For example it maps an URL like :samp:`https://example.org/news` to the News page. This process of
determining the page and/or action to execute for a specific URL is called "Routing".

The input of a route is made up of several components; some components can also be split further
into sub-components.

Routing will also take care of beautifying URI parameters, for example converting
:samp:`https://example.org/profiles?user=magdalena` to :samp:`https://example.org/profiles/magdalena`.

..  contents:: Table of contents

..  toctree::
    :caption: Subpages
    :titlesonly:
    :maxdepth: 1

    EnhancementsAspects/Index
    Extending/Index
    Examples/Index

..  _routing-terminology:

Key terminology
===============

Given a complex link (`URI`, `Uniform Resource Identificator`) like

..  code-block:: plaintext

    https://subdomain.example.com:80/en/about-us/our-team/john-doe/publications/index.xhtml?utm_campaign=seo#start

all of its components can be broken down to:

..  table::
    :width: 100%
    :break: none

    +----------+------------+----------+-----+------+----------------------+--------------------+----------------+----------------+-------+------------------+----------------+----------------+------------------------+
    | https:// | subdomain. | example. | com | :80  | /en                  | /about-us/our-team | /john-doe      | /publications/ | index | .xhtml           | ?utm_campaign= | seo            | #start                 |
    +==========+============+==========+=====+======+======================+====================+================+================+=======+==================+================+================+========================+
    | Protocol | Subdomain  | Domain   | TLD | Port | Site Language Prefix | Slug               | Enhanced Route                                             |                |                |                        |
    +----------+------------+----------+-----+------+----------------------+--------------------+-----------------------------------------+------------------+----------------+----------------+------------------------+
    |          | Hostname                    |      |                      |                    | Route Enhancer                          | Route Decorator  | Query string   | argument value | Location Hash / Anchor |
    +----------+-----------------------------+------+----------------------+--------------------+-----------------------------------------+------------------+----------------+----------------+------------------------+
    |                                               |  Route / Permalink                                                                                     |                                                          |
    +-----------------------------------------------+--------------------------------------------------------------------------------------------------------+----------------+----------------+------------------------+
    | URL (no arguments, unlike the URI)                                                                                                                     |                |                |                        |
    +--------------------------------------------------------------------------------------------------------------------------------------------------------+----------------+----------------+------------------------+
    | URI (everything)                                                                                                                                                                                                  |
    +-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

..  hint::

    Please note that the following terminology is based on technical terms used in the TYPO3 Core,
    due to their class/object and interface names.

..  index:: Routing; Route

Route
    The "speaking URL" as a whole (without the domain parts); for example
    `/en/about-us/our-team/john-doe/publications/index.xhtml`.
    This is also sometimes referred to as `permalink`, some definitions also
    include the `Query string` for this term.

..  index:: Routing; Site Language Prefix

Site Language Prefix
    A global site language prefix (e.g. "/dk" or "/en-us") is not considered
    part of the slug, but rather a "prefix" to the slug.

..  index:: Routing; Slug

Slug
    Unique name for a resource to use when creating URLs; for example the slug of the news detail page
    could be `/news/detail`, and
    the slug of a news record could be `2019-software-update`.

    Within TYPO3, a slug is always a part (section) of the URL "path" - it does not contain scheme, host, HTTP verb, etc.
    The URL "path" consists of one or more slugs which are concatenated into a single string.

    A slug is usually added to a TCA-based database table, containing rules for evaluation and definition.

    The default behaviour of a slug is as follows:

    *   A slug only contains characters which are allowed within URLs. Spaces,
        commas and other special characters are converted to a fallback character.
    *   A slug is always lower-cased.
    *   A slug is unicode-aware.
    *   Slugs must be separated by one or more character like "/", "-", "_"
        and "&". Regular characters like letters should not be used as
        separators for better readability.

..  note::

    A slug of a record may contain slashes but this is not recommended:
    The risk of conflicts is higher when using slashes within slugs. For
    example, unrelated page hierarchies and records could have slugs
    forming the same URL path.

..  index:: Routing; Enhancers


Enhancers
    Sections **after** a slug can be added ("enhancing" the route) both by "Route Enhancers" and also
    "(Route Enhancing) Decorators", see
    :ref:`Advanced routing configuration <t3coreapi:routing-advanced-routing-configuration>`.

..  index:: Routing; Page Type Suffix

Page Type Suffix
    A Page Type Suffix indicates the type of a URL, usually ".html". It can also be left out completely.
    If set, it could control alternate variants of a URL, for example a RSS feed or a JSON representation.

    A Page Type Suffix is treated as an Enhancer, specifically a "(Route) Decorator".
    Other kinds of decorators could add additional parts to the route, but
    only after(!) the initial "Route Enhancer(s)".

..  index:: Routing; Enhanced Route

Enhanced Route
    The combination of multiple Enhancers (and the Page Type Suffix) can be referred to as the "Enhanced Route".

..  index:: Routing; URI arguments; Query string

Query string
    The main distinction of `URL` (Uniform Resource Locator) and `URI` (Uniform Resource Identifier) is that
    the URI also includes arguments/parameters and their values, beginning with a `?` and each argument
    separated by `&`, and the value separated from the argument name by `=`. This is commonly referred to as
    "Query string".

..  index:: Routing; Location Hash
    The Location Hash is the part of a URI starting with `#`. Note that browsers requesting a resource
    never supply the hash to the Webserver, so any kind of Enhancer is not able to use this information
    to match any kind of routing. This can only be done by the Browser (for example via JavaScript),
    after the requested document has been rendered.

..  _routing-terminology-symfony:

Routing in TYPO3
================

Routing in TYPO3 is implemented based on the Symfony Routing components. It
consists of two parts:

*   `Page-based routing <https://docs.typo3.org/permalink/t3coreapi:routing-page-based-routing>`_
*   `Route Enhancements and Aspects <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration>`_

Page Routing describes the process of resolving the concrete page (in earlier
TYPO3 versions this were the `id` and `L` `$_GET` parameters,
now this uses the Site Language Prefix plus one or more slugs),
whereas Route Enhancements and Aspects take care of all additionally configured
parameters (such as beautifying plugin parameters, handling `type` etc.).

.. _routing-page-based-routing:

Page-based routing
------------------

TYPO3 provides built-in support for page-based routing, mapping pages to
routes automatically.

Page-based routing is always enabled in TYPO3 and requires a site
configuration (see :ref:`sitehandling`) for your website. Each page's route
is determined by its `slug` field, which can be viewed in the page
properties.

..  hint::
    Ensure that editors have the necessary permissions to modify the `slug`
    field if they need to change or update slugs when modifying page titles.

The generation of page slugs is controlled via the TCA configuration of the
`pages` table (`slug` field). This configuration can be customized in your
extension’s :file:`TCA/Overrides/pages.php`. Refer to the TCA reference
(:ref:`t3tca:columns-slug`) for available options.

If the system extension :composer:`typo3/cms-redirects` is installed,
redirects are automatically generated when a slug is adjusted by and editor.

..  _routing-tips:

Tips: Using imports in YAML files
=================================

As routing configuration (and site configuration in general) can get pretty long
fast, you should make use of imports in your YAML configuration which allows you
to add routing configurations from different files and different extensions.

Example:

..  code-block:: yaml
    :caption: config/sites/<site-identifier>/config.yaml

    imports:
        - { resource: "EXT:myblog/Configuration/Routes/Default.yaml" }
        - { resource: "EXT:mynews/Configuration/Routes/Default.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Default.yaml" }
