.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Directory indexing
.. _security-directory-indexing:

==========================
Disable directory indexing
==========================

Depending on the operating system and distribution, the default
configuration of Apache allows the indexing of directories. This
enables search engines to index your file structure and possibly
reveals sensitive data. The screenshot below shows an example of such
data that can be retrieved with a simple HTTP request.

.. figure:: /Images/ManualScreenshots/Security/DirectoryIndexing.png
    :class: with-shadow
    :alt: Screenshot of an example directory index

In this case only the list of extensions is revealed, but more
sensitive data can be found easily.

An appropriate counter measure is to disable directory indexes.

If your specific website requires directory indexing at other places
outside TYPO3, you should consider to deactivate this option in
general but explicitly allow indexing for the required directories
only.


.. contents::
   :depth: 1
   :local:

Apache webserver
================

By removing the `Indexes` from `Options` (or not setting it in the first place),
Apache web server does not show the list of files and directories.

In TYPO3, the default :file:`.htaccess` already contains the
directive to disable directory indexing. Check if the following is
in your :file:`.htaccess`:

.. code-block:: apacheconf
   :caption: /var/www/myhost/public/.htaccess

   # Make sure that directory listings are disabled.
   <IfModule mod_autoindex.c>
      Options -Indexes
   </IfModule>

This example, does not set all `Options`, it just removes `Indexes` from the
list of Options. Directory indexing is provided by the module `autoindex`.
By setting the options this way, it will be disabled in any case, even if the
module is currently not active but might be activated at a later time.

It is also possible, to configure the `Options` in the Apache configuration,
for example:

.. code-block:: apacheconf
   :caption: /etc/apache2/sites-available/myhost.conf

   <IfModule mod_autoindex.c>
      <Directory /var/www/myhost/public>
         # override all Options, do not activate Indexes for security reasons
         Options FollowSymLinks
      </Directory>
   </IfModule>

Please note that the `Options` directive can be
used in several containers (for example `<VirtualHost>`, `<Directory>`,
in the Apache configuration) or in the file :file:`.htaccess`.
Refer to the `Options <https://httpd.apache.org/docs/2.4/mod/core.html#options>`__
directive for more information.

Nginx
=====

For Nginx, directory listing is handled by the `ngx_http_index_module`.
Directory listing is disabled by default.

You can explicitly disable directory listing by using the parameter
`autoindex`.

.. code-block:: nginx
   :caption: /etc/nginx/sites-available/myhost.com

   server {
      # ...

      location /var/www/myhost/public {
         autoindex off;
      }
   }

IIS
===

For IIS web server, directory listing is disabled by default.

It is possible to disable directory listing in case it was enabled because of a
regression or configuration changes.

For IIS7 and above, it is possible to disable directory listing from the
:guilable:`Directory Browsing` settings using the IIS manager console.

Alternatively, the following command can be used:

.. code-block:: shell
   :caption: command line

   appcmd set config /section:directoryBrowse /enabled:false
