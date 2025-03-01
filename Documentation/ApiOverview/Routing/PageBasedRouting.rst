:navigation-title: Page-based Routing

.. include:: /Includes.rst.txt

.. index:: Routing; Page-based
.. _routing-page-based-routing:

==================
Page-based routing
==================

TYPO3 provides built-in support for page-based routing, mapping pages to
routes automatically.

Page-based routing is always enabled in TYPO3 and requires a site
configuration (see :ref:`sitehandling`) for your website. Each page's route
is determined by its `slug` field, which can be viewed in the page
properties.

..  hint::
    Ensure that editors have the necessary permissions to modify the `slug`
    field if they need to change or update slugs when modifying page titles.

The generation of page slugs is controlled via the TCA configuration of the
`pages` table (`slug` field). This configuration can be customized in your
extension’s :file:`TCA/Overrides/pages.php`. Refer to the TCA reference
(:ref:`t3tca:columns-slug`) for available options.

If the system extension :composer:`typo3/cms-redirects` is installed,
redirects are automatically generated when a slug is adjusted by and editor.
