.. include:: /Includes.rst.txt
.. index::
   Security guidelines; Restrict file access
   Security guidelines; Web servers
.. _security-restrict-access-server-level:

==========================================
Restrict access to files on a server-level
==========================================

This is a controversial topic: Some experts recommend to restrict the
access to specific files on a server-level by using `Apache`:pn: 's
`FilesMatch` directive for example. Such files could be files with the
endings :file:`.bak`, :file:`.tmp`, :file:`.sql`, :file:`.old`, etc. in their
file names. The purpose of this restriction is, that even if backup files or
database dump files are accidentally stored in the DocRoot directory of the
web server, they cannot be downloaded.

The downside of this measure is, that this is not the solution of the
problem but a workaround only. The right recommendation would be not
to store sensitive files (such as backups, etc.) in the DocRoot
directory at all – instead of trying to address the issue by
restricting the access to certain file names (keep in mind that you
cannot predict which file names could occur in the future).


Verification of access restrictions
===================================

Administrators should *test and verify* file access to these files are actually denied.
The following list provides some files as an example that should not be retrievable
directly by using HTTP requests:

* `https://my.domain/.git/index`
* `https://my.domain/INSTALL.md`
* `https://my.domain/INSTALL.txt`
* `https://my.domain/ChangeLog`
* `https://my.domain/composer.json`
* `https://my.domain/composer.lock`
* `https://my.domain/vendor/autoload.php`
* `https://my.domain/typo3_src/Build/package.json`
* `https://my.domain/typo3_src/bin/typo3`
* `https://my.domain/typo3_src/INSTALL.md`
* `https://my.domain/typo3_src/INSTALL.txt`
* `https://my.domain/typo3_src/ChangeLog`
* `https://my.domain/typo3_src/vendor/autoload.php`
* `https://my.domain/typo3conf/LocalConfiguration.php`
* `https://my.domain/typo3conf/AdditionalConfiguration.php`
* `https://my.domain/typo3temp/var/log/`
* `https://my.domain/typo3temp/var/session/`
* `https://my.domain/typo3temp/var/tests/`
* `https://my.domain/typo3/sysext/core/composer.json`
* `https://my.domain/typo3/sysext/core/ext_tables.sql`
* `https://my.domain/typo3/sysext/core/Configuration/Services.yaml`
* `https://my.domain/typo3/sysext/extbase/ext_typoscript_setup.txt`
* `https://my.domain/typo3/sysext/extbase/ext_typoscript_setup.typoscript`
* `https://my.domain/typo3/sysext/felogin/Configuration/FlexForms/Login.xml`
* `https://my.domain/typo3/sysext/backend/Resources/Private/Language/locallang.xlf`
* `https://my.domain/typo3/sysext/backend/Tests/Unit/Utility/Fixtures/clear.gif`
* `https://my.domain/typo3/sysext/belog/Configuration/TypoScript/setup.txt`
* `https://my.domain/typo3/sysext/belog/Configuration/TypoScript/setup.typoscript`

The list above is probably not complete. However, if general deny rules are in place links
provided above should not be accessible anymore and result in a HTTP `403` error response.


`Apache`:pn: and Microsoft IIS web servers
==========================================

To increase protection of TYPO3 instances, the `Core Team`:pn: however decided to
install default web server configuration files since `TYPO3 Core`:pn: version v9 under certain
circumstances: If an `Apache`:pn: web server is detected by the web based installation
procedure, a default :file:`.htaccess` file is written to the document root, and if
a Microsoft IIS web server is detected, a default :file:`web.config` file is written
to the document root. These files contain web server configurations to deny direct web
access to a series of common file types and directories, for instance version control system
directories like :file:`.git/`, all private template directories like :file:`Resources/Private/`
and common package files like :file:`composer.json`.


This "black list" approach needs maintenance: The `Core Team`:pn: tries to keep the template files
:file:`.htaccess` and :file:`web.config` updated. If running `Apache`:pn: or IIS, administrators
should compare their specific version with the reference files found at `root-htaccess
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess>`_
and `root-web-config
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-web-config>`_
and adapt or update local versions if needed.


`nginx`:pn: web servers
=======================

Administrators running the popular web server `NGINX <https://www.nginx.com/>`_ need to
take additional measures: `nginx`:pn: does not support an approach like `Apache`:pn: or IIS to configure
access by putting files into the web document directories - the TYPO3 install procedure can
not install good default files and administrators must merge deny patterns into the web
servers virtual host configuration. A typical example looks like this::

    server {

        ...

        # Prevent clients from accessing hidden files (starting with a dot)
        # This is particularly important if you store .htpasswd files in the site hierarchy
        # Access to `/.well-known/` is allowed.
        # https://www.mnot.net/blog/2010/04/07/well-known
        # https://tools.ietf.org/html/rfc5785
        location ~* /\.(?!well-known\/) {
            deny all;
        }

        # Prevent clients from accessing to backup/config/source files
            location ~* (?:\.(?:bak|conf|dist|fla|in[ci]|log|psd|sh|sql|sw[op])|~)$ {
            deny all;
        }

        # TYPO3 - Block access to composer files
        location ~* composer\.(?:json|lock) {
            deny all;
        }

        # TYPO3 - Block access to flexform files
        location ~* flexform[^.]*\.xml {
            deny all;
        }

        # TYPO3 - Block access to language files
        location ~* locallang[^.]*\.(?:xml|xlf)$ {
            deny all;
        }

        # TYPO3 - Block access to static typoscript files
        location ~* ext_conf_template\.txt|ext_typoscript_constants\.(?:txt|typoscript)|ext_typoscript_setup\.(?:txt|typoscript) {
            deny all;
        }

        # TYPO3 - Block access to miscellaneous protected files
        location ~* /.*\.(?:bak|co?nf|cfg|ya?ml|ts|typoscript|dist|fla|in[ci]|log|sh|sql)$ {
            deny all;
        }

        # TYPO3 - Block access to recycler and temporary directories
        location ~ _(?:recycler|temp)_/ {
            deny all;
        }

        # TYPO3 - Block access to configuration files stored in fileadmin
        location ~ fileadmin/(?:templates)/.*\.(?:txt|ts|typoscript)$ {
            deny all;
        }

        # TYPO3 - Block access to libaries, source and temporary compiled data
        location ~ ^(?:vendor|typo3_src|typo3temp/var) {
            deny all;
        }

        # TYPO3 - Block access to protected extension directories
        location ~ (?:typo3conf/ext|typo3/sysext|typo3/ext)/[^/]+/(?:Configuration|Resources/Private|Tests?|Documentation|docs?)/ {
            deny all;
        }

        ...

    }

The config example above has been taken from `ddev
<https://github.com/drud/ddev/blob/f2171f390a3af8d4a85954105e8aa68b8bcab5ac/containers/ddev-webserver/files/etc/nginx/nginx-site-typo3.conf>`_.
