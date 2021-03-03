.. include:: /Includes.rst.txt
.. index:: Canonical
.. highlight:: php
.. _canonicalapi:

=============
Canonical API
=============

A brief explanation happens in :ref:`seo`.

In general the system will generate the canonical using the same logic as for
cHash.

Excluding arguments from the generation
=======================================

TYPO3 will fallback to building a URL of current page and appending query strings.
It is possible to exclude specific arguments from being appended.
This is achieved by adding those arguments to a PHP variable::

   $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters'][] = 'example_argument_name';

It is possible to exclude nested arguments::

   $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters'][] = 'example_argument_name[second_level]';

Arguments in general should be excluded from cHash as well as ``additionalCanonicalizedUrlParameters``.
See the possible options in :ref:`caching`, regarding excluding arguments from cHash.

The idea behind that is:

   If a URL is worth caching (because it has different content) it is worth having a canonical as well.

   — https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/pull/1326#issuecomment-788741312

Using an event to define the URL
================================

The process will trigger the event :ref:`ModifyUrlForCanonicalTagEvent` which can be used to set the actual URL to use.

