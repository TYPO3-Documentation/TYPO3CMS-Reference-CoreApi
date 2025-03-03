:navigation-title: Redirect Headers

..  include:: /Includes.rst.txt
..  index::
    Redirect headers
    Http; X-Redirect-By
    Page types; Redirect headers
..  _page-types-redirect-header:

==================================================
X-Redirect-By header for pages with redirect types
==================================================

The following page types trigger a redirect:

*   :ref:`Shortcut <list-of-page-types-shortcut>`
*   :ref:`Mount point pages <list-of-page-types-mountpoint>` which should be
    overlaid when accessed directly
*   :ref:`Link to external URL <list-of-page-types-link>`

Those redirects will send an additional HTTP Header `X-Redirect-By`, stating what type of page triggered the redirect.
By enabling the global option :php:`$GLOBALS['TYPO3_CONF_VARS']['FE']['exposeRedirectInformation']` the header will also contain the page ID.
As this exposes internal information about the TYPO3 system publicly, it should only be enabled for debugging purposes.

For shortcut and mountpoint pages:

.. code-block:: none
   :caption: Generated HTTP header

   X-Redirect-By: TYPO3 Shortcut/Mountpoint
   # exposeRedirectInformation is enabled
   X-Redirect-By: TYPO3 Shortcut/Mountpoint at page with ID 123

For *Links to External URL*:

.. code-block:: none
   :caption: Generated HTTP header

   X-Redirect-By: TYPO3 External URL
   # exposeRedirectInformation is enabled
   X-Redirect-By: TYPO3 External URL at page with ID 456

The header `X-Redirect-By` makes it easier to understand why a redirect happens
when checking URLs, e.g. by using `curl`:

.. code-block:: bash
   :caption: Using curl to check the HTTP header

   curl -I 'https://example.org/examples/pages/link-to-external-url/'

   HTTP/1.1 303 See Other
   Date: Thu, 17 Sep 2020 17:45:34 GMT
   X-Redirect-By: TYPO3 External URL at page with ID 12
   X-TYPO3-Parsetime: 0ms
   location: https://example.org
   Cache-Control: max-age=0
   Expires: Thu, 17 Sep 2020 17:45:34 GMT
   X-UA-Compatible: IE=edge
   Content-Type: text/html; charset=UTF-8
