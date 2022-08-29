.. include:: /Includes.rst.txt
.. index:: XML sitemap
.. _xmlsitemap:

===========
XML sitemap
===========

.. versionadded:: 9.4

   XML Sitemap support was added to the Core with change :doc:`ext_core:Changelog/9.4/Feature-84525-XMLSitemap`.

It is possible to generate XML sitemaps for SEO purposes without using 3rd-party plugins.
When enabled, this new feature will create a sitemapindex with one or more sitemaps in it.
Out-of-the-box it will have one sitemap containing all the pages of the current site and
language. Per site and per language you have the possibility to render a different sitemap.

.. note::
   The XML sitemap is provided by the optional system extension
   EXT:seo. You can find information about how to install and use it in the
   :doc:`EXT:seo manual <ext_seo:Index>`.

Installation
============

The XML sitemap is disabled by default. You can easily enable it by installing the system
extension "seo" and including the static TypoScript template XML Sitemap (seo). It is also
mandatory to have a site configuration for your rootpage(s).

How to access your XML sitemap
==============================

You can access the sitemaps by going to :samp:`https://example.org/?type=1533906435`. You will
first see the sitemap index. By default you will see one sitemap in the index. This is the
sitemap for pages.

If you have multiple siteroots or multiple languages with different domains or language prefixes,
you can just go to the domain that handles the siteroot / language. The sitemap will be based on
the settings for that domain.

How to setup routing for the XML sitemap
========================================

You can use the PageType decorator to map the page type to a fixed suffix. This allows you to expose the sitemap with a readable URL, e.g. :samp:`https://example.org/sitemap.xml`.

.. code-block:: yaml

   routeEnhancers:
     PageTypeSuffix:
       type: PageType
       map:
         /: 0
         sitemap.xml: 1533906435

.. index:: XmlSitemapDataProviders

XmlSitemapDataProviders
=======================

The rendering of sitemaps is based on XmlSitemapDataProviders. The EXT:seo extension ships with two
XmlSitemapDataProviders. The first one is the PagesXmlSitemapDataProvider.

This will generate a sitemap of pages based on the siteroot that is detected. You can configure if you have additional conditions
for the selection of pages. You also have the possibility to exclude certain doktypes.
Additionally, you may exclude page subtrees from the sitemap (e.g internal pages).

.. code-block:: typoscript

   plugin.tx_seo {
     config {
       xmlSitemap {
         sitemaps {
           pages {
             config {
               excludedDoktypes = 137, 138
               additionalWhere = AND (no_index = 0 OR no_follow = 0)
               #rootPage = <optionally specify a different root page. (default: rootPageId from site configuration)>
               excludePagesRecursive = <commaseparated list of pids>
             }
           }
         }
       }
     }
   }

If you also have an extension installed and want a sitemap of those records, you can use the
RecordsXmlSitemapDataProvider. You can add for example a sitemap for news records:

.. code-block:: typoscript

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
                  additionalWhere = AND (no_index = 0 OR no_follow = 0)
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

You can add several sitemaps and those will be added to the sitemap index automatically.
Use different types to have multiple, independent sitemaps:

.. code-block:: typoscript

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
                           ...
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
                           ...
                           template = GoogleNewsXmlSitemap.html
                       }
                   }
               }
           }
       }
   }

Change frequency and priority
-----------------------------

Change frequencies define how often each page is approximately updated and hence how often it should be revisited
(for example: News in an archive are “never” updated, while your home page might get “weekly” updates).

Priority allows you to define how important the page is compared to other pages on your site. The priority is
stated in a value from 0 to 1. Your most important pages can get an higher priority as other pages. This value does
not affect how important your pages are compared to pages of other websites. All pages and records get a priority of
0.5 by default.

The settings can be defined in TypoScript by mapping the properties to fields of the record by using the options
:typoscript:`changeFreqField` and :typoscript:`priorityField`. :typoscript:`changeFreqField` needs to point to a field containing
string values (see :typoscript:`pages` TCA definition of field :typoscript:`sitemap_changefreq`), :typoscript:`priorityField` needs to point
to a field with a decimal value between 0 and 1.

.. note::

   Both priority and change frequency does have no impact on your rankings. These options only give hints to search engines
   in which order and how often you would like a crawler to visit your pages.

Sitemap of records without sorting field
========================================
Sitemaps are paginated by default. To make sure as less as possible pages of the sitemap changes after the amount of records
is changed, the items in the sitemaps are ordered. By default this is done on the sorting field. If you do not have such a
field, make sure to configure this in your sitemap configuration and use another field. An example you can use to order based on
the uid field:

.. code-block:: typoscript

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

If you need more logic in your sitemap, you can also write your own XmlSitemapProvider. You can do this by
extending the :php:`\TYPO3\CMS\Seo\XmlSitemap\AbstractXmlSitemapDataProvider` class. The most important methods are
:php:`getLastModified` and :php:`getItems`.

The :php:`getLastModified` is used in the sitemap index and have to return the date of the last modified
item in the sitemap.

The :php:`getItems` method have to return an array with the items for the sitemap.

.. code-block:: php

    $this->items[] = [
        'loc' => 'https://example.org/page1.html',
        'lastMod' => '1536003609'
    ];

The loc element, is the URL of the page that the search engine has to crawl. The lastMod element contains the
date of the last update of the specific item. This value is a UNIX-timestamp.


.. _sitemap-xslFile:

Path to sitemap xslFile
=======================

.. versionadded:: 10.3

   It is now possible to configure the path to the sitemap xslFile.
   See changelog :doc:`ext_core:Changelog/10.3/Feature-88147-AddPossibilityToConfigureThePathToSitemapXslFile`

The xsl file to create a layout for a XML sitemap can now be configured on three levels:

#. For all sitemaps:

   .. code-block:: typoscript
      :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

      plugin.tx_seo.config.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl

#. For all sitemaps of a certain sitemapType:

   .. code-block:: typoscript
      :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

      plugin.tx_seo.config.<sitemapType>.sitemaps.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl

#. For a specific sitemap:

   .. code-block:: typoscript
      :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

      plugin.tx_seo.config.<sitemapType>.sitemaps.<sitemap>.config.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl


The value is inherited until it is overwritten.

If no value is specified at all, :file:`EXT:seo/Resources/Public/CSS/Sitemap.xsl` is used as default like before.

