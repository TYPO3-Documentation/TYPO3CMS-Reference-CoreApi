:navigation-title: System Settings

..  include:: /Includes.rst.txt
..  _system-settings-module:

==============================================
System settings: Module Admin Tools > Settings
==============================================

Global configuration can only be changed by backend users with
`System Maintainer privileges <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_.

Use the backend module :guilabel:`Admin Tools > Settings` to access the
different configuration options:

..  figure:: /Images/ManualScreenshots/AdminTools/AdminToolsSettings.png
    :alt: Backend module "Admin Tools > Settings" as seen by a system maintainer

Changes made in this module are written to file :file:`config/system/settings.php`.
They can be overridden by configuration in file :file:`config/system/additional.php`
in which case they cannot be changed from the TYPO3 Backend.
