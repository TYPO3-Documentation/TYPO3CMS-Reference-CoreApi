:navigation-title: Page as JSON

..  include:: /Includes.rst.txt
..  index::
    pair: Headless; Page type
    pair: Headless; PAGEVIEW
..  _extbase-beyond-html-headless-page-json:

===============================
Delivering a TYPO3 page as JSON
===============================

A headless frontend that renders every page of a site needs each page in a
form it can read. This page sets up a page type that delivers any page of the
site as JSON, next to its regular HTML: the page title, the languages it is
available in, the menu, and the content elements of its content areas. It uses
TYPO3 Core only, and the same tools that render the HTML page: a
:typoscript:`PAGE` object, the :typoscript:`PAGEVIEW` content object, and
Fluid templates.

A request for :samp:`https://example.org/conferences/page.json` answers like
this:

..  literalinclude:: _snippets/_page.json
    :caption: Response for https://example.org/conferences/page.json

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-page-json-page-type:

Adding a JSON page type for every TYPO3 page
============================================

A second :typoscript:`PAGE` object with its own :typoscript:`typeNum` renders
the JSON. It sits next to the :typoscript:`PAGE` object of the regular HTML
page, in the site package's site set:

..  literalinclude:: _snippets/_setup.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

:typoscript:`config` turns the page into a plain JSON response:

*   :typoscript:`disableAllHeaderCode` leaves out the HTML document around the
    output.
*   :typoscript:`additionalHeaders` sends the content type
    `application/json`, see
    :ref:`additionalHeaders <t3tsref:confval-config-additionalheaders>`.
*   :typoscript:`forceAbsoluteUrls` makes every link and file URL TYPO3
    generates absolute, see
    :ref:`forceAbsoluteUrls <t3tsref:confval-config-forceabsoluteurls>`. The
    frontend runs on a different host than TYPO3, or on the same host under a
    different path, so it needs the full URL.
*   :typoscript:`admPanel` keeps the admin panel out of the output.

:ref:`PAGEVIEW <t3tsref:cobj-pageview>` renders the page with Fluid
templates. It takes its templates from :file:`Resources/Private/Json/`, a
folder of its own, so the JSON templates do not mix with the HTML templates
of the regular page. The two data processors add the
:ref:`menu <t3tsref:menuprocessor>` and the
:ref:`language menu <t3tsref:languagemenuprocessor>`.

Because the page type renders the page itself, everything TYPO3 does for a page
applies to the JSON as well: the page is resolved from its URL, its language
and access restrictions are respected, and its content is translated.


..  _extbase-beyond-html-headless-page-json-url:

Giving the TYPO3 page JSON its own URL suffix
=============================================

A `PageType decorator <https://docs.typo3.org/permalink/t3coreapi:routing-pagetype-decorator>`_
maps the page type to a suffix:

..  literalinclude:: _snippets/_route-enhancers.yaml
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/route-enhancers.yaml

Every page is now available as JSON under its own URL with :file:`page.json`
appended:

*   :samp:`https://example.org/conferences/page.json`
*   :samp:`https://example.org/de/konferenzen/page.json`
*   :samp:`https://example.org/page.json` for the root page

The frontend gets the JSON of a page by appending the suffix to the path of
the page URL.


..  _extbase-beyond-html-headless-page-json-fluid:

Writing JSON in a Fluid template
================================

Fluid escapes every value for HTML. In a JSON template that breaks the
output: a quote in a page title would become `&quot;`. Two things produce
valid JSON instead.

The first line of each template and each partial turns the escaping off:

..  code-block:: html
    :caption: First line of every JSON template and partial

    {escaping off}

The setting applies to the file that contains it, so a partial without it
escapes its values again, even when the template that renders it has turned
the escaping off.

The :ref:`f:format.json <t3viewhelper:typo3fluid-fluid-format-json>`
ViewHelper then encodes each value as JSON, with quotes around strings and
`null` for a missing value. It also encodes `<` and `>` as `\\u003C` and
`\\u003E`, which is still valid JSON. Use its tag syntax:

..  code-block:: html
    :caption: Encoding one value as JSON

    "title": <f:format.json value="{page.pageRecord.title}" />,

The inline syntax :html:`{page.pageRecord.title -> f:format.json()}` does not
work inside the braces of a JSON object: Fluid takes the braces of the object
for its own syntax and leaves the expression unparsed. This happens when the
text between two tags contains both braces of the object, even for a plain
variable such as :html:`{page.id}`. The menu partials below use the inline
syntax of :html:`f:if` inside a JSON object. It works there, because the tags
of :html:`f:format.json` split the object into separate parts.

