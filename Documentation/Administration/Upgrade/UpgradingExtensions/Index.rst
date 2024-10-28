.. include:: /Includes.rst.txt
.. _upgradingextensions:

====================
Upgrading extensions
====================

List extensions
---------------

Like TYPO3's core, extensions are also composer packages. The :bash:`composer info` command will list all
extensions that are currently installed including their name and current version number.

Check for updates
-----------------

To check if any extension upgrades are available, :bash:`composer outdated` can be used to display a list
of packages that have updates along with their new version number.

Upgrade an extension (minor)
----------------------------

Minor upgrades of an extension can be done with the composer command :bash:`composer update vendor/packagename`.

Upgrade an extension (major)
----------------------------

Major upgrades of an extension can be done with the composer command :bash:`composer require vendor/packagename:<new version>`.
