:navigation-title: Restrict File Access

..  include:: /Includes.rst.txt
..  _security-restrict-access-server-level:

============================================
Restrict access to files at the server level
============================================

TYPO3 installations can either use a classic mode (non-Composer) or a
Composer-based approach. File access and web server configuration differ
significantly between these setups. This chapter outlines recommendations
for both cases.

..  contents:: Table of contents

..  _security-restrict-access-server-level-composer:

Composer-based installations
============================

For Composer-based TYPO3 installations, the public document root is typically
the :file:`public/` directory. All web-accessible files are
placed in this folder, while all sensitive and internal application files
(e.g., :file:`vendor/`, :file:`.git/`, configuration files) are stored outside
the document root by default.

This layout significantly reduces the risk of accidental exposure of
sensitive files, eliminating the need for complex blacklisting rules.

**Recommendations for Composer-based installations:**

-   Ensure the web server document root points to the :file:`public/`
    directory only.
-   Verify that all non-public files (e.g., :file:`composer.json`, :file:`.env`,
    :file:`vendor/`, :file:`config/`) are outside of this directory.
-   Keep your :file:`public/.htaccess` (Apache) or server config (NGINX/IIS)
    files updated to deny access to any critical files inside the public folder.
-   Store downloadable files that are only intended for authenticated users in
    `File storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages>`_
    located outside the document root. Deliver them programmatically to
    authenticated users, for example using extensions like
    :composer:`leuchtfeuer/secure-downloads`.

..  _security-restrict-access-server-level-classic:

Classic-mode installations
==========================

In classic TYPO3 installations (without Composer), all files are contained in the
web root directory. This increases the risk of accidental exposure of internal
files. For example, temporary files such as backups or logs may become
accessible unless explicitly protected.

**Restricting access to sensitive files**

Some experts recommend denying access to certain file types (e.g.,
:file:`.bak`, :file:`.tmp`, :file:`.sql`, :file:`.old`) using web server rules
like Apache's `FilesMatch` directive. This helps prevent downloads of
sensitive files that have accidentally been placed in the document root.

However, this is a workaround — not a real solution. The proper approach is to
ensure sensitive files are never stored in the web root at all. Blocking access
by file name patterns is unreliable, as future file names cannot be predicted.

..  _security-restrict-access-server-level-verification:

Verification of access restrictions in Classic-mode installations
-----------------------------------------------------------------

Administrators must *verify* that access to sensitive files is properly denied.
Attempting to access any of the following files should result in an HTTP `403`
error:

*   :samp:`https://example.org/.git/index`
*   :samp:`https://example.org/INSTALL.md`
*   :samp:`https://example.org/INSTALL.txt`
*   :samp:`https://example.org/ChangeLog`
*   :samp:`https://example.org/composer.json`
*   :samp:`https://example.org/composer.lock`
*   :samp:`https://example.org/vendor/autoload.php`
*   :samp:`https://example.org/typo3_src/Build/package.json`
*   :samp:`https://example.org/typo3_src/bin/typo3`
*   :samp:`https://example.org/typo3_src/INSTALL.md`
*   :samp:`https://example.org/typo3_src/INSTALL.txt`
*   :samp:`https://example.org/typo3_src/ChangeLog`
*   :samp:`https://example.org/typo3_src/vendor/autoload.php`
*   :samp:`https://example.org/typo3conf/system/settings.php`
*   :samp:`https://example.org/typo3conf/system/additional.php`
*   :samp:`https://example.org/typo3temp/var/log/`
*   :samp:`https://example.org/typo3temp/var/session/`
*   :samp:`https://example.org/typo3temp/var/tests/`
*   :samp:`https://example.org/typo3/sysext/core/composer.json`
*   :samp:`https://example.org/typo3/sysext/core/ext_tables.sql`
*   :samp:`https://example.org/typo3/sysext/core/Configuration/Services.yaml`
*   :samp:`https://example.org/typo3/sysext/extbase/ext_typoscript_setup.txt`
*   :samp:`https://example.org/typo3/sysext/extbase/ext_typoscript_setup.typoscript`
*   :samp:`https://example.org/typo3/sysext/felogin/Configuration/FlexForms/Login.xml`
*   :samp:`https://example.org/typo3/sysext/backend/Resources/Private/Language/locallang.xlf`
*   :samp:`https://example.org/typo3/sysext/backend/Tests/Unit/Utility/Fixtures/clear.gif`
*   :samp:`https://example.org/typo3/sysext/belog/Configuration/TypoScript/setup.txt`
*   :samp:`https://example.org/typo3/sysext/belog/Configuration/TypoScript/setup.typoscript`


..  _security-restrict-access-server-level-htaccess:

Apache and Microsoft IIS web servers
------------------------------------

In classic mode, TYPO3 automatically creates default web server config files
(:file:`.htaccess` for Apache, :file:`web.config` for IIS) to deny access to
common sensitive files and directories.

These blacklist-style rules require ongoing maintenance. Administrators should
regularly compare their config files with the TYPO3 reference templates:

*   :t3src:`install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
*   :t3src:`install/Resources/Private/FolderStructureTemplateFiles/root-web-config`

See :ref:`<maintain-htaccess>` for updating config files after major version
upgrades.

..  _security-restrict-access-server-level-nginx:

NGINX Web Servers configuration (both installation modes)
=========================================================

NGINX does not support `.htaccess` or similar per-directory configuration
so TYPO3 cannot install default protection automatically. Instead, administrators
must include appropriate deny rules in the virtual host configuration.

A sample configuration is provided by DDEV:

..  literalinclude:: _codesnippets/_nginx.config
    :language: plaintext
    :caption:  nginx-site-typo3.conf

This example is taken from `DDEV webserver config
<https://github.com/ddev/ddev/blob/6a7655c178f5961666bb9c9efd10442314f6749c/pkg/ddevapp/webserver_config_assets/nginx-site-typo3.conf>`_.
