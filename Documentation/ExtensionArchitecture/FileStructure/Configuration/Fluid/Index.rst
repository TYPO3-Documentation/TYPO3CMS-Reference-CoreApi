:navigation-title: Fluid

..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/Fluid
    Path; EXT:{extkey}/Configuration/Fluid

..  _extension-configuration-fluid:

========================================
Extension folder `Configuration/Fluid`
========================================

The folder :file:`EXT:my_extension/Configuration/Fluid/` contains
configuration that introduces namespaces for Fluid.

All files in this directory are automatically included during TYPO3
bootstrap.

..  versionadded:: 14.1

..  _extension-configuration-fluid-namespaces:

..  typo3:file:: Namespaces.php
    :scope: extension
    :path: /Configuration/Fluid/
    :regex: /^.*Configuration\/Fluid\/Namespaces\.php$/
    :shortDescription: Registers and extends global Fluid namespaces

    Register and extend global Fluid namespaces.

    Read more about :ref:`Defining global Fluid namespaces <defining-global-fluid-namespaces>`.


..  _extension-configuration-backend-component-collections:

..  typo3:file:: ComponentCollections.php
    :scope: extension
    :path: /Configuration/Fluid/
    :regex: /^.*Configuration\/Fluid\/ComponentCollections\.php$/
    :shortDescription: Registers a component collection to use :ref:`Fluid components <what-is-fluid-components>`.

    This file is used to add Fluid components. It is used to register component collections. For more
    details see :ref:`Registering component collections <register-fluid-components>`.
