:navigation-title: Usage in TCA
.. include:: /Includes.rst.txt
.. index:: pair: Site handling; TCA
.. _sitehandling-inTCA:

=====================================================
Using site configuration in TCA `foreign_table_where`
=====================================================

.. index:: pair: Site handling; foreign_table_where

TCA: `foreign_table_where`
==========================

The `foreign_table_where` setting in TCA allows marker-based
placeholders to customize the query. The best place to define site-dependent
settings is the site configuration, which can be used within
`foreign_table_where`.

To access a configuration value the following syntax is available:

* `###SITE:<KEY>###` - <KEY> is your setting name from site config e.g. `###SITE:rootPageId###`
* `###SITE:<KEY>.<SUBKEY>###` - an array path notation is possible. e.g. `###SITE:mySetting.categoryPid###`

Example:
--------

.. code-block:: php

    // ...
    'fieldConfiguration' => [
        'foreign_table_where' => ' AND ({#sys_category}.pid = ###SITE:rootPageId### OR {#sys_category}.pid = ###SITE:mySetting.categoryPid###) ORDER BY sys_category.title ASC',
    ],
    // ...
