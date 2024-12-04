..  include:: /Includes.rst.txt
..  index:: XML sitemap
..  _xmlsitemap:

===========
XML sitemap
===========

It is possible to generate XML sitemaps for SEO purposes without using 3rd party
plugins. When this feature is enabled, a sitemap index file is created with one
or more sitemaps in it. By default, there will be one sitemap that contains all
pages of the current site and language.  You can render different sitemaps
for each site and language.

.. note::
   The XML sitemap is provided by the optional system extension
   EXT:seo. You can find information about how to install and use it in the
   :doc:`EXT:seo manual <ext_seo:Index>`.

.. contents:: Table of Contents
   :depth: 1
   :local:

Installation
============

XML sitemaps are part of the "seo" system extension. If the extension is not
available in your installation, require it as described here: :ref:`Installation, EXT:seo <ext_seo:installation>`
Then include the static TypoScript template `XML Sitemap (seo)`.

How to access your XML sitemap
==============================

You can access the sitemaps by visiting :samp:`https://example.org/?type=1533906435`.
You will first see the sitemap index. By default, there is one sitemap in the
index. This is the sitemap for pages.

..  note::
    Each siteroot and language configured in the
    :ref:`site handling <sitehandling>` has its own XML sitemap depending on the
    entry point.

    **Example:**

    -   Entry point `/` - :samp:`https://example.org/?type=1533906435`: for default language
    -   Entry point `/fr/` - :samp:`https://example.org/fr/?type=1533906435`: for French
    -   Entry point `/it/` - :samp:`https://example.org/it/?type=1533906435`: for Italian

How to setup routing for the XML sitemap
========================================

You can use the :ref:`PageType decorator <routing-pagetype-decorator>` to map
the page type to a fixed suffix. This allows you to expose the sitemap with a
readable URL, for example :samp:`https://example.org/sitemap.xml`.

Additionally, you can map the parameter `sitemap`, so that the links to the different
sitemap types (`pages` and additional ones, for example, from the news extension) are also mapped.

..  code-block:: yaml
    :caption: config/sites/<your_site>/config.yaml

    routeEnhancers:
      PageTypeSuffix:
        type: PageType
        map:
          /: 0
          sitemap.xml: 1533906435
      Sitemap:
        type: Simple
        routePath: 'sitemap-type/{sitemap}'
        aspects:
          sitemap:
            type: StaticValueMapper
            map:
              pages: pages
              tx_news: tx_news
              my_other_sitemap: my_other_sitemap

.. index:: XmlSitemapDataProviders

XmlSitemapDataProviders
=======================

The rendering of sitemaps is based on `XmlSitemapDataProviders`. EXT:seo ships
with two `XmlSitemapDataProviders`.

For pages
---------

