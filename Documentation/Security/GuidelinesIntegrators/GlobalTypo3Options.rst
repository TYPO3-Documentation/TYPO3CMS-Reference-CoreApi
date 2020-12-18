.. include:: /Includes.rst.txt
.. index::
   pair: Security guidelines; Global TYPO3 configuration
   pair: Security guidelines; Debugging
.. _security-global-typo3-options:

==================================
Global TYPO3 configuration options
==================================

The following configuration options are accessible and changeable via
the Install Tool (recommended way) or directly in the file
:file:`typo3conf/LocalConfiguration.php`. The list below is in alphabetical
order - not in the order of importance (all are relevant but the usage
depends on your specific site and requirements).


displayErrors
=============

This configuration option controls whether PHP errors should be
displayed or not (information disclosure). Possible values are: `-1`, `0`,
`1` (integer) with the following meaning:

`-1`
   This overrides the PHP setting :php:`display_errors`.
   If :ref:`devIPmask <security-global-typo3-options-devIpMask>` matches the user's IP address the
   configured :php:`debugExceptionHandler` is used for exceptions,
   if not, `productionExceptionHandler` will be used. This is the default setting.

`0`
   This suppresses any PHP error messages, overrides the value of `exceptionalErrors`
   and sets it to `0` (no errors are turned into exceptions), the configured
   `productionExceptionHandler` is used as exception handler.

`1`
   This shows PHP error messages with the registered error handler.
   The configured `debugExceptionHandler` is used as exception handler.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']`


.. _security-global-typo3-options-devIpMask:

devIPmask
=========

Defines a comma-separated list of IP addresses which will allow
development-output to display (information disclosure). The :php:`debug()`
function will use this as a filter. Setting this to a blank value will
deny all (recommended for a production site). Setting this to `*`
will show debug messages to every client without any restriction
(definitely not recommended). The default value is `127.0.0.1,::1`
which means "localhost" only.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']``




fileDenyPattern
===============

The `fileDenyPattern` is a perl-compatible regular expression that (if
it matches a file name) will prevent TYPO3 from accessing or processing
this file (deny uploading, renaming, etc). For security reasons, PHP files
as well as Apache's :file:`.htaccess` file should be included in this regular
expression string. The default value is: :php:`\\.(php[3-7]?|phpsh|phtml|pht)(\\..*)?$|^\\.htaccess$`,
initially defined in constant :php:`FILE_DENY_PATTERN_DEFAULT`.

There are only a very few scenarios imaginable where it makes sense to
allow access to those files. In most cases backend users such as
editors must not have the option to upload/edit PHP files or other
files which could harm the TYPO3 instance when misused. Even if you
trust your backend users, keep in mind that a less-restrictive
`fileDenyPattern` would enable an attacker to compromise the system if
it only gained access to the TYPO3 backend with a normal, unprivileged user account.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileDenyPattern']`


lockIP / lockIPv6
=================

If a frontend or backend user logs into TYPO3, the user's session can be
locked to its IP address. The `lockIP` configuration for IPv4 and `lockIPv6` for IPv6 control how
many parts of the IP address have to match with the IP address used at
authentication time.

.. ATTENTION::

   IP locking breaks modern IPv6 setups because of the
   `Fast Fallback aka. Happy Eyeballs <https://en.wikipedia.org/wiki/Happy_Eyeballs>`__
   algorithm that can cause users to jump between IPv4 and IPv6
   arbitrarily. Enabling an IP lock should be a very conscious decision. Therefore,
   this is disabled by default.


Possible values for **IPv4** are: `0`, `1`, `2`, `3` or `4` (integer)
with the following meaning:

`0`
   Disable IP locking entirely.

`1`
   Only the first part of the IPv4 address needs to match, e.g. `123.xxx.xxx.xxx`.

`2`
   Only the first and second part of the IPv4 address need to match, e.g. `123.45.xxx.xxx`.

`3`
   Only the first, second and third part of the IPv4 address need to match, e.g. `123.45.67.xxx`.

`4`
   The complete IPv4 address has to match (e.g. `123.45.67.89`).

Possible values for **IPv6** are: `0`, `1`, `2`, `3`, `4`,  `5`,  `6`, `7`, `8` (integer)
with the following meaning:

`0`
   Disable IP locking entirely.

`1`
   Only the first block (16 bits) of the IPv6 address needs to match, e.g. `2001:`

`2`
   The first two blocks (32 bits) of the IPv6 address need to match, e.g. `2001:0db8`.

`3`
   The first three blocks (48 bits) of the IPv6 address need to match, e.g. `2001:0db8:85a3`

