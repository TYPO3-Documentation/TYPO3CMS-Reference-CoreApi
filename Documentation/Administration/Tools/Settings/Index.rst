:navigation-title: Settings

..  include:: /Includes.rst.txt
..  _admin-tools-settings:

======================
Settings (Admin Tools)
======================

Only available if :composer:`typo3/cms-install` is installed.

The backend module :guilabel:`Admin Tools > Settings` offers tools
to system maintainers regarding **global** settings that influence the complete
TYPO3 installation.

..  _admin-tools-settings-extension:

Extension configuration (global)
================================

Here you can set global extensions settings. Changes are stored in file
:file:`config/system/settings.php` within the key `EXTENSIONS`. Therefore
extension settings can be overridden in file :file:`config/system/additional.php`,
in variable :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSION']`.

Extensions can define possible global settings in
`ext_conf_template.txt <https://docs.typo3.org/permalink/t3coreapi:extension-options>`_.

..  _admin-tools-settings-password:

Change install tool password
============================

You can use this tool to conveniently change the install tool password from
with the Admin Tools.

..  _admin-tools-settings-maintainer:

Manage system maintainers
=========================

This tool can be used to grant or revoke
`system maintainer <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
permissions from backend administrators.

..  _admin-tools-settings-presets:

Configuration presets
=====================

Some `system configuration settings <https://docs.typo3.org/permalink/t3coreapi:typo3ConfVars>`
(:php:`$GLOBALS['TYPO3_CONF_VARS']`) are commonly use in combination or with
predefined values for certain use cases. Configuration presets can be used to
conveniently configure these settings.

..  _admin-tools-settings-cache:

Cache settings
--------------

TYPO3 features a flexible `caching <https://docs.typo3.org/permalink/t3coreapi:caching>`_
system with a default configuration that is ideal for most use cases.

Depending on your individual hosting setup, the performance of your
TYPO3 instance can be optimized even further by adjusting the storage type.

..  _admin-tools-settings-debug:

Debug settings
--------------

Depending on the `Application Context <https://docs.typo3.org/permalink/t3coreapi:application-context>`_
debug settings live (in Production context, no debugging) or debug (in
Development context, debugging enabled). The debug setting presets can be used
to turn on and of debugging with two clicks.

..  _admin-tools-settings-image:

Image handling settings
-----------------------

These presets can be used to configure paths to Graphics Magick or Image Magick.

More detailed settings are available in
`TYPO3_CONF_VALS GFX - graphics configuration <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-gfx>`_.

..  _admin-tools-settings-mail:

Mail handling settings
----------------------

This preset can be used to configure the commands used to send mails.

More detailed settings are available in
`TYPO3_CONF_VALS MAIL settings <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-mail>`_.

..  _admin-tools-settings-password-hashing:

Password hashing settings
-------------------------

Allows you to switch the `password hashing algorithm <https://docs.typo3.org/permalink/t3coreapi:password-hashing>`_.

..  _admin-tools-settings-feature-toggles:

Feature toggles
===============

..  figure:: /Images/ManualScreenshots/AdminTools/FeatureToggles.png
    :alt: Feature toggles in the Admin Tools

This tool enables and disable Core features. See
`Feature toggle API <https://docs.typo3.org/permalink/t3coreapi:feature-toggles>`_
for details.

..  _admin-tools-settings-typo3confval:

Configure installation-wide options
===================================

In this tool most values in the
`TYPO3_CONF_VARS array in the settings.php <https://docs.typo3.org/permalink/t3coreapi:typo3confvars>`_
can be adjusted.

Values, that have been overridden in the file :file:`config/system/additional.php`
cannot be overviewed here.

Some setting, for example `DB - Database connections <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-db>`_
cannot be viewed or changed here for security reasons.
