:navigation-title: Extbase plugins as JSON

..  include:: /Includes.rst.txt
..  index::
    pair: Headless; Extbase plugin
    pair: Extbase; JSON
..  _extbase-beyond-html-headless-extbase-plugins:

=============================================
Delivering Extbase plugins in a headless page
=============================================

A plugin is the one kind of content element whose fields do not describe its
output. Its content element holds only the configuration an editor chose,
such as a selection or a storage folder. The output comes from the plugin
itself, and an Extbase plugin renders HTML by default.

In the JSON page type from :ref:`Delivering a TYPO3 page as JSON
<extbase-beyond-html-headless-page-json>`, the plugin has to deliver JSON
instead, which the page template inserts as the `data` of its content
element. This page shows how the plugin is rendered for its content element,
how its action answers with JSON, and what changes when the action is not
cacheable.

A conference list plugin in the content area of a page delivers this:

..  literalinclude:: _snippets/_plugin.json
    :caption: Content area in the response of https://example.org/conferences/page.json (excerpt)

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-extbase-plugins-render:

Rendering an Extbase plugin for its content element in JSON
===========================================================

The content element partial from :ref:`Delivering content elements as JSON
<extbase-beyond-html-headless-content-elements>` gets a section for the
plugin's content type. The section renders the plugin with the
:ref:`f:cObject <t3viewhelper:typo3-fluid-cobject>` ViewHelper:

..  literalinclude:: _snippets/_ContentElementPlugin.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentElement.fluid.html (excerpt)

:php:`ExtensionUtility::configurePlugin()` registers the TypoScript
:typoscript:`tt_content.myextension_conferencelist` for the plugin's content
type. It renders the content element with its frame HTML, and the plugin
itself in :typoscript:`20`. The section renders only :typoscript:`20`, so
the output is the plugin's and nothing else.

:html:`data="{record}"` and :html:`table="tt_content"` render the plugin for
the content element at hand. The plugin reads its configuration from that
record just as it does in the HTML page: the settings the editor chose in its
FlexForm, and its storage folder from the field :guilabel:`Record Storage Page`.
One plugin can therefore deliver different selections on different pages,
without a line of configuration in the page type.

The section writes the output of the plugin as it is, without
:html:`f:format.json`. The plugin delivers JSON already, and encoding it again
would turn it into a string.


..  _extbase-beyond-html-headless-extbase-plugins-format:

Letting an Extbase plugin answer with JSON templates
====================================================

The conference list plugin also renders the conference list of HTML pages, and
an editor places it the same way on every page. The plugin needs the same
actions for both: :php:`listAction()` and :php:`showAction()`, configured as
usual:

..  literalinclude:: _snippets/_ext_localconf.php
    :caption: EXT:my_extension/ext_localconf.php

What differs is the representation. In the JSON page type, the plugin renders
its actions with JSON templates instead of HTML templates. A TypoScript
condition sets the :confval:`format <extbase-configuration-typoscript-format>`
of the plugin to `json` for that page type only:

..  literalinclude:: _snippets/_setup_format.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

With the format `json`, Fluid looks for the template
:file:`Conference/List.fluid.json` instead of :file:`Conference/List.fluid.html`.
The controller stays as it is. The JSON templates follow the same rules as
the templates of the page, see :ref:`Writing JSON in a Fluid template
<extbase-beyond-html-headless-page-json-fluid>`:

..  literalinclude:: _snippets/_List.fluid.json
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.json

..  literalinclude:: _snippets/_Show.fluid.json
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.json

The format applies to the plugin only within the condition, so the HTML pages
keep rendering the HTML templates.

The same approach delivers a plugin of another extension as JSON. Its JSON
templates go into a template path of the site package, added with a higher
key than the paths of the extension, see
:ref:`Overriding templates of a third-party extension
<extbase-view-third-party-override>`. The extension itself does not need to
change.

The action may still return :php:`htmlResponse()`. Its content type does not
reach the visitor, because the :typoscript:`additionalHeaders` of the JSON
page type are applied last and set `application/json`.


..  _extbase-beyond-html-headless-extbase-plugins-jsonview:

Letting an Extbase plugin answer with JsonView
==============================================

A plugin that exists only for the headless frontend can render its data with
:ref:`JsonView <extbase-beyond-html-jsonview>` instead of templates. The action
shapes the data as an array and returns :php:`jsonResponse()`, as the
`seats example <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-ajax-action>`_
does. The output is inserted into the page JSON in the same way.

Such a plugin sets the content type `application/json` itself. On an HTML
page, that content type applies to the whole page, see
:ref:`An action returning JSON breaks the page
<extbase-appendix-pitfalls-json-on-html-page>`. Use JsonView for plugins that
are rendered in the JSON page type only, and JSON templates for plugins that
appear on HTML pages as well.


..  _extbase-beyond-html-headless-extbase-plugins-caching:

Cacheable and non-cacheable Extbase plugins in a JSON page
==========================================================

The output of a cacheable action is stored in the page cache together with the
rest of the page JSON. A request for the same page receives it from the
cache, without running the action.

A non-cacheable action is rendered as a
:ref:`USER_INT object <extbase-caching-noncacheable-userint>`. TYPO3 caches
the page JSON with a placeholder where the plugin output belongs, and replaces
the placeholder on every request with the output of the action. This works in
the JSON page because the section writes the plugin output as it is. Passed
through :html:`f:format.json`, the placeholder would be encoded as a string,
TYPO3 would no longer find it, and the JSON would contain the placeholder
instead of the plugin output.

A page with a non-cacheable plugin is sent with the header
`Cache-Control: private, no-store`, so neither the browser nor a proxy keeps a
copy of the page JSON. Values that change on every request, such as the seats
left in a conference, can therefore be cheaper to deliver from an endpoint of
their own, which the frontend requests separately. :ref:`Loading Extbase data
with fetch() <extbase-beyond-html-ajax>` builds such an endpoint.


..  _extbase-beyond-html-headless-extbase-plugins-links:

Links and detail pages of Extbase plugins in a JSON page
========================================================

The links an Extbase plugin creates, with :html:`f:uri.action` or the
:php:`UriBuilder`, point to the page as HTML, not to the JSON page type. The
JSON page type sets :typoscript:`forceAbsoluteUrls`, so they are absolute.

For the frontend, these are the URLs of its own pages. It shows the URL
:samp:`https://example.org/conferences/conference/12` with its own host, and
requests the JSON of that page by appending the suffix:
:samp:`https://example.org/conferences/conference/12/page.json`. The PageType
decorator and the
`route enhancer of the plugin <https://docs.typo3.org/permalink/t3coreapi:extbase-routing>`_
work together, so TYPO3 resolves the page, the plugin runs
:php:`showAction()` for conference 12, and the page JSON contains its output.


..  _extbase-beyond-html-headless-extbase-plugins-next:

Next steps after delivering Extbase plugins as JSON
===================================================

The page type now delivers complete pages, including the output of their
plugins. :ref:`Connecting a headless frontend to TYPO3
<extbase-beyond-html-headless-frontend>` describes what the frontend has to
take care of when it requests them: mapping URLs, requests from the browser
of another origin, frontend users, caching, and previews for editors.
