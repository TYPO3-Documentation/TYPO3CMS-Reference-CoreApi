..  include:: /Includes.rst.txt
..  index:: PageTitle
..  _pagetitle:

==============
Page title API
==============

In order to keep setting the page titles in control, you can use the PageTitle
API. The API uses *page title providers* to define the page title based on
page record and the content on the page.

Based on the priority of the providers, the
:php:`\TYPO3\CMS\Core\PageTitle\PageTitleProviderManager` will check the
providers if a title is given by the provider. It will start with the highest
priority and will end with the lowest priority.

By default, the Core ships two providers. If you have installed the :doc:`system
extension SEO <ext_seo:Index>`, the provider with the (by default) highest
priority will be the :php:`\TYPO3\CMS\Seo\PageTitle\SeoTitlePageTitleProvider`.
When an editor has set a value for the SEO title in the page properties of the
page, this provider will provide that title to the
:php:`PageTitleProviderManager`. If you have not installed the SEO system
extension, the field and provider are not available.

The fallback provider with the lowest priority is the
:php:`\TYPO3\CMS\Core\PageTitle\RecordPageTitleProvider`. When no other title is
set by a provider, this provider will return the title of the page.

Besides the providers shipped by the Core, you can add own providers. An
integrator can define the priority of the providers for his project.

..  contents:: Table of contents
    :local:

..  index:: PageTitle; Custom PageTitleProvider

Create your own page title provider
===================================

Extension developers may want to have an own provider for page titles. For
example, if you have an extension with records and a detail view, the title of
the page record will not be the correct title. To make sure to display the
correct page title, you have to create your own page title provider. It is
quite easy to create one.

Example: Set the page title from your extension's controller
-----------------------------------------------------------

First, create a PHP class in your extension that implements the
:php:`\TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface`, for example by
extending :php:`\TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider`.  Within
this method you can create your own logic to define the correct title.

..  code-block:: php

    namespace Vendor\Extension\PageTitle;

    use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

    final class MyOwnPageTitleProvider extends AbstractPageTitleProvider
    {
        public function setTitle(string $title)
        {
            $this->title = $title;
        }
    }

Usage example, for example, in an :ref:`Extbase <extbase>` controller:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/SomeController.php

    $titleProvider = GeneralUtility::makeInstance(MyOwnPageTitleProvider::class);
    $titleProvider->setTitle('Title from controller action');


Configure the new page title provider to be used in your TypoScript setup:

..  literalinclude:: _ExampleSetInController/_setup.typoscript
    :caption: EXT:my_sitepackage/Configuration/TypoScript/setup.typoscript

Example: Use website title from the site configuration
------------------------------------------------------

If you want to use data from the :ref:`site configuration <sitehandling>`, for
example the site title, you can implement a page title provider as follows:

..  literalinclude:: _ExampleWebsiteTitle/_WebsiteTitleProvider.php
    :caption: EXT:my_sitepackage/Classes/PageTitle/WebsiteTitleProvider.php

As we need to :ref:`inject <DependencyInjection>` the class :php:`SiteFinder`
to retrieve the current site configuration, we must make the new page title
provider public:

..  literalinclude:: _ExampleWebsiteTitle/_Services.yaml
    :caption: EXT:my_sitepackage/Configuration/Services.yaml

Then **flush the cache** in :guilabel:`Admin Tools > Maintenance > Flush TYPO3
and PHP Cache`.

Configure the new page title provider to be used in your TypoScript setup:

..  literalinclude:: _ExampleWebsiteTitle/_setup.typoscript
    :caption: EXT:my_sitepackage/Configuration/TypoScript/setup.typoscript

The registered page title providers are called after each other in the
order configured. The first provider that returns a non-empty value is used,
the providers later in the order are ignored.

Therefore our custom provider should be loaded before `record`, the
default provider which always returns a value. If the system extension
:t3ext:`seo` is loaded and setting the :guilabel:`SEO Title` should override
your complete custom title, you can load your provider after `seo`.

.. index:: PageTitle; Priority

Define priority of PageTitleProviders
=====================================

The priority of the providers is set by the TypoScript property
:typoscript:`config.pageTitleProviders`. This way an integrator is able to set
the priorities for his project and can even have conditions in place.

By default, the Core has the following setup:

..  code-block:: typoscript

    config.pageTitleProviders {
        record {
            provider = TYPO3\CMS\Core\PageTitle\RecordPageTitleProvider
        }
    }

The sorting of the providers is based on the :typoscript:`before` and
:typoscript:`after` parameters. If you want a provider to be handled before a
specific other provider, just set that provider in the :typoscript:`before`,
do the same with :typoscript:`after`.

If you have installed the system extension SEO, you will also get a second
provider. The configuration will be:

..  code-block:: typoscript

    config.pageTitleProviders {
        record {
            provider = TYPO3\CMS\Core\PageTitle\RecordPageTitleProvider
        }
        seo {
            provider = TYPO3\CMS\Seo\PageTitle\SeoTitlePageTitleProvider
            before = record
        }
    }

First the :php:`SeoTitlePageTitleProvider` (because it will be handled before
:typoscript:`record`) and, if this providers did not provide a title, the
:php:`RecordPageTitleProvider` will be checked.

You can override these settings within your own installation. You can add as
many providers as you want. Be aware that if a provider returns a non-empty
value, all provider with a lower priority will not be checked.
