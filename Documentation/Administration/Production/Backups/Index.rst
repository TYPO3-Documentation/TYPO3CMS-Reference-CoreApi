:navigation-title: Backups

..  include:: /Includes.rst.txt
..  _administration-backups:

======================
Secure backup strategy
======================

Backups are a critical part of any TYPO3 project and are usually the
responsibility of the system administrator. Hosting providers may offer
automated backups, especially on shared or managed hosting, but you should
never assume these exist, are up to date, or can be restored—always verify.

While backups do not prevent attacks, they are essential for recovery after
data loss, hardware failure, or a security breach. A working and tested backup
is often the fastest way to restore your site.

..  warning::

    Never store backups inside the web server’s document root.
    They may expose sensitive data if publicly accessible.

    For details, see :ref:`Security risks of exposed backups <security-backup-risk>`.

..  contents:: Table of contents
..  _security-backup-components:

What to include in a TYPO3 backup
=================================

The required backup components depend on your installation method and how your
project is structured.

..  _security-backup-essential:

Essential backup items (all installations)
------------------------------------------

The following must be included in **all TYPO3 backups**, regardless of the
installation type:

-   The **database** – contains all content, page structure, users, and records
-   :path:`fileadmin/` – user-uploaded files (images, PDFs, etc.) You may exclude
    subdirectories like :path:`_processed_` that TYPO3 can regenerate.
-   Any **additional file storages** configured in TYPO3 (e.g. media folders,
    mounted volumes, or cloud-based storage backends)
-   **Log files** – may be required for audits or forensic analysis after an incident

    -   For Composer-based setups: logs are usually found in :path:`var/log/`
    -   For classic installations: logs may be under :path:`typo3temp/var/log/`

TYPO3 installations may use multiple file storage locations for managing files.
Be sure to identify and back up all relevant locations defined in your instance’s
`File storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages>`_
configuration.

..  _security-backup-classic:

Classic-mode installations (non-Composer)
-----------------------------------------

For classic (non-Composer) installations, also back up:

- :path:`typo3conf/` – contains extensions, configuration, and language files

This directory typically includes locally installed extensions and custom
configuration. If these files are **not tracked in version control**, they
must be included in your backup to ensure the site can be restored completely.

..  _security-backup-composer:

Composer-based installations
----------------------------

For modern, Composer-based TYPO3 projects, the structure separates the
**project root** (code and configuration) from the **public document root**.

Back up the following:

-   :path:`config/` – contains system settings and site configuration
-   :path:`public/fileadmin/` – public content files
-   :path:`var/` – optional, useful if you want to preserve logs or session data;
    otherwise, it can usually be regenerated automatically

..  _security-backup-version-control:

When using version control (Git)
--------------------------------

If your Composer-based project uses Git (or another VCS), and your
:path:`config/`, :file:`composer.json`, and custom extensions / site packages
are committed:

-   You do **not** need to include these files in your backups
-   Ensure the repository is complete and regularly pushed to a secure remote
-   Focus your backup on content, assets, and the database

See also `Version control of TYPO3 projects with Git <https://docs.typo3.org/permalink/t3coreapi:version-control>`_

..  _security-backup-unnecessary:

What not to back up
-------------------

These directories are usually not necessary in backups but can be included
if needed. There is no harm in backing them up, though it may increase
backup size and time without adding much benefit.

-   :path:`typo3temp/`, :path:`var/`  – these contain temporary data that TYPO3
    regenerates automatically. However, if log files are stored here
    (e.g., :path:`var/log/`), consider backing them up separately.
-   TYPO3 Core source code – can be reinstalled unless it has been modified
    (which is strongly discouraged).
-   :path:`fileadmin/_processed_/` – contains resized and transformed image
    variants. These can be safely excluded from backups, as TYPO3 regenerates
    them automatically when needed.

..  _security-backup-database:

Backing up the database
-----------------------

Create regular database dumps as part of your backup strategy.

For MySQL:

-   Use `mysqldump` to export the database as a dump file
-   Automate exports using cron jobs or scheduled tasks
-   Verify that all tables are included and that encoding and collation are consistent

TYPO3 stores many non-critical records in cache-related tables (for example,
`cache_pages`, `cache_rootline`, or `cf_*`). These tables can be excluded from
backups to reduce size and restore time. TYPO3 will automatically rebuild
cache tables after a successful restore.

..  note::

   Do not attempt to back up only the raw database files (such as `.ibd` or `.frm` files).
   This approach is unreliable and may result in a corrupted or incomplete database if
   the server is running during the backup. Use logical dumps (`mysqldump`) or other
   hot backup tools designed for your database system.

..  _security-backup-verify:

Verifying your backups
-----------------------

Always test your backups to ensure they can be restored.

Best practices:

-   Restore to a separate environment and check the site for errors or missing data
-   Perform restoration tests regularly
-   Ensure both files and database are recoverable

A backup is only useful if it works when you need it.

..  index:: Backup; Time plan
..  _administration-backups-time-plan:

Backup frequency and retention strategy
=======================================

Create backups regularly — at least once per day, ideally during low-traffic hours.
Keep multiple backup versions over time, rather than overwriting previous ones.

A common rotation strategy might include:

-   One **daily** backup for the past 7 days
-   One **weekly** backup for the past 4 weeks
-   One **monthly** backup for the past 6 months
-   One **yearly** backup for each of the last few years

This approach balances storage usage with the ability to restore older states if needed.

For security-related guidance on why longer retention matters (e.g., delayed attack detection),
see :ref:`Backup retention for security incidents <security-backups-time-plan>`.

..  index:: Backup; Location
..  _security-backup-location:

Where to store your backups
===========================

Backups are often created and stored on the same server as the TYPO3 instance.
This is convenient but risky: hardware failure or a server compromise could
destroy both the live site and the backups.

To reduce risk:

-   Copy backups to an external system
-   Prefer **pulling** backups from the TYPO3 server instead of pushing them
-   Ensure the external system is isolated from the production environment

External storage should also be physically separate to protect against events
like fire or flooding.

Check your hosting contract carefully. Even if backups are offered, they may
not be guaranteed or restorable. It is best practice to manage your own
backups and transfer them offsite regularly.

If you store backups on the production server, keep them **outside the web root**
to prevent public access. Sensitive data—such as credentials or personal
information—must never be downloadable via URL. Obscure folder names are not
a valid security measure.

..  _security-backups-further-considerations:

Encrypt and scale your backup strategy
======================================

More advanced backup strategies—such as incremental backups, geographic
distribution, and rotating snapshots—are possible and may be appropriate for
larger or high-availability projects. However, these approaches are beyond the
scope of this guide.

Because TYPO3 backups often contain sensitive information (such as backend user
accounts, configuration data, or customer records), it is strongly recommended
to encrypt backup files, especially when stored offsite or transferred across
networks.

..  attention::
    For mission-critical projects, treat backups as part of your overall
    security and disaster recovery strategy.
