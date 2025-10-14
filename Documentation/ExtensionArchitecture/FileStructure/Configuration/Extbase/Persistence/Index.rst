..  include:: /Includes.rst.txt
..  _extension-configuration-extbase-persistence:
..  index:: Path; EXT:{extkey}/Configuration/Extbase/Persistence

===================
:file:`Persistence`
===================

This folder can contain the following files:

..  _extension-configuration-extbase-persistence-classes:

..  typo3:file:: Classes.php
    :scope: extension
    :path: /Configuration/Extbase/Persistence/
    :regex: /^.*Configuration\/Extbase\/Persistence\/Classes\.php$/
    :shortDescription: Contains the mapping between a database table and its Extbase model

    In the file :file:`EXT:my_extension/Configuration/Extbase/Persistence/Classes.php` the
    mapping between a database table and its model can be configured. The mapping
    in this file overrides the automatic mapping by naming convention.

    ..  seealso::
        :ref:`Connecting the model to the database <extbase-Persistence>`