The :php:`\TYPO3\CMS\Seo\XmlSitemap\PagesXmlSitemapDataProvider` will generate a
sitemap of pages based on the detected siteroot. You can configure whether you
have additional conditions for selecting the pages. It is also possible to
exclude certain :ref:`doktypes <list-of-page-types>`. Additionally, you may
exclude page subtrees from the sitemap (e.g internal pages). This can be
configured using TypoScript (example below) or using the :ref:`constants editor <t3tsref:typoscript-syntax-constant-editor>` in the
backend.

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    plugin.tx_seo {
        config {
            xmlSitemap {
                sitemaps {
                    pages {
                        config {
                            excludedDoktypes = 3, 4, 6, 7, 199, 254, 255, 137, 138
                            additionalWhere = AND ({#no_index} = 0 OR {#no_follow} = 0)
                            #rootPage = <optionally specify a different root page. (default: rootPageId from site configuration)>
                            excludePagesRecursive = <comma-separated list of page IDs>
                        }
                    }
                }
            }
        }
    }

.. note::
   The doktypes 137 and 138 in the example above are custom doktypes.
   The other doktypes given are the ones excluded by default by the SEO extension.

For records
-----------

If you have an extension installed and want a sitemap of those records, the
:php:`\TYPO3\CMS\Seo\XmlSitemap\RecordsXmlSitemapDataProvider` can be used. The
following example shows how to add a sitemap for news records:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    plugin.tx_seo {
        config {
            <sitemapType> {
                sitemaps {
                    <unique key> {
                        provider = TYPO3\CMS\Seo\XmlSitemap\RecordsXmlSitemapDataProvider
                        config {
                            table = news_table
                            sortField = sorting
                            lastModifiedField = tstamp
                            changeFreqField = news_changefreq
                            priorityField = news_priority
                            additionalWhere = AND ({#no_index} = 0 OR {#no_follow} = 0)
                            pid = <page id('s) containing news records>
                            recursive = <number of subpage levels taken into account beyond the pid page. (default: 0)>
                            url {
                                pageId = <your detail page id>
                                fieldToParameterMap {
                                    uid = tx_extension_pi1[news]
                                }
                                additionalGetParameters {
                                    tx_extension_pi1.controller = News
                                    tx_extension_pi1.action = detail
                                }
                            }
                        }
                    }
                }
            }
        }
    }

You can add multiple sitemaps and they will be added to the sitemap index
automatically. Use different types to have multiple, independent sitemaps:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    seo_googlenews < seo_sitemap
    seo_googlenews.typeNum = 1571859552
    seo_googlenews.10.sitemapType = googleNewsSitemap

    plugin.tx_seo {
        config {
            xmlSitemap {
                sitemaps {
                    news {
                        provider = GeorgRinger\News\Seo\NewsXmlSitemapDataProvider
                        config {
                            # ...
                        }
                    }
                }
            }
            googleNewsSitemap {
                sitemaps {
                    news {
                        provider = GeorgRinger\News\Seo\NewsXmlSitemapDataProvider
                        config {
                            googleNews = 1
                            # ...
                            template = GoogleNewsXmlSitemap.xml
                        }
                    }
                }
            }
        }
    }

..  _xmlsitemap-changefreq-priority:

Change frequency and priority
=============================

Change frequencies define how often each page is approximately updated and hence
how often it should be revisited (for example: News in an archive are "never"
updated, while your home page might get "weekly" updates).

Priority allows you to define how important the page is compared to other pages
on your site. The priority is stated in a value from 0 to 1. Your most important
pages can get an higher priority as other pages. This value does not affect how
important your pages are compared to pages of other websites. All pages and
records get a priority of 0.5 by default.

The settings can be defined in the TypoScript configuration of an XML sitemap by
mapping the properties to fields of the record by using the options
:typoscript:`changeFreqField` and :typoscript:`priorityField`.
:typoscript:`changeFreqField` needs to point to a field containing string values
(see :typoscript:`pages` TCA definition of field
:typoscript:`sitemap_changefreq`), :typoscript:`priorityField` needs to point to
a field with a decimal value between 0 and 1.

..  note::
    Both the priority and the change frequency have no impact on your rankings.
    These options only give hints to search engines in which order and how often
    you would like a crawler to visit your pages.

Sitemap of records without sorting field
========================================

Sitemaps are paginated by default. To ensure that as few pages of the sitemap
as possible are changed after the number of records is changed, the items in the
sitemaps are ordered. By default, this is done using a sorting field. If you do
not have such a field, make sure to configure this in your sitemap configuration
and use a different field. An example you can use for sorting based on the uid
field:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    plugin.tx_seo {
        config {
            <sitemapType> {
                sitemaps {
                    <unique key> {
                        config {
                            sortField = uid
                        }
                    }
                }
            }
        }
    }

Create your own XmlSitemapDataProvider
======================================

If you need more logic in your sitemap, you can also write your own
`XmlSitemapProvider`. You can do this by extending the
:php:`\TYPO3\CMS\Seo\XmlSitemap\AbstractXmlSitemapDataProvider` class. The main
methods are :php:`getLastModified()` and :php:`getItems()`.

The :php:`getLastModified()` method is used in the sitemap index and has to
return the date of the last modified item in the sitemap.

The :php:`getItems()` method has to return an array with the items for the
sitemap:

..  code-block:: php
    :caption: EXT:my_extension/Classes/XmlSitemap/MyXmlSitemapProvider

    $this->items[] = [
        'loc' => 'https://example.org/page1.html',
        'lastMod' => '1536003609'
    ];

The :php:`loc` element is the URL of the page to be crawled by a search engine.
The :php:`lastMod` element contains the date of the last update of the
specific item. This value is a UNIX timestamp. In addition, you can include
:php:`changefreq` and :php:`priority` as keys in the array to give
:ref:`search engines a hint <xmlsitemap-changefreq-priority>`.


.. _sitemap-xslFile:

Use a customized sitemap XSL file
=================================

The XSL file used to create a layout for an XML sitemap can be configured at
three levels:

#.  For all sitemaps:

    .. code-block:: typoscript
        :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

        plugin.tx_seo.config.xslFile = EXT:my_extension/Resources/Public/CSS/mySite.xsl

#.  For all sitemaps of a certain sitemapType:

    .. code-block:: typoscript
        :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

        plugin.tx_seo.config.<sitemapType>.sitemaps.xslFile = EXT:my_extension/Resources/Public/CSS/mySitemapType.xsl

#.  For a specific sitemap:

    .. code-block:: typoscript
        :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

        plugin.tx_seo.config.<sitemapType>.sitemaps.<sitemap>.config.xslFile = EXT:my_extension/Resources/Public/CSS/mySpecificSitemap.xsl


The value is inherited until it is overwritten.

If no value is specified at all, :file:`EXT:seo/Resources/Public/CSS/Sitemap.xsl`
is used as default.
