.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; File permissions
.. _security-file-directory-permissions:

==========================
File/directory permissions
==========================

..  todo: This describes the situation in legacy installations only

The correct and secure setup of the underlying server is an essential
prerequisite for a secure web application. Well-considered access
permissions on files and directories are an important part of this
strategy. However, too strict permissions may stop TYPO3 from working
properly and/or restrict integrators or editors from using all
features of the CMS. The section
:ref:`TYPO3 administration <t3coreapi:administration>`
provides further information about the install procedure.

We do not need to mention that only privileged system users should
have read/write access to files and directories inside the web root.
In most cases these are only users such as "root" and the user, that
the web server runs as (e.g. `www-data`). On some systems (e.g. shared
hosting environments), the web server user can be a specific user,
depending on the system configuration.

An important security measure for systems on which multiple users run
their websites (e.g. various clients on a shared server) is to ensure
that one user cannot access files in another client's web root. This
server misconfiguration of file/directory permissions may occur if all
virtual hosts run as the same user, for example the default web server
user. The risk with this setup is, that a script on another virtual
host includes files from the TYPO3 instance or writes or manipulates
files. The TYPO3 configuration file :file:`config/system/settings.php`, which
contains sensitive data, would be a typical example.

Besides the strict separation between multiple virtual hosts, it is
possible to revoke any write permissions for the web server user (e.g.
`www-data`) to the TYPO3 source directory in general. In other words:
only allow write access to resources, the web server user requires to
have write access for, such as :file:`fileadmin/`, :file:`typo3conf/`,
:file:`typo3temp/`.

On UNIX/Linux based systems, a secure configuration can be achieved by
setting the owner and group of directories and files correctly, as
well as their specific access rights (read/write/execute). Even if
users need write access to the :file:`fileadmin/` directory (besides the web
server user), this can be technically achieved.

It is not recommended to allow TYPO3 editors and other unprivileged
users FTP, SFTP, SSH, WebDAV, etc. access to the web server's root
directory or any sub-directory of it. See :ref:`other services <security-other-services>`
for further explanations.
