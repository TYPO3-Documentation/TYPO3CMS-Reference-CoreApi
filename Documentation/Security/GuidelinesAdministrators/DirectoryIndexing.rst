.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Directory indexing
.. _security-directory-indexing:

==================
Directory indexing
==================

Depending on the operating system and distribution, the default
configuration of Apache allows the indexing of directories. This
enables search engines to index your file structure and possibly
reveals sensitive data. The screenshot below shows an example of such
data that can be retrieved with a simple HTTP request.

.. figure:: ../../Images/Security/directory-indexing.png
    :class: with-shadow
    :alt: Screenshot of an example directory index

In this case only the list of extensions is revealed, but more
sensitive data can be found easily. The Apache configuration allows
you to enable or disable the indexing of directories by the `Options`
directive as shown in the following example::

   <Directory /path/to/your/webroot/>
     Options Indexes FollowSymLinks
   </Directory>

By removing the `Indexes` option, Apache does not show the list of
files and directories. Please note that the `Options` directive can be
used in several containers (e.g. `<VirtualHost>`, `<Directory>`,
`<Location>`, etc.). The correct configuration could look like the
following example::

   <Directory /path/to/your/webroot/>
     Options FollowSymLinks
   </Directory>

If your specific website requires directory indexing at other places
outside TYPO3, you should consider to deactivate this option in
general but explicitly allow indexing for the required directories
only.

Other web servers such as Microsoft Internet Services (IIS) allow
similar configurations. See your web server's manual for further
details on how to disable directory indexing.

