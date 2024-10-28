.. include:: /Includes.rst.txt

.. _tools:

=================
Third-party tools
=================

A collection of third-party resources that can assist with upgrade and
maintenance tasks.

Rector for TYPO3
================

Rector for TYPO3 was created to help developers upgrade their TYPO3 installations
and ensure their extensions support the latest versions of PHP and TYPO3. Rector
scans your code base and replaces any deprecated functions with an appropriate
replacement. Rector can also help ensure better code quality by means of automated refactoring.

Rector can run as a standalone package or it can be integrated with your CI pipeline.

Resources
---------

- `Rector for TYPO3 GitHub page <https://github.com/sabbelasichon/typo3-rector>`__.
- `Best practice guide <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/best_practice_guide.md>`__.

Support
-------

Visit the `TYPO3 Slack <https://typo3.org/community/meet/chat-slack>`__ and search for the `#ext-typo3-rector`
channel. You can also open an issue or start a discussion on the projects GitHub page.

EXT: Core Upgrader (v2)
=======================

The TYPO3 extension was initially developed as
`EXT:core-upgrader <https://github.com/IchHabRecht/core_upgrader>` (Composer package
`ichhabrecht/core-upgrader`, compatible up to TYPO3 v10) and has been forked as
`EXT:core-upgraderv2 <https://github.com/WapplerSystems/core_upgrader>` (Composer package
`wapplersystems/core-upgrader`, compatible up to TYPO3 v12).

The extension allows to perform multiple TYPO3 Core version upgrades in one step by offering
the older upgrade wizards.

Another way to perform (and test/verify) upgrades of multiple TYPO3 versions in one go is outlined
in a `blog article "Automatic TYPO3 Updates Across Several Major Versions With DDEV <https://typo3.org/article/automatic-typo3-updates-across-several-major-versions-with-ddev>`.
