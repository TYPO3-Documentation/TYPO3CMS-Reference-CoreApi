.. include:: ../../Includes.txt


.. _backup-components:

Components included in the backups
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

To restore a TYPO3 CMS project you need to have a backup of at least the
following data directories:

- fileadmin

- typo3conf

- uploads

You do not need a backup of the "typo3temp/" directory, due to the
fact that all files are re-generated automatically if they do not
exist. Also a backup of the TYPO3 source code is not needed (unless
changes were made to the source code, which is not recommended). You
can always download the TYPO3 source packages from the TYPO3 website,
even for older versions of TYPO3.

In addition to the data directories listed above, a backup of the
database is required. For MySQL the command line tool "mysqldump" (or
"mysqldump.exe" for Microsoft Windows) is a good way to export the
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

