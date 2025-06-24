:navigation-title: Page properties

..  include:: /Includes.rst.txt
..  _config-page-properties:

=======================================
Page properties: Settings at page level
=======================================

If the user has the correct permissions, settings for a page (and in some
cases all subpages) can be made in the page properties:

..  figure:: /Images/ManualScreenshots/Backend/PageProperties.png
    :alt: Screenshot demonstrating the location of the "Edit page properties" button in the header of the "Web > Page" module

    In the "Page" or "List" module click on "Edit page properties"

Some plugins also come with settings, refer to the manual of the extension
providing the plugin.

..  seealso::

    *   `Tutorial for editors: Page properties <https://docs.typo3.org/permalink/t3editors:pages-properties>`_
    *   `Site package Tutorial: Choose the page layout in the page properties <https://docs.typo3.org/permalink/t3sitepackage:choose-page-layout>`_

Technically the page properties are the same as the form displaying the page
record from table :sql:`pages`. They can therefore be configured by developers
via `TCA <https://docs.typo3.org/permalink/t3tca:start>`_.

The concrete settings available in the page properties depend on the chosen
`Page types <https://docs.typo3.org/permalink/t3coreapi:page-types-intro>`_,
represented by database field :sql:`doktype`.
