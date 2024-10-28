.. include:: /Includes.rst.txt

.. index:: apache

.. _troubleshooting-webserver:

==========
Web Server
==========

.. _troubleshooting-apache:

Apache
======

Some settings may require adjustment for TYPO3 to operate correctly This will vary depending on the host
operating system and the version of Apache that is installed.

.. _troubleshooting-enable-mod_rewrite:

Enable mod_rewrite
------------------

If mod_rewrite is not enabled, the URL handling will not work
properly (specifically the mapping of the URLs TYPO3 uses internally
for "speaking URLs") and you might receive 404 (page not found) errors.

.. tip::

   How Apache modules are enabled, depends on your system. Check the
   documentation for your operating system distribution.

For example, the modules can be
enabled by editing your :file:`http.conf` file, locating the required modules
and removing the preceding hash symbol:

.. code-block:: none
   :caption: http.conf

   #LoadModule expires_module modules/mod_expires.so
   #LoadModule rewrite_module modules/mod_rewrite.so


After making any changes to the Apache configuration, the service must be restarted.

.. _troubleshooting-adjust-threadstacksize-on-windows:

Adjust ThreadStackSize on Windows
---------------------------------

If you are running TYPO3 on Windows, the extension manager might not
render.

This problem is caused by the value of ThreadStackSize, which on
Windows systems by default is set too low. To fix this, add the
following lines at the end of your :file:`httpd.conf` file:

.. code-block:: none
   :caption: http.conf

   <IfModule mpm_winnt_module>
     ThreadStackSize 8388608
   </IfModule>
