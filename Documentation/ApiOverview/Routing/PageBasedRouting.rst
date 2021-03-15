.. include:: /Includes.rst.txt

.. _routing-page-based-routing:

==================
Page based Routing
==================

TYPO3 allows page based routing (that is mapping pages to routes) out of the box.

Configuration
=============

To enable page based routing, add a site configuration (see :ref:`sitehandling`) for your web site.
To see which route gets mapped to which page, open the page properties and look at the `slug` field.

.. hint::
    To enable editors to change the slug (or update the slug when they change the page title for example) make sure that your
    editor groups have access to the `slug` field.

How a page slug is generated is configured via TCA configuration of the pages table (field `slug`). You can adjust that configuration
in your extensions' :file:`TCA/Overrides/pages.php`. See TCA reference (see :ref:`t3tca:columns-slug` for available options).

Upgrading
=========

An upgrade wizard has been provided that will take care of generating slugs for all existing pages. If you used RealURL before, the
wizard tries to use the RealURL caches to generate matching slugs. However, this will not be successful in all cases and you should
recheck the generated slugs if you want the URL structure to stay the same after an upgrade.