Instead of turning the escaping off, a template can wrap every encoded value
in the :ref:`f:format.raw <t3viewhelper:typo3fluid-fluid-format-raw>`
ViewHelper:

..  code-block:: html
    :caption: Encoding one value as JSON with escaping turned on

    "title": <f:format.raw><f:format.json value="{page.pageRecord.title}" /></f:format.raw>,

This produces the same JSON, at the cost of a longer line for every value. The
Fluid documentation describes how escaping works in
`Escaping in Fluid <https://docs.typo3.org/permalink/fluid:escaping-syntax>`_.

:html:`f:format.json` encodes arrays and scalar values. An object without a
JSON representation, such as the locale of a language, becomes an empty
object `{}`. Pass the scalar value you need, for example the
:html:`hreflang` of the language rather than the language itself.

A list needs a comma between its entries but not after the last one. The
iteration variable of :html:`f:for` tells the loop when it has reached the last
entry, as the partials below show.


..  _extbase-beyond-html-headless-page-json-template:

The JSON template of a TYPO3 page
=================================

:typoscript:`PAGEVIEW` hands the template the page, its site, its language,
and its content areas. The template writes the values the frontend needs and
leaves the lists to partials:

..  literalinclude:: _snippets/_Default.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Pages/Default.fluid.html

:typoscript:`PAGEVIEW` chooses the template by the
`page layout <https://docs.typo3.org/permalink/t3coreapi:be-layout>`_ of the
page: a page with the layout `Default` is rendered with
:file:`Pages/Default.fluid.html`. The JSON folder needs a template for each page
layout the site uses, just as the HTML folder does. Keep what the layouts have
in common in partials, so that each layout template only adds its content
areas.

:typoscript:`PAGEVIEW` always looks for templates with the extension
:file:`.fluid.html`, so the JSON templates carry that extension as well.

The template sends the :html:`hreflang` of the language. It is the value the
frontend needs for the `lang` attribute of its HTML, and TYPO3 falls back to
the locale of the language when the site configuration does not set it.


..  _extbase-beyond-html-headless-page-json-menus:

Delivering the TYPO3 menu and language menu as JSON
===================================================

The menu partial writes one entry per page and renders itself again for the
subpages. :typoscript:`levels = 2` in the TypoScript configuration limits the
menu to two levels:

..  literalinclude:: _snippets/_Menu.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/Menu.fluid.html

`active` marks the pages on the path to the current page, `current` the
current page itself. The frontend uses them to highlight the menu entries.

The language menu lists every language of the site, with the URL of the
current page in that language:

..  literalinclude:: _snippets/_LanguageMenu.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/LanguageMenu.fluid.html

A language in which the page is not translated is marked as not `available`,
and its `link` is empty. The frontend can then hide it or link the start page
of that language instead.

Both partials pass on only the values of each entry the frontend uses. The
processors offer more, for example the full page record of a menu entry in
:html:`item.data`.


..  _extbase-beyond-html-headless-page-json-content:

Delivering the content areas of a TYPO3 page as JSON
====================================================

:typoscript:`PAGEVIEW` provides the content areas of the page layout in the
variable :html:`content`, each under the identifier the page layout gives it.
:html:`{content.main.records}` holds the content elements of the area `main`,
as record objects. The template writes each content area of the layout under
its identifier, so the frontend knows where to place its elements:

..  literalinclude:: _snippets/_ContentArea.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentArea.fluid.html

This partial writes only the uid, the content type, and the header of each
content element. :ref:`Delivering content elements as JSON
<extbase-beyond-html-headless-content-elements>` adds the fields of each
content type.

The ViewHelpers :html:`f:render.contentArea` and :html:`f:render.record`, which
render content areas in an HTML page, do not help here. They render each
content element with its TypoScript rendering definition, which produces HTML.


..  _extbase-beyond-html-headless-page-json-caching:

Caching the JSON of a TYPO3 page
================================

The JSON page type is cached like any other page. TYPO3 stores it in the page
cache separately from the HTML of the same page, for each language and each
combination of frontend user groups. Clearing the cache of a page clears both.

A URL that does not resolve to a page is answered with the error handling of
the site, which delivers an HTML error page by default.
:ref:`Connecting a headless frontend to TYPO3
<extbase-beyond-html-headless-frontend>` covers what the frontend does with
such responses.


..  _extbase-beyond-html-headless-page-json-next:

Next steps after delivering a TYPO3 page as JSON
================================================

The page now delivers its structure, but its content elements carry only a
header. :ref:`Delivering content elements as JSON
<extbase-beyond-html-headless-content-elements>` writes the fields of each
content type: text, rich text with links, images, and relations.
