:navigation-title: TCA

..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/TCA
    Path; EXT:{extkey}/Configuration/TCA
..  _extension-configuration-tca:

====================================
Extension folder `Configuration/TCA`
====================================

The folder :file:`EXT:my_extension/Configuration/TCA/` may contain or override
:ref:`TCA (Table Configuration Array) <t3tca:introduction>` data.

All files in this directory are automatically included during the TYPO3
:ref:`bootstrap <bootstrapping>`.

Files within :file:`Configuration/TCA/` files are loaded within a dedicated scope.
This means that variables defined in those files cannot leak to any other
TCA file during the TCA compilation process.

..  _extension-configuration-tca-table:

`Configuration/TCA/<tablename>.php`
===================================

..  typo3:file:: tablename.php
    :name: configuration-tca
    :scope: extension
    :path: /Configuration/TCA/
    :regex: /^.*Configuration\/TCA\/[\w]+\.php$/
    :shortDescription: Contains the TCA (Table Configuration Array), which initially defines the table <tablename>. Change TCA of existing tables in directory TCA/Overrides

    One file per database table, using the name of the table for the file, plus
    ".php". Only for new tables, provided by the extension itself.

    **Must not** be used to change existing tables provided by other extensions.

..  versionchanged:: 14.0
    The backwards compatibility for usage of :php:`$GLOBALS['TCA']` in base TCA files
    is removed. See `Important: #107328 - $GLOBALS['TCA'] in base TCA files <https://docs.typo3.org/permalink/changelog:important-107328-1756815543>`_.

    Using :php:`$GLOBALS['TCA']` was discouraged before this change and is
    impossible as the global is not set starting with 14.0


..  index:: Path; EXT:{extkey}/Configuration/TCA/Overrides
..  _extension-configuration-tca-overrides:

`Configuration/TCA/Overrides/somefile.php`
==========================================

..  typo3:file:: somefile.php
    :name: configuration-tca-overrides
    :scope: extension
    :path: /Configuration/TCA/Overrides
    :regex: /^.*Configuration\/TCA\/Overrides\/[\w]+\.php$/
    :shortDescription: Extends the TCA (Table Configuration Array) of a table

    For extending existing tables.

    General advice: One file per database table, using the name of the table for the
    file, plus :file:`.php`. For more information, see the chapter
    :ref:`Extending the TCA array <storing-changes-extension>`.
