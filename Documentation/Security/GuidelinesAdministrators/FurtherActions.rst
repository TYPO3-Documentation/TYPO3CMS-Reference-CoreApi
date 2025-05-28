:navigation-title: Server environment

..  include:: /Includes.rst.txt
..  _security-administrators-furtheractions:

======================================
Server- and environment-level security
======================================

In addition to TYPO3-specific hardening, system administrators are also
responsible for maintaining a secure hosting environment, PHP configuration,
and monitoring systems. This section highlights complementary actions to
strengthen the overall security posture.

..  index:: pair: Security guidelines; Hosting environment
..  _security-admins-hosting:

Keep the hosting environment minimal and secure
===============================================

Administrators should maintain a minimal, secure server setup. Each service
(web, mail, database, DNS, etc.) is a potential attack vector. A compromise in
one component can endanger the entire environment, including TYPO3.

Best practices:

-   Disable unnecessary services
-   Keep all system software up to date, including PHP, the web server,
    database, and other services
-   Isolate systems where possible

A slim, well-maintained environment improves both performance and security.

If in-house server administration is not feasible, consider using a reputable
managed hosting provider that specializes in TYPO3 or PHP applications.

..  index:: pair: Security guidelines; PHP settings
..  _security-admins-php-settings:

Use secure PHP settings
=======================

TYPO3 runs on PHP, so secure PHP configuration is critical. Useful options
include:

-   `open_basedir` to restrict accessible directories
-   `disable_functions` to disable risky PHP functions

If you rely on external services and don't have `curl` support, you may need to
enable `allow_url_fopen`.

Be aware that blocking outbound traffic (e.g. via firewall) can prevent TYPO3
from retrieving extension updates or translation files.

..  index:: pair: Security guidelines; Log files
..  _security-admins-failed-logins:

Monitor failed backend logins
=============================

Failed backend logins and other security-related events are logged using the
TYPO3 logging framework.

Admins can configure a dedicated log file for authentication messages and use
external tools like `fail2ban <https://www.fail2ban.org>`_ to respond to
suspicious activity.

Example configuration:

..  literalinclude:: _codesnippets/_additional.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

..  index::
    pair: Security guidelines; Clickjacking
    pair: Security guidelines; X-Frame-Options
..  _security-administrators-furtheractions-clickjacking:

Protect against clickjacking
============================

Clickjacking tricks users into clicking hidden UI elements via transparent
layers or iframes. TYPO3 protects its backend by sending the HTTP header
`X-Frame-Options`, which blocks embedding backend pages in external domains
(see `RFC 7034 <https://datatracker.ietf.org/doc/html/rfc7034>`_).

To extend protection to the frontend, configure the web server:

..  literalinclude:: _codesnippets/_sameorigin.htaccess
    :language: apacheconf
    :caption: .htaccess (excerpt)

Explanation of header values:

-   `SAMEORIGIN`: Allow frames from the same origin only
-   `DENY`: Block all framing
-   `ALLOW-FROM [uri]`: Allow framing from a specific origin (less supported)
