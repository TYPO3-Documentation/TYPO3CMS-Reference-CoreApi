.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _restrict-access-server-level:

Restrict access to files on a server-level
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This is a controversial topic: some experts recommend to restrict the
access to specific files on a server-level by using Apache's
"FilesMatch" directive for example. Such files could be files with the
endings ".bak", ".tmp", ".sql", ".old", etc. in their file names. The
purpose of this restriction is, that even if backup files or database
dump files are accidentally stored in the DocRoot directory of the web
server, they cannot be downloaded.

The downside of this measure is, that this is not the solution of the
problem but a workaround only. The right recommendation would be not
to store sensitive files (such as backups, etc.) in the DocRoot
directory at all – instead of trying to address the issue by
restricting the access to certain file names (keep in mind that you
cannot predict which file names could occur in the future).

