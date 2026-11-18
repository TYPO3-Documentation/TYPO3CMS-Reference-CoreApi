:navigation-title: Content elements as JSON

..  include:: /Includes.rst.txt
..  index::
    pair: Headless; Content elements
    pair: Headless; Record objects
..  _extbase-beyond-html-headless-content-elements:

===================================
Delivering content elements as JSON
===================================

The JSON page type from :ref:`Delivering a TYPO3 page as JSON
<extbase-beyond-html-headless-page-json>` writes only the uid, the type, and
the header of each content element. A frontend needs the content as well: the
text, the images, the links. This page adds the fields of each content type.

:typoscript:`PAGEVIEW` provides the content elements as
`record objects <https://docs.typo3.org/permalink/t3coreapi:record-objects>`_.
A record object resolves each field according to its TCA configuration: a
file field returns file references, a link field a link, a relation the
related records. The JSON templates turn these values into URLs and text.

With the fields added, the content area of a page looks like this:

..  literalinclude:: _snippets/_content-elements.json
    :caption: Content area in the response of https://example.org/conferences/page.json (excerpt)

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-headless-content-elements-partial:

One Fluid partial for every TYPO3 content element
=================================================

The content area partial no longer writes the fields itself. It renders a
partial for each content element:

..  literalinclude:: _snippets/_ContentAreaElements.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentArea.fluid.html

The partial writes the fields every content element has, and the fields of
its content type under `data`:

..  literalinclude:: _snippets/_ContentElement.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentElement.fluid.html
    :visible-lines: 1-8

The fields of each content type come from a section of the same partial,
named after the content type, such as `textmedia`. :html:`optional="1"` and
:html:`default="null"` make the section optional: a content type without a
section is written with `"data": null`. The JSON stays valid when an editor
uses a content type the templates do not know yet, and the frontend can skip
the element.


..  _extbase-beyond-html-headless-content-elements-text:

Delivering text and rich text of a TYPO3 content element
========================================================

A text field such as the header is written as it is.
:html:`f:format.json` encodes it as a JSON string, and the frontend receives
exactly the text the editor entered, including characters such as `<` and
`&`. Escaping it for the HTML of the frontend is the frontend's job, as it is
for any data from an API.

A rich text field such as `bodytext` holds HTML, but not in the form the
frontend can use. Its links are stored as references, such as
`t3://page?uid=12`. The :ref:`f:format.html
<t3viewhelper:typo3-fluid-format-html>` ViewHelper processes the field the way
the HTML page does, with the TypoScript :ref:`parseFunc <t3tsref:parsefunc>`
`lib.parseFunc_RTE`:

..  literalinclude:: _snippets/_ContentElement.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentElement.fluid.html
    :visible-lines: 10-14

The link references become URLs, absolute because the page type sets
:typoscript:`forceAbsoluteUrls`. The HTML is also sanitized: elements and
attributes that could run scripts, such as :html:`<script>` or
:html:`onerror`, are escaped or removed. The frontend receives HTML that it can
insert into its page as HTML.


..  _extbase-beyond-html-headless-content-elements-links:

Delivering links of a TYPO3 content element
===========================================

A field of TCA type `link`, such as `header_link`, returns a link object
rather than the stored value. The :ref:`f:uri.typolink
<t3viewhelper:typo3-fluid-uri-typolink>` ViewHelper turns it into a URL, as
the common part of the partial does for the header link. A field without a link
results in an empty string.


..  _extbase-beyond-html-headless-content-elements-images:

Delivering images of a TYPO3 content element
============================================

A field of TCA type `file`, such as `assets` of the content type `textmedia`,
returns a collection of file references. The section writes one entry per
file:

..  literalinclude:: _snippets/_ContentElement.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentElement.fluid.html
    :visible-lines: 16-29

The :ref:`f:uri.image <t3viewhelper:typo3-fluid-uri-image>` ViewHelper
scales the image and returns the URL of the processed file. The frontend does
not have to load the original, which can be much larger. A frontend that needs
several sizes, for example for the `srcset` of an image, could receive one URL
per size. :html:`{asset.publicUrl}` is the URL of the original file, for files
that are not processed, such as a video.

The alternative text and the other properties of the file reference are
written like any other text.


..  _extbase-beyond-html-headless-content-elements-relations:

Delivering related records of a TYPO3 content element
=====================================================

A relation field returns the related records as record objects as well. The
content type `shortcut` shows other content elements, selected in its field
`records`. Its section renders the content element partial again for each of
them:

..  literalinclude:: _snippets/_ContentElement.fluid.html
    :caption: EXT:my_sitepackage/Resources/Private/Json/Partials/ContentElement.fluid.html
    :visible-lines: 31-39

The referenced content elements appear in the JSON with all their fields,
under `records` of the shortcut. Record objects load their relations only when
a template accesses them, so a section pays for the relations it writes and for
no others.

Which value a field returns depends on its TCA type and on its
:php:`relationship`, see
`Resolved values of record objects <https://docs.typo3.org/permalink/t3coreapi:record-objects-resolved-values>`_.
A relation to one record returns that record directly instead of a collection.


..  _extbase-beyond-html-headless-content-elements-own-types:

Delivering content types of your own as JSON
============================================

A content type of the site package or of an extension is delivered the same
way: add a section named after its type to the partial, and write its fields.
Record objects resolve the fields of a content type of your own from its TCA,
just as they resolve the fields of the content types of TYPO3 Core.

Plugins are the exception. Their content element holds only the plugin's
configuration, and the output comes from the plugin itself, which renders HTML
by default.


..  _extbase-beyond-html-headless-content-elements-next:

Next steps after delivering content elements as JSON
====================================================

:ref:`Delivering Extbase plugins in a headless page
<extbase-beyond-html-headless-extbase-plugins>` renders the plugins on a
page, with the settings the editor chose in their content elements, as JSON
within the JSON of the page.
