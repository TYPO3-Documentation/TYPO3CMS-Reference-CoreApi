:navigation-title: Headless extensions

..  include:: /Includes.rst.txt
..  index::
    pair: Headless; Extensions
..  _extbase-beyond-html-headless-extensions:

====================================
Using a headless extension for TYPO3
====================================

Community extensions deliver TYPO3 as JSON with ready-made configuration. The
most widespread one is :composer:`friendsoftypo3/headless`. It follows the same
model as this chapter: every page is delivered as JSON, with its menus, its
content areas, and the output of its plugins. It solves the same tasks with
parts of its own, and a frontend built for it expects the JSON structure it
produces.

This page maps the concepts of :composer:`friendsoftypo3/headless` to the
parts this chapter builds with TYPO3 Core, so that its documentation and the
code of existing projects are easier to read. For the release status of the
extensions, see the
`note on the chapter overview <https://docs.typo3.org/permalink/t3coreapi:extbase-beyond-html-headless-extensions-status>`_.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-extensions-page:

How EXT:headless delivers a TYPO3 page as JSON
==============================================

The extension is activated per site, with its site set and a setting in the
site configuration. It then replaces the HTML of the site with JSON at the
same URLs, instead of adding a page type next to it.

The JSON is described in TypoScript, not in Fluid templates. A content object
of the extension, :typoscript:`JSON`, collects the output of its fields into a
JSON object. The extension ships such definitions for the page and for the
content types of TYPO3 Core, and a content type of your own gets a definition
of the same kind. In this chapter, the JSON template of the page and the
partial of the content elements do this job, see
:ref:`Delivering content elements as JSON
<extbase-beyond-html-headless-content-elements>`.

The extension can also deliver the same URL as HTML or as JSON, depending on
the `Accept` header of the request. This chapter uses a separate page type
with a URL suffix instead. The details of that mode have changed between
versions of the extension, see
`its documentation on the mixed mode <https://docs.typo3.org/p/friendsoftypo3/headless/main/en-us/Configuration/Index.html#configuration-mixed-accept>`_.


..  _extbase-beyond-html-headless-extensions-plugins:

Extbase plugins with EXT:headless
=================================

An Extbase plugin of your own returns JSON from its action, and its content
element renders the plugin in a field of the :typoscript:`JSON` content object,
see
`Internal Extbase plugins <https://docs.typo3.org/p/friendsoftypo3/headless/main/en-us/Developer/CustomContent.html#developer-plugin-internal>`_.
The content object writes the output of each field as a string, and decodes a
string that is valid JSON, so the output of the plugin is nested as JSON
rather than as a string. In this chapter, the template writes the output of
the plugin as it is, see :ref:`Rendering an Extbase plugin for its content
element in JSON <extbase-beyond-html-headless-extbase-plugins-render>`.

A plugin of another extension gets JSON templates in a template path of the
site package, as in :ref:`Letting an Extbase plugin answer with JSON templates
<extbase-beyond-html-headless-extbase-plugins-format>`. The extension
:composer:`friendsoftypo3/headless_news` ships such templates for the news
extension.

A non-cacheable plugin needs special handling in the extension. Because the
:typoscript:`JSON` content object encodes the output of its fields, it would
encode the placeholder TYPO3 puts where a non-cacheable plugin belongs as well,
and TYPO3 would no longer find it. The extension therefore wraps the plugin in
markers of its own and replaces them in a middleware. In this chapter, the
template writes the placeholder as it is and TYPO3 replaces it, see
:ref:`Cacheable and non-cacheable Extbase plugins in a JSON page
<extbase-beyond-html-headless-extbase-plugins-caching>`.


..  _extbase-beyond-html-headless-extensions-check:

What to check before relying on a headless extension for TYPO3
==============================================================

A headless extension saves the work this chapter describes, and its frontend
libraries save work in the frontend as well. In return, the site depends on it
for as long as the frontend expects its JSON structure. Before you rely on one,
check:

*   Which TYPO3 versions it supports, with a stable release, and how soon after
    a new TYPO3 major version it supported that one in the past.
*   Which content types and plugins it covers. A plugin of another extension
    needs JSON templates, from that extension, from a companion extension, or
    from your site package, for each TYPO3 version you use.
*   Whether its JSON structure suits your frontend, and how it changed between
    its major versions. A change in the structure means a change in the
    frontend.
*   Which frontend it is made for. Some headless extensions come with a library
    for a particular frontend framework.

The Core way of this chapter needs more work at the start, but the JSON
structure is your own and changes only when you change it.


..  _extbase-beyond-html-headless-extensions-next:

Next steps after comparing headless extensions for TYPO3
========================================================

:ref:`Delivering TYPO3 content headless as JSON
<extbase-beyond-html-headless>` lists the pages of this chapter. If only some
data should reach the frontend, :ref:`Ways to deliver non-HTML output from
TYPO3 <extbase-beyond-html-options>` compares the endpoints that deliver it.
