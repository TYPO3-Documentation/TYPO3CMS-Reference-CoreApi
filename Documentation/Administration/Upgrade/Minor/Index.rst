.. include:: /Includes.rst.txt

.. _minor:

===================
Patch/Bugfix update
===================

What are patch/bugfix updates
=============================

Patch/Bugfix updates contain bugfixes and security updates. They never contain new features and do not break backwards compatibility.

For example, updating from TYPO3 version `11.5.2` to `11.5.3` is a patch/bugfix update.

Before updating
===============

The :ref:`pre-upgrade tasks <preupgradetasks>` chapter contains a list of tasks that
should be completed prior to upgrading to a major release.

The only tasks that need to be completed for a patch/bugfix update are :ref:`making a backup <make_a_backup>` and :ref:`updating the reference index <update_reference_index>`.

Check if updates are available
===============================

There are two ways to check if a patch/bugfix update is available for an installation of TYPO3.

All supported versions of TYPO3 and their version numbers are published on `get.typo3.org <https://get.typo3.org>`_.

Alternatively, running  :bash:`composer outdated -m "typo3/*"` will present a list of any TYPO3 packages that have patch/bugfix updates.

Execute the update
==================

To execute the update, run :bash:`composer update --with-all-dependencies "typo3/*"`.

This will update all TYPO3 packages. The :bash:`--with-all-dependencies` signals that any dependencies of TYPO3 should also be updated.

Post update
===========

Once Composer has completed updating the installation of TYPO3, log in to the
backend and clear all caches.

You should also do a `database compare <https://docs.typo3.org/permalink/t3coreapi:database-upgrade>`_.

:guilabel:`Admin Tools > Maintenance > Flush TYPO3 and PHP Cache`
