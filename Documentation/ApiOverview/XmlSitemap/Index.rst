.. include:: /Includes.rst.txt


.. _xmlsitemap:

===========
XML Sitemap
===========

.. versionadded:: 9.4

   XML Sitemap support was added to the core with change :doc:`t3core:Changelog/9.4/Feature-84525-XMLSitemap`.

It is possible to generate XML sitemaps for SEO purposes without using 3rd-party plugins.
When enabled, this new feature will create a sitemapindex with one or more sitemaps in it.
Out-of-the-box it will have one sitemap containing all the pages of the current site and
language. Per site and per language you have the possibility to render a different sitemap.

Installation
============

The XML sitemap is disabled by default. You can easily enable it by installing the system
extension "seo" and including the static TypoScript template XML Sitemap (seo). It is also
mandatory to have a site configuration for your rootpage(s).

How to Access Your XML Sitemap
==============================

Until it is possible to have a default route with the new URL handling mechanism, you can access
the sitemaps by going to https://yourdomain.com/?type=1533906435. You will first see the sitemap
index. By default you will see one sitemap in the index. This is the sitemap for pages.

If you have multiple siteroots or multiple languages with different domains or language prefixes,
you can just go to the domain that handles the siteroot / language. The sitemap will be based on
the settings for that domain.

XmlSitemapDataProviders
=======================

The rendering of sitemaps is based on XmlSitemapDataProviders. The EXT:seo extension ships with two
XmlSitemapDataProviders. The first one is the PagesXmlSitemapDataProvider. This will generate a sitemap
of pages based on the siteroot that is detected. You can configure if you have additional conditions
for the selection of pages. You also have the possibility to exclude certain doktypes.

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

Change Frequency and Priority
-----------------------------

Change frequencies define how often each page is approximately updated and hence how often it should be revisited
(for example: News in an archive are “never” updated, while your home page might get “weekly” updates).

Priority allows you to define how important the page is compared to other pages on your site. The priority is
stated in a value from 0 to 1. Your most important pages can get an higher priority as other pages. This value does
not affect how important your pages are compared to pages of other websites. All pages and records get a priority of
0.5 by default.

The settings can be defined in TypoScript by mapping the properties to fields of the record by using the options
:ts:`changeFreqField` and :ts:`priorityField`. :ts:`changeFreqField` needs to point to a field containing
string values (see :ts:`pages` TCA definition of field :ts:`sitemap_changefreq`), :ts:`priorityField` needs to point
to a field with a decimal value between 0 and 1.

.. note::

   Both priority and change frequency does have no impact on your rankings. These options only give hints to search engines
   in which order and how often you would like a crawler to visit your pages.


Create Your Own XmlSitemapDataProvider
======================================

If you need more logic in your sitemap, you can also write your own XmlSitemapProvider. You can do this by
extending the \TYPO3\CMS\Seo\XmlSitemap\AbstractXmlSitemapDataProvider class. The most important methods are
:php:`getLastModified` and :php:`getItems`.

The :php:`getLastModified` is used in the sitemap index and have to return the date of the last modified
item in the sitemap.

The :php:`getItems` method have to return an array with the items for the sitemap.

.. code-block:: php

    $this->items[] = [
        'loc' => 'https://www.yourdomain.com/page1.html',
        'lastMod' => '1536003609'
    ];

The loc element, is the URL of the page that the search engine has to crawl. The lastMod element contains the
date of the last update of the specific item. This value is a UNIX-timestamp.


.. _sitemap-xslFile::

Path to sitemap xslFile
=======================

.. versionadded:: 10.3

   It is now possible to configure the path to the sitemap xslFile.
   See changelog :doc:`t3core:Changelog/master/Feature-88147-AddPossibilityToConfigureThePathToSitemapXslFile`

The xsl file to create a layout for a XML sitemap can now be configured on three levels:

#. For all sitemaps::

      plugin.tx_seo.config.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl

#. For all sitemaps of a certain sitemapType::

      plugin.tx_seo.config.<sitemapType>.sitemaps.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl

#. For a specific sitemap::

      plugin.tx_seo.config.<sitemapType>.sitemaps.<sitemap>.config.xslFile = EXT:myext/Resources/Public/CSS/mySite.xsl


The value is inherited until it is overwritten.

If no value is specified at all, :file:`EXT:seo/Resources/Public/CSS/Sitemap.xsl` is used as default like before.

