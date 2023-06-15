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


:file:`<tablename>.php`
=======================

One file per database table, using the name of the table for the file, plus
".php". Only for new tables.


..  index:: Path; EXT:{extkey}/Configuration/TCA/Overrides
..  _extension-configuration-tca-overrides:

:file:`Overrides`
=================

For extending existing tables.

General advice: One file per database table, using the name of the table for the
file, plus :file:`.php`. For more information, see the chapter
:ref:`Extending the TCA array <storing-changes-extension>`.
