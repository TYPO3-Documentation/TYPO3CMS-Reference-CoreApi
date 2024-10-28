.. include:: /Includes.rst.txt

.. _preupgradetasks:

=================
Pre-upgrade tasks
=================

Before starting the upgrade check your system for compatibility with a newer
TYPO3 version.

* Before you upgrade to the next major version, make sure you have run all
  Upgrade Wizards of the current TYPO3 major version.

* Check for deprecations: Enable the deprecation log and let it log all
  deprecations for a while.

* Alternatively (or additionally) run the
  :ref:`extension scanner <t3coreapi:extension-scanner>` and
  :ref:`handle deprecations <handling-deprecations>` (below).

* Check installed extensions for versions compatible to the target TYPO3
  version

* Try the upgrade on a development system first or create a parallel instance


Check that all system requirements for upgrading are met:

* See :ref:`t3start:system-requirements`

.. _preupgradetasks_make_a_backup:

Make A Backup
=============

.. include:: Backup.rst.txt

.. _update_reference_index:

Update Reference Index
======================

.. include:: ReferenceIndex.rst.txt

.. _check-the-changelog-and-news-md:

Check the ChangeLog
===================

.. include:: Changelog.rst.txt


.. _handling-deprecations:
.. _deprecations:

Resolve Deprecations
====================

.. include:: Deprecations.rst.txt
