.. include:: /Includes.rst.txt
.. index:: Canonical
.. _canonicalapi:

=============
Canonical API
=============

A brief explanation happens in :ref:`seo`.

In general the system will generate the canonical using the same logic as for
cHash.

.. note::
   The canonical API is provided by the optional system extension
   EXT:seo. You can find information about how to install and use it in the
   :doc:`EXT:seo manual <ext_seo:Index>`.

.. _canonicalapi-additionalparameters:

Including specific arguments for the URL generation
================================================

TYPO3 will building a URI of the current page and append query strings
which are needed for the cHash calculation (vital arguments to uniquely identify
the given content URI). This is especially important with for example detail pages of records. The query parameters are crucial to show the right content.

It is possible to additionally include specific arguments.
This is achieved by adding those arguments to a PHP variable:

..  code-block:: php
    :caption: EXT:site_package/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters'][] = 'example_argument_name';

It is possible to include nested arguments:

..  code-block:: php
    :caption: EXT:site_package/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters'][] = 'example_argument_name[second_level]';

Non-vital arguments in general should be excluded from cHash and not be listed as ``additionalCanonicalizedUrlParameters``.
See the possible options in :ref:`caching` regarding excluding arguments from cHash.

The idea behind that is:

   If a URL is worth caching (because it has different content) it is worth having a canonical as well.

   — https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/pull/1326#issuecomment-788741312

Using an event to define the URL
================================

The process will trigger the event :ref:`ModifyUrlForCanonicalTagEvent` which can be used to set the actual URL to use.
