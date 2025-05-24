:navigation-title: Backups

..  include:: /Includes.rst.txt
..  _security-backups:

====================
Backups and recovery
====================

A secure TYPO3 setup must include a working backup strategy. Backups allow you to
recover from data loss, attacks, or misconfiguration. However, backups themselves
can also be a security risk if stored in the web root or transmitted without encryption.

For full recommendations on what to back up, how to store backups securely, and how
to automate and test them, see:

For full recommendations on how to handle backups securely, see
:ref:`Backup strategy <administration-backups>`.

..  _security-backup-risk:

Avoid exposed backups in the web root
=====================================

Never store backup files inside the web server's document root. If backups
(for example `.zip`, `.sql`, `.tar.gz`) are accessible via a browser, they pose a
serious security risk. Attackers can download and extract sensitive data such
as:

-   TYPO3 configuration and database credentials
-   Backend user accounts and hashed passwords
-   Customer records or uploaded files

Backups should always be stored **outside** the document root, and access to
them must be restricted. Obscure file names or hidden URLs are **not**
sufficient protection.

..  index:: Backup; Retention
..  _security-backups-time-plan:

Backup retention for security incidents
=======================================

From a security standpoint, backup retention is not just about restoring lost
data — it is also about enabling recovery from **undetected attacks** or
**delayed compromises**.

If an attacker gains access to your system, malicious changes may go unnoticed
for days or even weeks. In such cases, a single recent backup may already
contain injected code, altered configuration, or corrupted data.

To reduce the risk of restoring a compromised state, follow a backup rotation
strategy that keeps versions from multiple time periods. For example:

- One **daily** backup for the last 7 days
- One **weekly** backup for the last 4 weeks
- One **monthly** backup for the last 6 months
- One **yearly** backup for each of the last several years

This allows you to restore from a known-good state **before** compromise and
support forensic investigations into when and how an incident occurred.

Backups should be tested regularly to confirm they are complete and restorable.
