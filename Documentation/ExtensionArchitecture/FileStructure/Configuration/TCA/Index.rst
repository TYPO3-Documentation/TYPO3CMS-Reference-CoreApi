..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/TCA
    Path; EXT:{extkey}/Configuration/TCA
..  _extension-configuration-tca:

===========
:file:`TCA`
===========

The folder :file:`EXT:my_extension/Configuration/TCA/` may contain or override
:ref:`TCA (TYPO3 configuration array) <t3tca:introduction>` data.

All files in this directory are automatically included during the TYPO3
:ref:`bootstrap <bootstrapping>`.

..  versionadded:: 12.0
    Files within :file:`Configuration/TCA/` files are loaded within a dedicated scope.
    This means that variables defined in those files cannot leak to any other
    TCA file during the TCA compilation process.

    ..  note::
        In TYPO3 v11 and below, variables declared in these files were in a shared scope,
        with the risk of a leakage to the following files. The use of :php:`call_user_func()`
        wrap was a common workaround.

`<tablename>.php`
=================

..  typo3:file:: <tablename>.php
    :scope: extension
    :path: /Configuration/TCA
    :regex: /^.*\/Configuration\/TCA\/.*\.php/
    :shortDescription: Contains the TYPO3 configuration array, which initially defines the table <tablename>. Change existing tables in directory TCA/Overrides

    One file per database table, using the name of the table for the file, plus
    ".php". Only for new tables.


..  index:: Path; EXT:{extkey}/Configuration/TCA/Overrides
..  _extension-configuration-tca-overrides:

`Overrides`
===========

For extending existing tables.

General advice: One file per database table, using the name of the table for the
file, plus :file:`.php`. For more information, see the chapter
:ref:`Extending the TCA array <storing-changes-extension>`.
