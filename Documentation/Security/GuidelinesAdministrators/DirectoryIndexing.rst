.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Directory indexing
.. _security-directory-indexing:

==========================
Disable directory indexing
==========================

Depending on the operating system and distribution, Apache’s default configuration may have directory indexing enabled by default.

This allows search engines to index the file structure of your site and potentially 
reveal sensitive data. The screenshot below shows an example of the kind
data that can be retrieved with a simple HTTP request.

.. figure:: /Images/ManualScreenshots/Security/DirectoryIndexing.png
    :class: with-shadow
    :alt: Screenshot of an example directory index

In this example only the list of extensions are revealed, but more
sensitive data can also be exposed.

It is strongly recommended that you disable directory indexes.

If your web server requires directory indexing in other places
outside of your TYPO3 installation, you should consider deactivating the option globally
and only enable indexing on a case-by-case basis.


.. contents::
   :depth: 1
   :local:

Apache web server
===============

By removing the `Indexes` from `Options` (or not setting it in the first place),
Apache does not show the list of files and directories.

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

For Nginx, directory listing is handled by the `ngx_http_index_module` and
directory listing is disabled by default.

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

For IIS web servers, directory listing is also disabled by default.

It is possible to disable directory listing in the event it was enabled because of a
regression or a configuration change.

For IIS7 and above, it is possible to disable directory listing from the
:guilabel:`Directory Browsing` settings using the IIS manager console.

Alternatively, the following command can be used:

.. code-block:: shell
   :caption: command line

   appcmd set config /section:directoryBrowse /enabled:false