`4`
   The first four blocks (64 bits) of the IPv6 address need to match, e.g. `2001:0db8:85a3:08d3`

`5`
   The first five blocks (80 bits) of the IPv6 address need to match, e.g. `2001:0db8:85a3:08d3:1319`

`6`
   The first six blocks (96 bits) of the IPv6 address need to match, e.g. `2001:0db8:85a3:08d3:1319:8a2e`

`7`
   The first seven blocks (112 bits) of the IPv6 address need to match, e.g. `2001:0db8:85a3:08d3:1319:8a2e:0370`

`8`
   The full IPv6 address has to match, e.g. `2001:0db8:85a3:08d3:1319:8a2e:0370:7344`

If your users experience that their sessions sometimes drop out, it
might be because of a changing IP address (this may happen with
dynamic proxy servers for example) and adjusting this setting could
address this issue. The downside of using a lower value than the default is a
decreased level of security.

Keep in mind that the `lockIP` and `lockIPv6` configurations are available for frontend
(:php:`['FE']['lockIP']` and :php:`['FE']['lockIPv6']`) and backend (:php:`['BE']['lockIP']`
and :php:`['BE']['lockIPv6']`) sessions separately, so four PHP variables are available:

* :php:`$GLOBALS['TYPO3_CONF_VARS']['FE']['lockIP']`

* :php:`$GLOBALS['TYPO3_CONF_VARS']['FE']['lockIPv6']`

* :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockIP']`

* :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockIPv6']`


.. _security-global-typo3-options-lockSSL:

lockSSL
=======

As described in :ref:`encrypted client/server communication
<security-encrypted-client-server-connection>`, the use of `https://` scheme
for the backend and frontend of TYPO3 drastically improves the security.
The `lockSSL` configuration controls if the backend can only be operated from a SSL-
encrypted connection (HTTPS). Possible values are: `true`, `false` (boolean)
with the following meaning:

* `false`: The backend is not forced to SSL locking at all (default value)

* `true`: The backend requires a secure connection HTTPS.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL']`


IPmaskList
==========

Some TYPO3 instances are maintained by a selected group of integrators
and editors who only work from a specific IP range or (in an ideal
world) from a specific IP address only. This could be for example an
office network with a static public IP address. In this case, or in
any case where client's IP addresses are predictable, the `IPmaskList`
configuration may be used to limit the access to the TYPO3 backend.

The string configured as `IPmaskList` is a comma-separated list of IP
addresses which are allowed to access the backend. The use of
wildcards is also possible to specify a network. The following example
opens the backend for users with the IP address `123.45.67.89` and from
the network `192.168.xxx.xxx`::

   [BE][IPmaskList] = 123.45.67.89,192.168.*.*

The default value is an empty string.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['IPmaskList']`


trustedHostsPattern
===================

TYPO3 uses the HTTP header `Host:` to generate absolute URLs in several
places such as 404 handling, http(s) enforcement, password reset links
and many more. Since the host header itself is provided by the client,
it can be forged to any value, even in a name based virtual hosts
environment.

The `trustedHostsPattern" configuration option can contain either the
value `SERVER_NAME` or a regular expression pattern that matches all
host names that are considered trustworthy for the particular TYPO3
installation. `SERVER_NAME` is the default value and with this option
value in effect, TYPO3 checks the currently submitted host-header
against the `SERVER_NAME` variable. Please see security bulletin
`TYPO3-CORE-SA-2014-001 <https://typo3.org/security/advisory/typo3-core-sa-2014-001/>`_
for further details about specific setups.

If the `Host:` header also contains a non-standard port, the
configuration must include this value, too. This is especially important
for the default value `SERVER_NAME` as provided ports are checked
against `SERVER_PORT` which fails in some more complex load balancing
or SSL termination scenarios.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern']``


.. _security-global-typo3-options-warning-email-addr:

warning_email_addr
==================

The email address defined here will receive notifications, whenever an
attempt to login to the Install Tool is made. TYPO3 will also send a
warning whenever more than three failed backend login attempts
(regardless of the user) are detected within one hour.

The default value is an empty string.

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['warning_email_addr']`


warning_mode
============

This setting specifies if mails should be sen to :ref:`warning_email_addr
<security-global-typo3-options-warning-email-addr>` upon successful backend user login.

The value in an integer:

`0`
   Do not send notification-emails upon backend-login (default)

`1`
   Send a notification-email every time a backend user logs in

`2`
   Send a notification-email every time an ADMIN backend user logs in

The PHP variable reads: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['warning_mode']`
