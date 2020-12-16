.. include:: /Includes.rst.txt
.. index::
   Backup
   pair: Security guidelines; Backup
.. _security-backups:

===============
Backup strategy
===============

Backups are usually in the responsibility of the system administrator.
Creating backups obviously does not improve the security of a TYPO3
site but they quickly become incredibly useful when you need to
restore a website after your site has been compromised or in the case
of a data loss.


.. index:: Backup; Components
.. _security-backup-components:

Components included in the backups
==================================

To restore a TYPO3 project you need to have a backup of at least the
following data directories:

* :file:`fileadmin`

* :file:`typo3conf`

.. note::
    The directory structure is not *that* fixed: Especially with
    modern `Composer` based instances, a separation of the :ref:`project root
    <Environment-project-path>`
    and the :ref:`web server document root <Environment-public-path>` can be achieved.
    This is recommended from a security point of view since critical parts of
    the TYPO3 instance can be located outside of the web document root and are then not
    directly accessible from the outside. Important parts are the :ref:`var path
    <Environment-var-path>` and the :ref:`config path <Environment-config-path>`
    - see :ref:`Environment API <Environment>` for details. The "config path" should
    be included in backups, while the "var path" could be left out since its content
    will be - with most instance configurations - recreated automatically if needed.

You do not need a backup of the :file:`typo3temp/` directory, due to the
fact that all files are re-generated automatically if they do not
exist. Also a backup of the TYPO3 source code is not needed (unless
changes were made to the source code, which is not recommended). You
can always download the TYPO3 source packages from the TYPO3 website,
even for older versions of TYPO3.

In addition to the data directories listed above, a backup of the
database is required. For MySQL the command line tool `mysqldump` (or
`mysqldump.exe` for Microsoft Windows) is a good way to export the
content of the database to a file without any manual interaction (e.g.
as an automated, scheduled system task).

Once a backup has been created, it should be verified that it is
complete and can be restored successfully. A good test is to restore a
backup of a TYPO3 project to a different server and then check the
site for any errors or missing data. In a perfect world, these restore
checks should be tested frequently to ensure that the concept works
and continues working over a time period. The worst case would be that
you rely on your backup concept and when you need to restore a backup
you notice that the concept has not worked for months.


.. index:: Backup; Time plan
.. _security-backups-time-plan:

Time plan and retention time
============================

In most cases you should create a backup once a day, typically at a
time when the server load is low. Rather than overwriting the backup
from the previous day you should create a new backup and delete older
copies from time to time. Just having a backup from last night is not
sufficient for recovery since it would require that you notice the
need for a restore within 24 hours. Here is an example for a good
backup strategy:

* keep one daily backup for each of the last 7 days

* keep one weekly backup for each of the last 4 weeks

* keep one monthly backup for each of the last 6 months

* keep one yearly backup for each year


.. index:: Backup; Location
.. _security-backup-location:

Backup location
===============

Backups are typically created on the same server as the TYPO3 instance
and often stored there as well. In this case, the backup files should
be copied to external systems to prevent data loss from a hardware
failure. If backups are only stored on the local system and an
attacker gains full control over the server, he might delete or tamper with
the backup files. Protecting the external systems against any access from
the TYPO3 server is also highly recommended, so you should consider
"fetching" the backups from the TYPO3 system instead of "pushing" them
to the backup system.

When external systems are used they should be physically separated
from the production server in order to prevent data loss due to fire,
flooding, etc.

Please read the terms and conditions for your contract with the
hosting provider carefully. Typically the customer is responsible for
the backup, not the provider. Even if the provider offers a backup,
there may be no guarantee that the backup will be available. Therefore
it is good practice to transfer backups to external servers in regular
intervals.

In case you are also storing backups on the production server, make
sure that they are placed outside of the root directory of your
website and cannot be accessed with a browser. Otherwise everybody
could simply download your backups, including sensitive data, such as
passwords (not revealing the URL is not a sufficient measure from a
security perspective).


.. _security-backups-further-considerations:

Further considerations
======================

More sophisticated backup strategies, such as incremental backups and
distributed backups over several servers, geographically separated and
rotating backups, etc. are also achievable but out of scope of this
document.

Due to the fact that website backups contain sensitive information
(backend user details, passwords, sometimes customer details, etc.) it
is highly recommended to consider the secure encryption for these
files.
