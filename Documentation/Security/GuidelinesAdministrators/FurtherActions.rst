.. include:: /Includes.rst.txt
.. _security-administrators-furtheractions:

===============
Further Actions
===============


.. index:: pair: Security guidelines; Hosting environment

Hosting environment
===================

A system administrator is usually responsible for the entirety of an
IT infrastructure. This includes several services (e.g. web server,
mail server, database server, SSH, DNS, etc.) on one or on
several servers. If one component is compromised, it is likely that
this opens holes to attack other services.

As a consequence, it is desired to secure all components of an IT
infrastructure and keep them up-to-date and secure with only a little
or no dependencies to other system. It is also wise to abandon
services which are not necessarily required (e.g. an additional
database server, `DNS` server, `IMAP/POP3` server, etc.). In short words:
keep your hosting environment as slim as possible for performance and
security purposes.


.. index:: pair: Security guidelines; PHP settings

Security-related PHP settings
=============================

Due to the fact that TYPO3 is a PHP application, secure PHP settings
are also important, of course. PHP settings, such as `open_basedir`,
`disable_functions` often improve the security of your system and should be considered.

In use cases where you rely on outbound connections and your php comes without support
for curl it might be required to set `allow_url_fopen` to true.

Note that disallowing remote connections (e.g. by blocking outgoing traffic on a firewall in
front of the TYPO3 server) may have an impact on the retrieval of the
TYPO3 extension list, which allows you to check if extension updates
are available, or on retrival of translation files.


Events in Log Files
===================

Login attempts to the TYPO3 backend, which are unsuccessful, result in
a server response to the client with HTTP code 401 ("Unauthorized").
Due to the fact that this incident is logged in the web server's
error log file, it can be handled by external tools, such as
`fail2ban <http://www.fail2ban.org>`_.

.. index::
   pair: Security guidelines; Clickjacking
   pair: Security guidelines; X-Frame-Options
.. _security-administrators-furtheractions-clickjacking:


Defending Against Clickjacking
==============================

Clickjacking, also known as *user interface (UI) redress attack* or
*UI redressing*, is an attack scenario where an attacker tricks a web
user into clicking on a button or following a link different from what
the user believes he/she is clicking on. This attack can be typically
achieved by a combination of stylesheets and iframes, where multiple
transparent or opaque layers manipulate the visual appearance of a HTML
page.

To protect the backend of TYPO3 against this attack vector, a HTTP
header `X-Frame-Options` is sent, which prevents embedding backend pages
in an iframe on domains different than the one used to access the
backend. The `X-Frame-Options` header has been officially standardized as
`RFC 7034 <http://tools.ietf.org/html/rfc7034>`_.

System administrators should consider enabling this feature at the
frontend of the TYPO3 website, too. A configuration of the Apache
web server would typically look like the following::

   <IfModule mod_headers.c>
     Header always append X-Frame-Options SAMEORIGIN
   </IfModule>

The option `SAMEORIGIN` means, that the page can only be displayed in
a frame on the same origin as the page itself. Other options are `DENY`
(page cannot be displayed in a frame, regardless of the site attempting
to do so) and `ALLOW-FROM [uri]`` (page can only be displayed in a frame
on the specified origin).

Please understand that detailed descriptions of further actions on a
server-level and specific PHP security settings are out of scope of
this document. The TYPO3 Security Guide focuses on security aspects of
TYPO3.
