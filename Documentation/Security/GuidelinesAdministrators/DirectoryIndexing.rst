:navigation-title: Directory indexing

..  include:: /Includes.rst.txt
..  index:: pair: Security guidelines; Directory indexing
..  _security-directory-indexing:

==========================
Disable directory indexing
==========================

Directory indexing allows web servers to list the contents of directories
when no default file (like `index.html`) is present. If enabled, it can
expose sensitive file structures to the public or search engines.

This section explains how to disable directory indexing for TYPO3 across
common web servers.

..  contents::
    :depth: 1
    :local:

..  _security-directory-indexing-apache:

Disable indexing in Apache (.htaccess)
======================================

This applies to Apache web servers, especially in shared hosting environments
where configuration is done via :file:`.htaccess` files.

In Apache, directory indexing is controlled by the `Indexes` flag within the
`Options` directive.

TYPO3's default :file:`.htaccess` disables indexing with the following setting:

..  code-block:: apacheconf
    :caption: /var/www/myhost/public/.htaccess

    <IfModule mod_autoindex.c>
      Options -Indexes
    </IfModule>

Alternatively, set this directly in your Apache site configuration:

..  code-block:: apacheconf
    :caption: /etc/apache2/sites-available/myhost.conf

    <IfModule mod_autoindex.c>
      <Directory /var/www/myhost/public>
         Options FollowSymLinks
      </Directory>
    </IfModule>

See the `Apache Options directive documentation <https://httpd.apache.org/docs/2.4/mod/core.html#options>`__
for more information.

..  _security-directory-indexing-nginx:

Disable indexing in Nginx (server block)
========================================

This applies to Nginx installations where settings are configured in the
server block (virtual host configuration).

Although directory listing is disabled by default in Nginx, you can explicitly
disable it by setting `autoindex off;`:

..  code-block:: nginx
    :caption: /etc/nginx/sites-available/myhost.com

    server {
      location /var/www/myhost/public {
         autoindex off;
      }
    }

..  _security-directory-indexing-iis:

Disable indexing in IIS (Windows Server)
========================================

This applies to IIS web servers on Windows Server systems.

Directory listing is disabled by default. If enabled, you can turn it off using
the IIS Manager:

-   Open the :guilabel:`Directory Browsing` settings
-   Set the feature to :guilabel:`Disabled`


Or use the command line:

..  code-block:: shell
    :caption: command line

    appcmd set config /section:directoryBrowse /enabled:false
