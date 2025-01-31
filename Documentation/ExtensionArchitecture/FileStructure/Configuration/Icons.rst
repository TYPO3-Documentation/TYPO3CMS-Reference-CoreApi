..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/Icons.php
    Path; EXT:{extkey}/Configuration/Icons.php
..  _extension-configuration-Icons-php:

=================
:file:`Icons.php`
=================

..  typo3:file:: Icons.php
    :scope: extension
    :path: /Configuration/
    :regex: /^.*\/Configuration\/Icons\.php/
    :shortDescription: Registration of custom icons

    In this file custom icons can be registered in the
    :php:`\TYPO3\CMS\Core\Imaging\IconRegistry`.

    See the :ref:`Icon API <icon>` for details.

..  literalinclude:: /ApiOverview/Icon/_Icons.php
    :language: php
    :caption: EXT:my_extension/Configuration/Icons.php
