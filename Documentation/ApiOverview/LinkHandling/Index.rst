.. include:: /Includes.rst.txt
.. index:: Links
.. _LinkHandling:

=============
Link handling
=============

Links entered in the backend in TYPO3 are stored in an internal format in the
database.

..  include:: /Images/ManualScreenshots/Backend/BackendLinkFormats.txt

For example, a link to the page with uid 42 is stored in a backend field as
`t3://page?uid=42` and in the rich-text editor (RTE) as
:html:`<a href="t3://page?uid=1">test</a>`.

..  todo:
    Make a chapter that describes the extended formats containing titles,
    targets, link classes, etc

Such links must be converted before they are output as HTML in the frontend.
For example, in :ref:`Fluid <fluid>` all input from the RTE should be output by the ViewHelper
:ref:`t3viewhelper:typo3-fluid-format-html`:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.html

    <f:format.html>{myContent.bodytext}</f:format.html>

Links provided in backend fields like the :sql:`header_link` can be used as
input in the ViewHelper :ref:`t3viewhelper:typo3-fluid-link-typolink`:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.html

    <f:link.typolink parameter="{myContent.header_link}">
      {myContent.header_link}
    </f:link.typolink>

In TypoScript, RTE content can be converted by the function :ref:`t3tsref:parsefunc`,
link fields can be converted into HTML by the function :ref:`t3tsref:typolink`.

In PHP context links are usually stored in an array format. Each link type is
handled by a :ref:`core-link-handler` which maps between different formats.

..  todo: Add chapter about converting and outputting links in PHP

The :ref:`link browser <linkbrowser-api>` is the modal in which users can configure
links in both the :ref:`rte` and the :ref:`FormEngine`. The link browser offers
tabs for the different types of links like email, page, external, file, news
record and possibly more. Each tab of the link browser has an associated
:ref:`backend link handler <linkhandler>` that renders the tab and handles
editing links. The link browser can be extended by
:ref:`custom links to different record types <TableRecordLinkBrowserTutorials>`
and :ref:`custom link handler implementations <tutorial-github-link-handler>`.

..  include:: /Images/ManualScreenshots/Backend/HaikuLinkBrowser.rst.txt

**Contents:**

..  rst-class:: compact-list
..  toctree::
    :titlesonly:

    Configuration
    LinkBrowserApi/Index
    Linkhandler/Index
    CoreLinkHandler
    Tutorials/Index
