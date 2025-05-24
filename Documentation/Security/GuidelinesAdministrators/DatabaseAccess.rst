:navigation-title: Database access

..  include:: /Includes.rst.txt
..  index:: pair: Security guidelines; Database access
..  _security-database-access:

======================
Secure database access
======================

The TYPO3 database stores all user data (both backend and frontend), along with
critical configuration and content. It is essential to protect this data from
unauthorized access.

These recommendations apply to both self-managed and shared hosting environments.

If you are using managed or shared hosting, you may not be responsible for
configuring the database yourself. However, it is still important to ensure
that your TYPO3 installation uses a dedicated database user with limited
permissions. If you are unsure, ask your hosting provider whether the database
user has access only to your TYPO3 database and is restricted to the minimum
required privileges.

..  contents:: Table of contents

..  index::
    Database; Secure passwords
    Database; Access privileges

.. _security-database-git:

Do not store credentials in version control
===========================================

Database credentials and other sensitive information should never be stored in
Git or any other version control system.

For example, do not commit files such as:

-   :file:`.env`
-   :file:`config/system/settings.php` (if it contains credentials directly)

Exposing credentials publicly, or even within internal team repositories,
creates unnecessary risk.

**Recommendation:** Use environment-specific configuration and exclude
credential files from version control using mechanisms like :file:`.gitignore`.

For more information and best practices, see:
:ref:`Avoid storing credentials in version control <t3coreapi:version-control-credentials>`.

..  _security-database-mysql-access:

Use strong passwords and limit privileges
=========================================

When using MySQL, database users must authenticate before connecting.
Permissions are granted at various levels (for example, per database,
per table, or per action such as SELECT or INSERT).

**Best practices:**

-   Use a secure password for the TYPO3 database user. See
    :ref:`secure password guidelines <security-secure-passwords>`.
-   Do **not** use obvious usernames like `root`, `admin`, or `typo3`.
-   Create a dedicated user with **access only to the TYPO3 database**, and only
    with the permissions it requires (SELECT, INSERT, UPDATE, DELETE, etc.).
-   Avoid granting administrative privileges such as `LOCK TABLES`, `FILE`,
    `PROCESS`, `RELOAD`, or `SHUTDOWN` unless absolutely necessary.

..  index::
    Database; SQLite
    pair: Security guidelines; SQLite

..  _security-database-sqlite:

Keep SQLite files out of the web root
=====================================

SQLite stores the database in a single file. By default, TYPO3 places this file
in the :ref:`var/sqlite <Environment-var-path>` directory, derived from the
:php:`TYPO3_PATH_APP` environment variable.

**Warning:** In non-Composer installations, if :php:`TYPO3_PATH_APP` is not set,
the SQLite file may be created in :file:`typo3conf/`, which is inside the web
server's document root and publicly accessible.

If you are using SQLite:

-   Ensure that `.sqlite` files are **not accessible via the web server**
-   Move the database file outside of the document root if possible

..  _security-database-restrict-access:

Restrict database server access
===============================

The database server should only accept connections from the TYPO3 application
host. It must never be exposed to the public internet.

**Recommended actions:**

-   Configure firewalls to block external access to the database port
-   Ensure the database server is bound only to `localhost` or a private network
-   For MySQL, review the options `skip-networking` and `bind-address` in the
    official documentation:
    `MySQL Server Options <https://dev.mysql.com/doc/refman/8.0/en/server-option-variable-reference.html>`_

..  index::
    pair: Security guidelines; Database administration tools
    pair: Security guidelines; phpMyAdmin

..  _security-database-admin-tools:

Avoid web-based database tools in production
============================================

Tools like `phpMyAdmin` provide web access to the database for administrative
tasks. While sometimes helpful during development, they increase the attack
surface in production environments.

If such tools must be used:

-   Protect them with additional access controls, such as HTTP authentication
    (for example, Apache `.htaccess`)
-   Keep them updated to patch known vulnerabilities

For local development or secure remote access, prefer standalone database
clients such as `HeidiSQL <https://www.heidisql.com/>`_, `DBeaver <https://dbeaver.io/>`_,
or `MySQL Workbench <https://www.mysql.com/products/workbench/>`_. These tools
connect directly to the database server and do not expose a web interface,
reducing the attack surface.

**Recommendation:** Do not use phpMyAdmin or similar tools on live TYPO3 sites.
All regular access to the database should be managed through TYPO3 or CLI tools.
