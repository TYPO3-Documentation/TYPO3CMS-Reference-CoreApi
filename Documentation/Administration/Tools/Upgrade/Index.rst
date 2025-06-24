:navigation-title: Upgrade

..  include:: /Includes.rst.txt
..  _admin-tools-upgrade:

=====================
Upgrade (Admin Tools)
=====================

Only available if :composer:`typo3/cms-install` is installed with system
maintainer permissions.

The backend module :guilabel:`Admin Tools > Upgrade` offers tools
to system maintainers that are useful during
:ref:`Major upgrades (TYPO3 explained) <t3coreapi:major>`.

..  figure:: /Images/ManualScreenshots/AdminTools/UpgradeTools.png
    :alt: Admin Tools -> Upgrade, Overview

The tools listed here are mainly used during  `Major Upgrades of the TYPO3 Core
or a third party extension <https://docs.typo3.org/permalink/t3coreapi:upgrading>`_.

Some tools can also be used to access the quality of custom TYPO3 extensions.

..  seealso::
    There are also a number of `Third-party tools useful during upgrade <https://docs.typo3.org/permalink/t3coreapi:tools>`_.

..  contents:: Table of contents

..  _admin-tools-upgrade-updater:

Core updater
============

In classic mode TYPO3 installations that fulfil certain criteria you can use
this function to automatically do patch level TYPO3 Core updates.

..  seealso::

    *   :ref:`classic-mode-upgrade-minor`
    *   :ref:`classic-mode-upgrade-disable`
