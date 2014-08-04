.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _global-typo3-options:

Global TYPO3 configuration options
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The following configuration options are accessible and changeable via
the Install Tool (recommended way) or directly in the file
"typo3conf/LocalConfiguration.php" (named "localconf.php" in TYPO3
versions prior 6.0). The list below is in alphabetical order -
not in the order of importance (all are relevant but the usage depends
on your specific site and requirements).


.. _cookieHttpOnly:

cookieHttpOnly
""""""""""""""

In order to make the session cookie only accessible through the HTTP
protocol, "cookieHttpOnly" is enabled by default since TYPO3 CMS 6.2.
This means, that the cookies "fe_typo_user" and "be_typo_user" are not
be accessible by scripting languages (e.g. JavaScript), which hardens
the protection against XSS attacks (cross site scripting). Although,
some older browsers do not support this technique.

Possible values are: 0 or 1 (boolean), where "0" deactivates the
option (TYPO3 CMS before 6.2) and "1" enables it (default since TYPO3
6.2).

The PHP variable reads: $TYPO3\_CONF\_VARS['SYS']['cookieHttpOnly']


.. _cookiesecure:

cookieSecure
""""""""""""

This configuration should be used in combination with "lockSSL", see
below. It indicates that the cookie should only be transmitted over a
secure HTTPS connection between client and server. Possible values
are: 0, 1 and 2 (integer) with the following meaning:

0 = a cookie is always sent, independently from which protocol is used
currently. This is the default setting.

1 = The cookie will only be set if a secure connection exists (HTTPS).
Use this in combination with "lockSSL" since otherwise the application
will fail and throw an exception.

2 = The cookie will be set in each case, but uses the secure flag if a
secure (HTTPS) connection exists.

The PHP variable reads: $TYPO3\_CONF\_VARS['SYS']['cookieSecure']


.. _displayerrors:

displayErrors
"""""""""""""

This configuration option controls whether PHP errors should be
displayed or not (information disclosure). Possible values are: -1, 0,
1, 2 (integer) with the following meaning:

-1 = This overrides the PHP setting "display\_errors". If devIPmask
matches the user's IP address the configured "debugExceptionHandler"
is used for exceptions, if not "productionExceptionHandler" will be
used. This is the default setting.

0 = This suppresses any PHP error messages, overrides the value of
"exceptionalErrors" and sets it to 0 (no errors are turned into
exceptions), the configured "productionExceptionHandler" is used as
exception handler.

1 = This shows PHP error messages with the registered error handler.
The configured "debugExceptionHandler" is used as exception handler.

2 = This displays errors only if client matches "devIPmask". If
devIPmask matches the user's IP address the configured
"debugExceptionHandler" is used for exceptions, if not
"productionExceptionHandler" will be used.

The PHP variable reads: $TYPO3\_CONF\_VARS['SYS']['displayErrors']


.. _devipmask:

devIPmask
"""""""""

Defines a comma-separated list of IP addresses which will allow
development-output to display (information disclosure). The debug()
function will use this as a filter. Setting this to a blank value will
deny all (recommended for a production site). Setting this to "\*"
will show debug messages to every client without any restriction
(definitely not recommended). The default value is "127.0.0.1,::1"
which means "localhost" only.

The PHP variable reads: $TYPO3\_CONF\_VARS['SYS']['devIPmask']


.. _enablebeuseriplock:

enabledBeUserIPLock
"""""""""""""""""""

If this configuration is enabled (value "1"), backend user accounts
can be locked to specific IP addresses by using user/group TSconfig.
Possible values are: 0 or 1 (boolean), where "0" deactivates the
option and "1" enables it (default).

In order to lock a specific user to the IP address 123.45.67.89, add
the following TSconfig to the backend user's TSconfig field::

   option.lockToIP = 123.45.67.89

The use of wildcards is also possible to specify a network instead –
please see TSconfig documentation for further explanations on how to
use the "lockToIP" option.

The PHP variable reads:
$TYPO3\_CONF\_VARS['BE']['enabledBeUserIPLock']


.. _filedenypattern:

fileDenyPattern
"""""""""""""""

The "fileDenyPattern" is a perl-compatible regular expression that (if
it matches a file name) will prevent TYPO3 CMS from accessing or
processing this file (deny uploading, renaming, etc). For security
reasons, PHP files as well as Apache's ".htaccess" file should be
included in this regular expression string. The default value is:
"\.(php[3-6]?\|phpsh\|phtml)(\..\*)?$\|^\.htaccess$" (initially
defined in constant FILE\_DENY\_PATTERN\_DEFAULT).

There are only a very few scenarios imaginable where it makes sense to
allow access to those files. In most cases backend users such as
editors must not have the option to upload/edit PHP files or other
files which could harm the TYPO3 CMS instance when misused. Even if you
trust your backend users, keep in mind that a less-restrictive
"fileDenyPattern" would enable an attacker to compromise the system if
he/she only gained access to the TYPO3 CMS backend with a normal,
unprivileged user account.

The PHP variable reads: $TYPO3\_CONF\_VARS['BE']['fileDenyPattern']


.. _lockip:

lockIP
""""""

If a frontend or backend user logs into TYPO3 CMS, the user's session is
locked to his/her IP address. The "lockIP" configuration controls how
many parts of the IP address have to match with the IP address used at
authentication time. Possible values are: 0, 1, 2, 3 or 4 (integer)
with the following meaning:

