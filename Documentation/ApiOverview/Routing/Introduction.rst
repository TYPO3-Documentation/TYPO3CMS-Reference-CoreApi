.. include:: /Includes.rst.txt
.. index:: ! Routing
.. _routing-introduction:

=======================
Introduction to Routing
=======================

Mathias Schreiber demonstrates the new way of handling URLs
(Version 9.5, 28.09.2018).

.. youtube:: dUz4B08XFes


What is Routing?
================

When TYPO3 serves a request, it maps the incoming URL to a specific page or action.
For example it maps an URL like :samp:`https://example.org/news` to the News page. This process of
determining the page and/or action to execute for a specific URL is called "Routing".

Additionally, routing will take care of beautifying URL parameters, for example converting
:samp:`https://example.org/profiles?user=magdalena` to :samp:`https://example.org/profiles/magdalena`.


Key Terminology
===============


.. index:: Routing; Route

Route
   The "speaking URL" as a whole (without the domain part); for example `/news/detail/2019-software-update`


.. index:: Routing; Slug

Slug
    Unique name for a resource to use when creating URLs; for example the slug of the news detail page
    could be `/news/detail`, and
    the slug of a news record could be `2019-software-update`.

    Within TYPO3, a slug is always a part of the URL "path" - it does not contain scheme, host, HTTP verb, etc.
    The URL "path" consists of one or more slugs which are concatenated into a single string.

    A slug is usually added to a TCA-based database table, containing rules for evaluation and definition.

    The default behaviour of a slug is as follows:

    * A slug only contains characters which are allowed within URLs. Spaces, commas and other special characters are converted to a fallback character.
    * A slug is always lower-cased.
    * A slug is unicode-aware.
    * Slugs must be separated by one or more character like "/", "-", "_" and "&".
      Regular characters like letters should not be used as separators for better readability.

.. note::

   Until TYPO3 v9 routing for TYPO3 was done by using extensions such as `realURL` or `coolURI`.
   In contrast to concepts within RealURL of "URL segments", a slug is a segment of a URL.
   Slugs should be separated by slashes, but this is not a strict requirement.
   Therefore a slug of a record may contain slashes.
   However the risk of conflicts is higher when using slashes
   within slugs. For example unrelated page hierarchies and records could have slugs forming the same URL path.


Routing in TYPO3
================

Routing in TYPO3 is implemented based on the Symfony Routing components. It consists of two parts:

* Page Routing
* Route Enhancements and Aspects

Page Routing describes the process of resolving the concrete page (in earlier TYPO3 versions this were the `id` and `L` `$_GET` parameters),
whereas Route Enhancements and Aspects take care of all additionally configured parameters (such as beautifying plugin parameters, handling `type` etc.).


Prerequisites
=============

To ensure Routing in TYPO3 is fully functional the following prerequisites need to be met:

* web server needs to be configured with rewrites (see :ref:`t3start:system-requirements`)
* site configuration needs to exist (see :ref:`sitehandling`)


Tips
====

Using imports in YAML files
---------------------------

As routing configuration (and site configuration in general) can get pretty long
fast, you should make use of imports in your YAML configuration which allows you
to add routing configurations from different files and different extensions.

Example:

..  code-block:: yaml
    :caption: config/sites/<site-identifier>/config.yaml

    imports:
        - { resource: "EXT:myblog/Configuration/Routes/Default.yaml" }
        - { resource: "EXT:mynews/Configuration/Routes/Default.yaml" }
        - { resource: "EXT:template/Configuration/Routes/Default.yaml" }

..  versionchanged:: 12.0
    In TYPO3 v10.4.14 the feature flag :php:`yamlImportsFollowDeclarationOrder`
    was introduced to enable natural order of YAML imports. For existing
    installations it was set to :php:`false` (resources are imported in reverse
    order), for new installations to :php:`true` (resources are imported in
    declared order). In TYPO3 v12.0 the feature flag was removed and the
    resources are now imported in the exact same order as they are configured in
    the importing file.
