.. include:: /Includes.rst.txt
.. index:: ! Routing
.. _routing-introduction:

=======================
Introduction to Routing
=======================

What is Routing?
================

When TYPO3 serves a request, it maps the incoming URL to a specific page or action.
For example it maps an URL like `https://example.com/news` to the News page. This process of
determining the page and/or action to execute for a specific URL is called "Routing".

Additionally, routing will take care of beautifying URL parameters, for example converting
`https://example.com/profiles?user=magdalena` to `https://example.com/profiles/magdalena`.


Key Terminology
===============


.. index:: Routing; Route

:aspect:`Route`
   The "speaking URL" as a whole (without the domain part); for example `/news/detail/2019-software-update`


.. index:: Routing; Slug

:aspect:`Slug`
    Unique name for a ressource to use when creating URLs; for example the slug of the news detail page could be `/news/detail` and
    the slug of a news record could be `2019-software-update`.

    Within TYPO3, a slug is always part of the URL "path" - it does not contain scheme, host, HTTP verb, etc.

    A slug is usually added to a TCA-based database table, containing rules for evaluation and definition.

    The default behaviour of a slug is as follows:

    * A slug only contains characters which are allowed within URLs. Spaces, commas and other special characters are converted to a fallback character.
    * A slug is always lower-cased.
    * A slug is unicode-aware.

.. note::

    Until TYPO3 v9 routing for TYPO3 was done by using extensions such as `realURL` or `coolURI`.
    In contrast to concepts within RealURL of "URL segments", a slug is a segment of a URL, but it does not have
    to be separated by slashes. Therefore, a slug can contain slashes.


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

* web server needs to be configured with rewrites (see :ref:`t3install:system-requirements`)
* site configuration needs to exist (see :ref:`sitehandling`)


Tips
====

Use imports in yaml files
-------------------------

As routing configuration (and site configuration in general) can get pretty long fast, you should make use of imports
in your yaml configuration which allows you to add routing configurations from different files and different extensions.

Example - Main :file:`config.yaml`

.. code-block:: yaml

   imports:
      - { resource: "EXT:myblog/Configuration/Routes/Default.yaml" }
      - { resource: "EXT:mynews/Configuration/Routes/Default.yaml" }
      - { resource: "EXT:template/Configuration/Routes/Default.yaml" }


