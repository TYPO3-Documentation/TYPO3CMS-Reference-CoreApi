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

By default, the Core ships two providers. If you have installed
:composer:`typo3/cms-seo`, the provider with the (by default) highest
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

.. seealso::

   The page title is further influenced by :ref:`t3tsref:setup-config-pagetitle`
   and :ref:`sitehandling-basics-websiteTitle`.

..  contents:: Table of contents
    :local:

..  index:: PageTitle; Custom PageTitleProvider

..  _page-title-provider-custom:

Create your own page title provider
===================================

Extension developers may want to have an own provider for page titles. For
example, if you have an extension with records and a detail view, the title of
the page record will not be the correct title. To make sure to display the
correct page title, you have to create your own page title provider. It is
quite easy to create one.

..  _page-title-provider-custom-example:

Example: Set the page title from your extension's controller
------------------------------------------------------------

First, create a PHP class in your extension that implements the
:php:`\TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface`, for example by
extending :php:`\TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider`.  Within
this method you can create your own logic to define the correct title.

..  literalinclude:: _PageTitleProvider/_ExampleSetInController/_MyOwnPageTitleProvider.php
    :caption: EXT:my_extension/Classes/PageTitle/MyOwnPageTitleProvider.php

Usage example in an :ref:`Extbase <extbase>` controller:

..  literalinclude:: _PageTitleProvider/_ExampleSetInController/_SomeController.php
    :caption: EXT:my_extension/Classes/Controller/SomeController.php

Configure the new page title provider in your TypoScript setup:

..  literalinclude:: _PageTitleProvider/_ExampleSetInController/_setup.typoscript
    :language: typoscript
    :caption: EXT:my_sitepackage/Configuration/TypoScript/setup.typoscript

..  _page-title-provider-custom-site-config:

Example: Use values from the site configuration in the page title
-----------------------------------------------------------------

If you want to use data from the :ref:`site configuration <sitehandling>`, for
example the site title, you can implement a page title provider as follows:

..  literalinclude:: _PageTitleProvider/_WebsiteTitleProvider.php
    :caption: EXT:my_sitepackage/Classes/PageTitle/WebsiteTitleProvider.php

..  versionchanged:: 13.0
    The :ref:`frontend.page.information attribute <typo3-request-attribute-frontend-page-information>`
    has been introduced.

The class must be set to :ref:`public <t3coreapi:What-to-make-public>`, because
we :ref:`inject <DependencyInjection>` the class :php:`SiteFinder` as
dependency.

Then **flush the cache** in :guilabel:`Admin Tools > Maintenance > Flush TYPO3
and PHP Cache`.

Configure the new page title provider to be used in your TypoScript setup:

..  literalinclude:: _PageTitleProvider/_website.typoscript
    :language: typoscript
    :caption: EXT:my_sitepackage/Configuration/TypoScript/setup.typoscript

The registered page title providers are called after each other in the
configured order. The first provider that returns a non-empty value is used,
the providers later in the order are ignored.

Therefore our custom provider should be loaded before `record`, the
default provider which always returns a value. If the system extension
:composer:`typo3/cms-seo` is loaded the default :guilabel:`SEO Title` has a particular format,
you can change this by loading your custom provider before `seo`.

.. index:: PageTitle; Priority

.. _define-the-priority-of-pagetitleproviders:

Define the priority of PageTitleProviders
=========================================

The priority of the providers is set by the TypoScript property
`config.pageTitleProviders <https://docs.typo3.org/permalink/t3tsref:confval-config-pagetitleproviders>`_.
This way an integrator is able to set
the priorities for their project and can even have conditions in place.

By default, the Core has the following setup:

..  literalinclude:: _PageTitleProvider/_core.typoscript

The sorting of the providers is based on the :typoscript:`before` and
:typoscript:`after` parameters. If you want a provider to be handled before a
specific other provider, just set that provider in the :typoscript:`before`,
do the same with :typoscript:`after`.

If you have installed the system extension SEO, you will also get a second
provider. The configuration will be:

..  literalinclude:: _PageTitleProvider/_pageTitleProviders.typoscript

First the :php:`SeoTitlePageTitleProvider` (because it will be handled before
:typoscript:`record`) and, if this providers did not provide a title, the
:php:`RecordPageTitleProvider` will be checked.

You can override these settings within your own installation. You can add as
many providers as you want. Be aware that if a provider returns a non-empty
value, all provider with a lower priority will not be checked.