0 = disable IP locking at all (not recommended).

1 = only the first part of the IP address needs to match (e.g.
123.xxx.xxx.xxx).

2 = only the first and second part of the IP address need to match
(e.g. 123.45.xxx.xxx).

3 = only the first, second and third part of the IP address need to
match (e.g. 123.45.67.xxx).

4 = the complete IP address has to match (e.g. 123.45.67.89). This is
the default and recommended setting.

If your users experience that their sessions sometimes drop out, it
might be because of a changing IP address (this may happen with
dynamic proxy servers for example) and adjusting this setting could
address this issue. The downside of using a lower value than "4" is a
decreased level of security.

Keep in mind that the "lockIP" configuration is available for frontend
("[FE][lockIP]") and backend ("[BE][lockIP]") sessions separately, so
two PHP variables are available:

$TYPO3\_CONF\_VARS['FE']['lockIP']

$TYPO3\_CONF\_VARS['BE']['lockIP']


.. _lockssl:

lockSSL
"""""""

As described in section "encrypted client/server communication"
(chapter "Guidelines for System Administrators") above, the use of SSL
for the backend of TYPO3 CMS improves the security. The "lockSSL"
configuration controls if the backend can only be operated from a SSL-
encrypted connection (HTTPS). Possible values are: 0, 1, 2 or 3
(integer) with the following meaning:

0 = The backend is not forced to SSL locking at all (default value)

1 = The backend requires a secure connection HTTPS.

2 = Users trying to access unencrypted admin-URLs will be redirected
to encrypted SSL URLs instead.

3 = Only the login is forced to SSL. After then, the user switches
back to non-SSL-mode.

The PHP variable reads: $TYPO3\_CONF\_VARS['BE']['lockSSL']


.. _ipmasklist:

IPmaskList
""""""""""

Some TYPO3 CMS instances are maintained by a selected group of integrators
and editors who only work from a specific IP range or (in an ideal
world) from a specific IP address only. This could be for example an
office network with a static public IP address. In this case, or in
any case where client's IP addresses are predictable, the "IPmaskList"
configuration may be used to limit the access to the TYPO3 CMS backend.

The string configured as "IPmaskList" is a comma-separated list of IP
addresses which are allowed to access the backend. The use of
wildcards is also possible to specify a network. The following example
opens the backend for users with the IP address 123.45.67.89 and from
the network "192.168.xxx.xxx"::

   [BE][IPmaskList] = 123.45.67.89,192.168.*.*

The default value is an empty string.

The PHP variable reads: $TYPO3\_CONF\_VARS['BE']['IPmaskList']


.. _nophpscriptinclude:

noPHPscriptInclude
""""""""""""""""""

TypoScript configurations can be used to include arbitrary files, such
as PHP scripts. PHP scripts should be treated with special caution
because they could contain malicious code which can be executed by
TypoScript as well. The "noPHPscriptInclude" directive addresses this
risk and offers the option to prevent the inclusion of PHP scripts,
except if they reside in one of the allowed paths, such as:

- the globally installed extension directory: typo3/ext/
- the locally installed extension directory: typo3conf/ext/
- the system extension directory: typo3/sysext/

Possible values are: 0 or 1 (boolean), where "0" deactivates the
option and "1" enables it (prevents the inclusion of PHP scripts). The
default value is an empty value which reflects "0".

The PHP variable reads: $TYPO3\_CONF\_VARS['FE']['noPHPscriptInclude']


.. _trustedHostsPattern:

trustedHostsPattern
"""""""""""""""""""

TYPO3 uses the HTTP header "Host:" to generate absolute URLs in several
places such as 404 handling, http(s) enforcement, password reset links
and many more. Since the host header itself is provided by the client,
it can be forged to any value, even in a name based virtual hosts
environment.

The "trustedHostsPattern" configuration option can contain either the
value *SERVER_NAME* or a regular expression pattern that matches all
host names that are considered trustworthy for the particular TYPO3
installation. "SERVER_NAME" is the default value and with this option
value in effect, TYPO3 checks the currently submitted host-header
against the SERVER_NAME variable. Please see security bulletin
`TYPO3-CORE-SA-2014-001 <http://typo3.org/teams/security/security-bulletins/typo3-core/typo3-core-sa-2014-001/>`_
for further details about specific setups.

If the "Host:" header also contains a non-standard port, the
configuration must include this value, too. This is especially important
for the default value "SERVER_NAME" as provided ports are checked
against SERVER_PORT which fails in some more complex load balancing
or SSL termination scenarios.

The PHP variable reads: $TYPO3\_CONF\_VARS['SYS']['trustedHostsPattern']


.. _warningemailaddr:

warning_email_addr
""""""""""""""""""

The email address defined here will receive notifications, whenever an
attempt to login to the Install Tool is made. TYPO3 will also send a
warning whenever more than three failed backend login attempts
(regardless of the user) are detected within one hour.

The default value is an empty string.

The PHP variable reads: $TYPO3\_CONF\_VARS['FE']['warning_email_addr']


.. _warningmode:

warning_mode
""""""""""""

Here you can set an integer. If the first bit is set to 1,
warning_email_addr (see above) will be notified every time a backend
user logs in. If the first bit is not set and the second bit is set,
an email is only sent every time an *administrator* backend user logs
in.

The default value is an empty string.

The PHP variable reads: $TYPO3\_CONF\_VARS['FE']['warning_mode']

