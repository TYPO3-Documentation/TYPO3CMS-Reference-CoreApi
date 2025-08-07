..  include:: /Includes.rst.txt
..  index:: pair: Site handling; Static routes
..  _sitehandling-staticRoutes:

=============
Static routes
=============

Static routes provide a way to create seemingly static content on a per site
base. Take the following example: In a multi-site installation you want to have
different :file:`robots.txt` files for each site that should be reachable at
`/robots.txt` on each site. Now, you can add a static route :yaml:`robots.txt`
to your site configuration and define which content should be delivered.

Routes can be configured as top level files (as in the :yaml:`robots.txt` case),
but may also be configured to deeper route paths
(:yaml:`my/deep/path/to/a/static/text`, for example). Matching is done on the
full path, but without any parameters.

Static routes can be configured via the user interface or directly in the YAML
configuration. There are two options: deliver static text or resolve a TYPO3 URL.

..  note::
    Static route resolving is implemented as a
    :ref:`PSR-15 middleware <request-handling>`. If the route path requested
    matches any one of the configured site routes, a response is directly
    generated and returned. This way there is minimal bootstrap code to be
    executed on a static route resolving request, mainly the site configuration
    needs to be loaded. Static routes cannot get parameters, as the matching is
    done solely on the path level.


..  index:: Site handling; StaticText

:yaml:`staticText`
==================

The :yaml:`staticText` option allows to deliver simple text content. The text
can be added through a text field directly in the site configuration. This is
suitable for files like :file:`robots.txt` or :file:`humans.txt`.

A configuration example:

..  literalinclude:: _static-routes-static-text.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml


.. index::
   Site handling; TYPO3 URL
   TYPO3 URL
   t3://
   see: t3://; TYPO3 URL

.. _static-routes-to-assets:
Static routes to assets
=======================

..  versionadded:: 13.3

The type :yaml:`assets` allows to expose
resources which are typically located in the directory
:file:`EXT:my_extension/Resources/Public/`.

A configuration example:

..  literalinclude:: _static-routes-assets.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

This enables you to reach the files at :samp:`https://example.org/example.svg`
and :samp:`https://example.org/favicon.ico`.

The asset URL is configured on a per-site basis.
This allows to deliver site-dependent custom favicon or manifest
assets, for example.

TYPO3 URL (t3://)
=================

The type :yaml:`uri` for a TYPO3 URL provides the option to render either a
file, page or URL. Internally, a request to the file or URL is done and its
content delivered.

A configuration example:

..  literalinclude:: _static-routes-uri.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml
