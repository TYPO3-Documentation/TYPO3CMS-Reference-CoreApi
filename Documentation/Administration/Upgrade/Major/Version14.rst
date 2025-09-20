:navigation-title: TYPO3 14

..  include:: /Includes.rst.txt
..  _upgrade-14:

=====================================
TYPO3 14: Upgrading the major version
=====================================

..  warning::

    This list is still work in progress. If you have additional tips or found
    a pitfall, use the "Report an issue" button to suggest your solution or
    the "Edit on GitHub" button to provide a pull request directly.

..  contents:: Table of contents

..  _upgrade-wizards-14:

Upgrade Wizards for TYPO3 14
============================

..  _upgrade-wizards-14-scheduler:

Migration of scheduler tasks to the new format
----------------------------------------------

..  seealso::
    *   `Important: #106532 - Changed database storage format for Scheduler Tasks <https://docs.typo3.org/permalink/changelog:important-106532-1744207039>`_

The following upgrade wizard has to be run if the system extension
:composer:`typo3/cms-scheduler` is installed:

**Migrate the contents of the tx_scheduler_task database table into a more structured form.**

The Scheduler task format has changed in TYPO3 v14. You must run the upgrade
wizard to migrate existing tasks.

*   If the wizard stays visible after execution, some tasks could not be
    migrated. Check tx_scheduler_task for entries with an empty tasktype and
    recreate them manually.
*   Run this step **only in TYPO3 v14**. It may not work in later versions.
