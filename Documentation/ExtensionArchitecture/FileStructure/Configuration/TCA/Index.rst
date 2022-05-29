.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/TCA
   Path; EXT:{extkey}/Configuration/TCA
.. _extension-configuration-tca:

================================
:file:`TCA`
================================

The folder :file:`EXT:my_extension/Configuration/TCA/` may contain or override
TCA (TYPO3 configuration array) data.

All files in this directory are automatically included during the TYPO3
bootstrap.

:file:`<tablename>.php`
================================

One file per database table, using the name of the table for the file, plus
".php". Only for new tables.

.. index:: Path; EXT:{extkey}/Configuration/TCA/Overrides


.. _extension-configuration-tca-overrides:

:file:`Overrides`
================================

For extending existing tables.
General advice: One file per database table, using the name of the table for the file, plus ".php".
For more information, see chapter :ref:`Extending the TCA Array <storing-changes-extension>`.
