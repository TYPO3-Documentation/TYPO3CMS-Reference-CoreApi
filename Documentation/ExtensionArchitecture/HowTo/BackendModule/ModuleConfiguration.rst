:navigation-title: Modules.php
..  include:: /Includes.rst.txt
..  _backend-modules-configuration-examples:

=====================================
Backend module configuration examples
=====================================

The configuration of backend modules is placed in the
dedicated configuration file: :file:`Configuration/Backend/Modules.php`.

See also the :ref:`Backend module configuration API <backend-modules-configuration>`.

Read more about

Example: register two backend modules
=====================================

You can find the following example in
`EXT:examples <https://github.com/TYPO3-Documentation/t3docs-examples>`__.

Two backend modules are being registered. The first module is based on
:ref:`Extbase <extbase>` while the second uses a plain controller.

..  include:: _ModuleConfiguration/_Modules.rst.txt


.. _backend-modules-configuration-example-debug:

Check if the modules have been properly registered
==================================================

All registered modules are stored as objects in a registry. They can be viewed
in the backend in the :guilabel:`System > Configuration > Backend Modules`
module.

..  include:: /Images/ManualScreenshots/Backend/BackendModulesConfiguration.rst.txt

The :ref:`ModuleProvider <backend-module-provider-api>` API allows extension
authors to work with the registered modules.
