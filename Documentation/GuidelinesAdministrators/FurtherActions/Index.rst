.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _administrator-further-actions:

Further actions
^^^^^^^^^^^^^^^

A system administrator is usually responsible for the entirety of an
IT infrastructure. This includes several services (e.g. web server,
mail server, database server, SSH, FTP, DNS, etc.) on one or on
several servers. If one component is compromised, it is likely that
this opens holes to attack other services.

As a consequence, it is desired to secure all components of an IT
infrastructure and keep them up-to-date and secure with only a little
or no dependencies to other system. It is also wise to abandon
services which are not necessarily required (e.g. an additional
database server, DNS server, IMAP/POP3 server, etc.). In short words:
keep your hosting environment as slim as possible for performance and
security purposes.

Due to the fact that TYPO3 is a PHP application, secure PHP settings
are also important, of course. The myth, that the well-known "Safe
Mode" gives you the full-protection should be busted today. Depending
on your individual TYPO3 setup and the extensions you use, "Safe Mode"
might work but often problems occur with this configuration. Please be
aware of the fact that the "Safe Mode" feature has been deprecated as
of PHP version 5.3.0. Relying on this feature is highly discouraged.
Other PHP settings, such as "open\_basedir", "disable\_functions" and
the use of protection systems such as Suhosin ( `http://www.hardened-
php.net/suhosin/ <http://www.hardened-php.net/suhosin/>`_ ) often
improve the security of your system and should be considered.

Note that disallowing remote connections (e.g. by deactivating
"allow\_url\_fopen" or by blocking outgoing traffic on a firewall in
front of the TYPO3 server) may have an impact on the retrieval of the
TYPO3 extension list, which allows you to check if extension updates
are available!

Please understand that detailed descriptions of further actions on a
server-level and specific PHP security settings are out of scope of
this document. The TYPO3 Security Guide focuses on security aspects of
TYPO3.

