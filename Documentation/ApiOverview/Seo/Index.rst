.. include:: ../../Includes.txt

.. _seo:

===
SEO
===

TYPO3 contains various SEO related functionality out of the box. The following provides an introduction in those features.

Hreflang Tags
=============
 "hreflang" tags are now added automatically for multilanguage websites based on the one-tree principle.

The href is relative as long as the domain is the same. If the domain differs the href becomes absolute. 
The x-default href is the first supported language. The value of "hreflang" is the one set in the sites module
(see :ref:`sitehandling-addingLanguages`)

Canonical Tags
==============

TYPO3 provides built-in support for the :html:`<link rel="canonical" href="">` tag.

If the core extension "seo" is installed, it will automatically add the canonical link to the page.

The canonical link is basically the same absolute link as the link to the current hreflang and is meant
to indicate where the original source of the content is. It is a tool to prevent duplicate content
penalties.

In the page properties, the canonical link can be overwritten per language. The link wizard offers all
possibilities including external links and link handler configurations.

Should an empty href occur when generating the link to overwrite the canonical (this happens e.g. if the
selected page is not available in the current language), the fallback to the current hreflang will be activated
automatically. This ensures that there is no empty canonical.


.. warning::
    If you have other SEO extensions installed that generate canonical links, you have to make sure only one creates it.
    If both core and an extension are generating a canonical link, it will
    result in 2 canonical links which might cause confusion for search engines.

XML Sitemap 
===========

see :ref:`xmlsitemap` 


SEO for Developers
==================

TYPO3 provides various APIs for developers to implement further SEO features:

- The MetaTagApi (see :ref:`metatagapi`) to add dynamic meta tags 
- The PageTitleAPI (see :ref:`pagetitle`) to manipulate the page title
