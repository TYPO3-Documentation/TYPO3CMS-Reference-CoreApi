.. include:: ../../../Includes.txt


.. _sitehandling-staticRoutes:

Static Routes
--------------

Static routes provide a way to create seemingly static content on a per site base.
Take the following example: 
In a multi-site installation you want to have different `robots.txt` files for each site that should be reachable at `/robots.txt` on each site. You can now add a static route "robots.txt" to your site and define which content should be delivered.

Routes can be configured as toplevel files (as in the robots.txt case) but may also be configured to deeper route paths (`my/deep/path/to/a/static/text` for example). Matching is done on the full path but without any parameters.

Static routes can be configured via the user interface or directly in the yaml configuration.
There are two options: deliver static text or resolve a TYPO3 URL.

StaticText
----------

The :yaml:`staticText` option allows to deliver simple text content. The text can be added through a text field directly in
the site configuration. This is suitable for files like :file:`robots.txt` or :file:`humans.txt`.

YAML Configuration Example::

   route: robots.txt
   type: staticText
   content: |
     Sitemap: https://example.com/sitemap.xml
     User-agent: *
     Allow: /
     Disallow: /forbidden/

TYPO3 URL (t3://)
-----------------

The type :yaml:`uri` for TYPO3 URL provides the option to render either a file, page or url. Internally a request to the
file or URL is done and its content delivered.

YAML Configuration Examples::

   -
     route: sitemap.xml
     type: uri
     source: 't3://page?uid=1&type=1533906435'
   -
     route: favicon.ico
     type: uri
     source: 't3://file?uid=77'


.. note::
    Static route resolving is implemented as a PSR-15 middleware. If the route path requested matches any one of the
    configured site routes, a response is directly generated and returned. This way there is minimal bootstrap code to
    be executed on a static route resolving request, mainly the site configuration needs to be loaded. Static routes cannot
    get parameters as the matching is done solely on the path level.
