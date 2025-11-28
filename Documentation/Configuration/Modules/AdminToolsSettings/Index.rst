:navigation-title: System Settings

..  include:: /Includes.rst.txt
..  _system-settings-module:

==========================
Module "System > Settings"
==========================

..  versionchanged:: 14.0
    This module has been moved from :guilabel:`Admin tools` to :guilabel:`Settings`
	<https://docs.typo3.org/permalink/changelog:feature-107628-1729026000>`_.

Global configuration can only be changed by backend users with
`System Maintainer privileges <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_.

Use the backend module :guilabel:`System > Settings` to access the
different configuration options:

..  figure:: /Images/ManualScreenshots/AdminTools/AdminToolsSettings.png
    :alt: Backend module "System > Settings" as seen by a system maintainer

Changes made in this module are written to file :file:`config/system/settings.php`.
They can be overridden by configuration in file :file:`config/system/additional.php`
in which case they cannot be changed from the TYPO3 Backend.
