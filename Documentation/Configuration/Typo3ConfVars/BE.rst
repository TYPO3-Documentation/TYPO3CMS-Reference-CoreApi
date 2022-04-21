.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; BE
.. _typo3ConfVars_be:

=================================
$GLOBALS['TYPO3_CONF_VARS']['BE']
=================================

.. index::
   TYPO3_CONF_VARS BE; fluidPageModule
.. _typo3ConfVars_be_fluidPageModule:

$GLOBALS['TYPO3_CONF_VARS']['BE']['fluidPageModule']
====================================================

.. confval:: fluidPageModule

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: true


.. index::
   TYPO3_CONF_VARS BE; languageDebug
.. _typo3ConfVars_be_languageDebug:

$GLOBALS['TYPO3_CONF_VARS']['BE']['languageDebug']
==================================================

.. confval:: languageDebug

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

   If enabled, language labels will be shown with additional debug information.


.. index::
   TYPO3_CONF_VARS BE; fileadminDir
.. _typo3ConfVars_be_fileadminDir:

$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir']
=================================================

.. confval:: fileadminDir

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: 'fileadmin/'

   Path to the primary directory of files for editors. This is relative to
   the public web dir. DefaultStorage will be created with that configuration.
   Do not access manually but via
   :php:`\TYPO3\CMS\Core\Resource\ResourceFactory::getDefaultStorage().`


.. index::
   TYPO3_CONF_VARS BE; lockRootPath
.. _typo3ConfVars_be_lockRootPath:

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath']
=================================================

.. confval:: lockRootPath

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   This path is used to evaluate if paths outside of the public web path should be
   allowed. Ending slash required!


.. index::
   TYPO3_CONF_VARS BE; userHomePath
.. _typo3ConfVars_be_userHomePath:

$GLOBALS['TYPO3_CONF_VARS']['BE']['userHomePath']
=================================================

.. confval:: userHomePath

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   Combined folder identifier of the directory where TYPO3 backend users have
   their home-dirs. A combined folder identifier looks like this:
   :php:`[storageUid]:[folderIdentifier]`. For Example :php:`2:users/`.
   A home for backend user 2 would be: :php:`2:users/2/`. Ending slash required!


.. index::
   TYPO3_CONF_VARS BE; groupHomePath
.. _typo3ConfVars_be_groupHomePath:

$GLOBALS['TYPO3_CONF_VARS']['BE']['groupHomePath']
==================================================

.. confval:: groupHomePath

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   Combined folder identifier of the directory where TYPO3 backend groups have
   their home-dirs. A combined folder identifier looks like this:
   :php:`[storageUid]:[folderIdentifier]`. For example :php:`2:groups/`.
   A home for backend group 1 would be: :php:`2:groups/1/`. Ending slash required!


.. index::
   TYPO3_CONF_VARS BE; userUploadDir
.. _typo3ConfVars_be_userUploadDir:

$GLOBALS['TYPO3_CONF_VARS']['BE']['userUploadDir']
==================================================

.. confval:: userUploadDir

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   Suffix to the user home dir which is what gets mounted in TYPO3. For example
   if the user dir is :file:`../123_user/`  and this value
   is :file:`/upload`  then :file:`../123_user/upload` gets mounted.

.. index::
   TYPO3_CONF_VARS BE; warning_email_addr
.. _typo3ConfVars_be_warning_email_addr:

$GLOBALS['TYPO3_CONF_VARS']['BE']['warning_email_addr']
=======================================================

.. confval:: warning_email_addr

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   Email address that will receive notifications whenever an attempt to
   login to the Install Tool is made. This address will also receive warnings
   whenever more than 3 failed backend login attempts (regardless of user)
   are detected within an hour.

.. index::
   TYPO3_CONF_VARS BE; warning_mode
.. _typo3ConfVars_be_warning_mode:

$GLOBALS['TYPO3_CONF_VARS']['BE']['warning_mode']
=================================================

.. confval:: warning_mode

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0
   :allowedValues:
      0:
         Default: Do not send notification-emails upon backend-login
      1:
         Send a notification-email every time a backend user logs in
      2:
         Send a notification-email every time an ADMIN backend user logs in

   Send emails to :php:`warning_email_addr`  upon backend-login

.. index::
   TYPO3_CONF_VARS BE; passwordReset
.. _typo3ConfVars_be_passwordReset:

$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordReset']
==================================================

.. confval:: passwordReset

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: true

   Enable password reset functionality on the backend login for TYPO3 Backend
   users. Can be disabled for systems where only LDAP or OAuth login is allowed.

   Password reset will then still work on CLI and for admins in the backend.

.. index::
   TYPO3_CONF_VARS BE; passwordResetForAdmins
.. _typo3ConfVars_be_passwordResetForAdmins:

$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordResetForAdmins']
===========================================================

.. confval:: passwordResetForAdmins

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: true

   Enable password reset functionality for TYPO3 Administrators. This will
   affect all places such as backend login or CLI. Disable this option for
   increased security.

.. index::
   TYPO3_CONF_VARS BE; requireMfa
.. _typo3ConfVars_be_requireMfa:

$GLOBALS['TYPO3_CONF_VARS']['BE']['requireMfa']
===============================================

.. confval:: requireMfa

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0
   :allowedValues:
      0:
         Default: Do not require multi-factor authentication
      1:
         Require multi-factor authentication for all users
      2:
         Require multi-factor authentication only for non-admin users
      3:
         Require multi-factor authentication only for admin users
      4:
         Require multi-factor authentication only for system maintainers

   Define users which should be required to set up multi-factor authentication.

.. index::
   TYPO3_CONF_VARS BE; recommendedMfaProvider
.. _typo3ConfVars_be_recommendedMfaProvider:

$GLOBALS['TYPO3_CONF_VARS']['BE']['recommendedMfaProvider']
===========================================================

.. confval:: recommendedMfaProvider

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: 'totp'

   Set the identifier of the multi-factor authentication provider, recommended
   for all users.


.. index::
   TYPO3_CONF_VARS BE; loginRateLimit
.. _typo3ConfVars_be_loginRateLimit:

$GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimit']
===================================================

.. confval:: loginRateLimit

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 5

   Maximum amount of login attempts for the time interval in
   :ref:`[BE][loginRateLimitInterval]<typo3ConfVars_be_loginRateLimitInterval>`,
   before further login requests will be denied. Setting this value to
   :php:`"0"` will disable login rate limiting.


.. index::
   TYPO3_CONF_VARS BE; loginRateLimitInterval
.. _typo3ConfVars_be_loginRateLimitInterval:

$GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimitInterval']
===========================================================

.. confval:: loginRateLimitInterval

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: string, PHP relative format
   :Default: '15 minutes'
   :allowedValues: '1 minute', '5 minutes', '15 minutes', '30 minutes'

   Allowed time interval for the configured rate limit. Individual values
   using
   `PHP relative formats <https://www.php.net/manual/de/datetime.formats.relative.php>`__
   can be set in :file:`AdditionalConfiguration.php`.


.. index::
   TYPO3_CONF_VARS BE; loginRateLimitIpExcludeList
.. _typo3ConfVars_be_loginRateLimitIpExcludeList:

$GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimitIpExcludeList']
================================================================

.. confval:: loginRateLimitIpExcludeList

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: string
   :Default: ''

   IP-numbers (with :php:`*`-wildcards) that are excluded from rate limiting.
   Syntax similar to :ref:`[BE][IPmaskList]<typo3ConfVars_be_IPmaskList>`.
   An empty value disables the exclude list check.


.. index::
   TYPO3_CONF_VARS BE; lockIP
.. _typo3ConfVars_be_lockIP:

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockIP']
===========================================

.. confval:: lockIP

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0
   :allowedValues:
      0:
         Default: Do not lock Backend User sessions to their IP address at all
      1:
         Use the first part of the editors IPv4 address (for example "192.") as part of the session locking of Backend Users
      2:
         Use the first two parts of the editors IPv4 address (for example "192.168") as part of the session locking of Backend Users
      3:
         Use the first three parts of the editors IPv4 address (for example "192.168.13") as part of the session locking of Backend Users
      4:
         Use the editors full IPv4 address (for example "192.168.13.84") as part of the session locking of Backend Users (highest security)

   Session IP locking for backend users. See :ref:`[FE][lockIP]<typo3ConfVars_fe_lockIP>` for details.

.. index::
   TYPO3_CONF_VARS BE; lockIPv6
.. _typo3ConfVars_be_lockIPv6:

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockIPv6']
=============================================

.. confval:: lockIPv6

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0
   :allowedValues:
      0:
         Default: Do not lock Backend User sessions to their IP address at all
      1:
         Use the first block (16 bits) of the editors IPv6 address (for example "2001:") as part of the session locking of Backend Users
      2:
         Use the first two blocks (32 bits) of the editors IPv6 address (for example "2001:0db8") as part of the session locking of Backend Users
      3:
         Use the first three blocks (48 bits) of the editors IPv6 address (for example "2001:0db8:85a3") as part of the session locking of Backend Users
      4:
         Use the first four blocks (64 bits) of the editors IPv6 address (for example "2001:0db8:85a3:08d3") as part of the session locking of Backend Users
      5:
         Use the first five blocks (80 bits) of the editors IPv6 address (for example "2001:0db8:85a3:08d3:1319") as part of the session locking of Backend Users
      6:
         Use the first six blocks (96 bits) of the editors IPv6 address (for example "2001:0db8:85a3:08d3:1319:8a2e") as part of the session locking of Backend Users
      7:
         Use the first seven blocks (112 bits) of the editors IPv6 address (for example "2001:0db8:85a3:08d3:1319:8a2e:0370") as part of the session locking of Backend Users
      8:
         Use the editors full IPv6 address (for example "2001:0db8:85a3:08d3:1319:8a2e:0370:7344") as part of the session locking of Backend Users (highest security)

   Session IPv6 locking for backend users. See :ref:`[FE][lockIPv6]<typo3ConfVars_fe_lockIPv6>` for details.

.. index::
   TYPO3_CONF_VARS BE; sessionTimeout
.. _typo3ConfVars_be_sessionTimeout:

$GLOBALS['TYPO3_CONF_VARS']['BE']['sessionTimeout']
===================================================

.. confval:: sessionTimeout

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 28800

   Session time out for backend users in seconds. The value must be at least 180 to avoid side effects. Default is 28.800 seconds = 8 hours.

.. index::
   TYPO3_CONF_VARS BE; IPmaskList
.. _typo3ConfVars_be_IPmaskList:

$GLOBALS['TYPO3_CONF_VARS']['BE']['IPmaskList']
===============================================

.. confval:: IPmaskList

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: list
   :Default: ''

   Lets you define a list of IP-numbers (with \*-wildcards) that are the
   ONLY ones allowed access to ANY backend activity. On error an error header
   is sent and the script exits. Works like IP masking for users
   configurable through TSconfig.

   See syntax for that (or look up syntax for the function
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::cmpIP())`

.. index::
   TYPO3_CONF_VARS BE; lockSSL
.. _typo3ConfVars_be_lockSSL:

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL']
============================================

.. confval:: lockSSL

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

   If set, the backend can only be operated from an SSL-encrypted
   connection (https). A redirect to the SSL version of a URL will happen
   when a user tries to access non-https admin-urls

.. index::
   TYPO3_CONF_VARS BE; lockSSLPort
.. _typo3ConfVars_be_lockSSLPort:

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSLPort']
================================================

.. confval:: lockSSLPort

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0

   Use a non-standard HTTPS port for lockSSL. Set this value if you use
   lockSSL and the HTTPS port of your webserver is not 443.

.. index::
   TYPO3_CONF_VARS BE;
.. _typo3ConfVars_be_cookieDomain:

$GLOBALS['TYPO3_CONF_VARS']['BE']['cookieDomain']
=================================================

.. confval:: cookieDomain

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   Same as `$TYPO3_CONF_VARS[SYS][cookieDomain]<typo3ConfVars_sys_cookieDomain>`
   but only for BE cookies. If empty, :php:`$TYPO3_CONF_VARS[SYS][cookieDomain]`
   value will be used.

.. index::
   TYPO3_CONF_VARS BE; cookieName
.. _typo3ConfVars_be_cookieName:

$GLOBALS['TYPO3_CONF_VARS']['BE']['cookieName']
===============================================

.. confval:: cookieName:

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: 'be_typo_user'

   Set the name for the cookie used for the back-end user session

.. index::
   TYPO3_CONF_VARS BE; cookieSameSite
.. _typo3ConfVars_be_cookieSameSite:

$GLOBALS['TYPO3_CONF_VARS']['BE']['cookieSameSite']
===================================================

.. confval:: cookieSameSite

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: 'strict'
   :allowedValues:
      lax:
         Cookies set by TYPO3 are only available for the current site,
         third-party integrations are not allowed to read cookies, except for
         links and simple HTML forms

      strict:
         Cookies sent by TYPO3 are only available for the current site, never
         shared to other third-party packages
      none:
         Allow cookies set by TYPO3 to be sent to other sites as well,
         please note - this only works with HTTPS connections

   Indicates that the cookie should send proper information where the cookie
   can be shared (first-party cookies vs. third-party cookies) in TYPO3 Backend.

.. index::
   TYPO3_CONF_VARS BE; loginSecurityLevel
.. _typo3ConfVars_be_loginSecurityLevel:

Removed: $GLOBALS['TYPO3_CONF_VARS']['BE']['loginSecurityLevel']
================================================================

.. deprecated:: 11.3
   This option was removed with version 11.3. The only possible
   value has been 'normal'. This behaviour stays unchanged.  When this option
   has been set in your :file:`LocalConfiguration.php`
   or :file:`AdditionalConfiguration.php` files, they are automatically
   removed when accessing the admin tool or system maintenance area.

.. index::
   TYPO3_CONF_VARS BE; showRefreshLoginPopup
.. _typo3ConfVars_be_showRefreshLoginPopup:

$GLOBALS['TYPO3_CONF_VARS']['BE']['showRefreshLoginPopup']
==========================================================

.. confval:: showRefreshLoginPopup

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

   If set, the Ajax relogin will show a real popup window for relogin after
   the count down. Some auth services need this as they add custom validation
   to the login form. If its not set, the Ajax relogin will show an inline
   relogin window.

.. index::
   TYPO3_CONF_VARS BE; adminOnly
.. _typo3ConfVars_be_adminOnly:

$GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly']
==============================================

.. confval:: adminOnly

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: int
   :Default: 0

   :allowedValues:
     -1: Total shutdown for maintenance purposes
     0: Default: All users can access the TYPO3 Backend
     1: Only administrators / system maintainers can log in, CLI interface is disabled as well
     2: Only administrators / system maintainers have access to the TYPO3 Backend, CLI executions are allowed as well

   Restricts access to the TYPO3 Backend - especially useful when doing maintenance or updates

.. index::
   TYPO3_CONF_VARS BE; disable_exec_function
.. _typo3ConfVars_be_disable_exec_function:

$GLOBALS['TYPO3_CONF_VARS']['BE']['disable_exec_function']
==========================================================

.. confval:: disable_exec_function

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

   Dont use exec() function (except for ImageMagick which is disabled by
   `[GFX][im]<typo3ConfVars_gfx_im>` =0). If set, all file operations are done
   by the default PHP-functions. This is necessary under Windows! On Unix the
   system commands by exec() can be used, unless this is disabled.

.. index::
   TYPO3_CONF_VARS BE; compressionLevel
.. _typo3ConfVars_be_compressionLevel:

$GLOBALS['TYPO3_CONF_VARS']['BE']['compressionLevel']
=====================================================

.. confval:: compressionLevel

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: 0
   :Range: 0-9

   Determines output compression of BE output. Makes output smaller but slows
   down the page generation depending on the compression level. Requires

   *  zlib in your PHP installation and
   *  special rewrite rules for .css.gzip and .js.gzip

   (please see :file:`_.htacces`  for an example). Range 1-9, where 1 is least
   compression and 9 is greatest compression. true as value will set the
   compression based on the PHP default settings (usually 5). Suggested and
   most optimal value is 5.

.. index::
   TYPO3_CONF_VARS BE; installToolPassword
.. _typo3ConfVars_be_installToolPassword:

$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']
========================================================

.. confval:: installToolPassword

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: string
   :Default: ''

   The hash of the install tool password.


.. index::
   TYPO3_CONF_VARS BE; checkStoredRecords
.. _typo3ConfVars_be_checkStoredRecords:

$GLOBALS['TYPO3_CONF_VARS']['BE']['checkStoredRecords']
=======================================================

.. confval:: checkStoredRecords

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: true

   If set, values of the record are validated after saving in DataHandler.
   Disable only if using a database in strict mode.

.. index::
   TYPO3_CONF_VARS BE; checkStoredRecordsLoose
.. _typo3ConfVars_be_checkStoredRecordsLoose:

$GLOBALS['TYPO3_CONF_VARS']['BE']['checkStoredRecordsLoose']
============================================================

.. confval:: checkStoredRecordsLoose

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: true

   If set, make a loose comparison ( equals 0) when validating record
   values after saving in DataHandler.



.. index::
   TYPO3_CONF_VARS BE; defaultUserTSconfig
.. _typo3ConfVars_be_defaultUserTSconfig:

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUserTSconfig']
============================================================

.. confval:: defaultUserTSconfig

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text

   Contains the default user TSconfig.


   This variable should not be changed directly but by the following API function.
   This makes your code less likely to break in the future.

   .. code-block:: php
      :caption: my_sitepackage/ext_localconf.php

      /**
       * Adding the default User TSconfig
       */
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
         @import 'EXT:my_sitepackage/Configuration/TSconfig/User/default.tsconfig'
      ');

   Read more about
   :ref:`Setting default User TSconfig <t3tsconfig:usersettingdefaultusertsconfig>`.

.. index::
   TYPO3_CONF_VARS BE; defaultPageTSconfig
.. _typo3ConfVars_be_defaultPageTSconfig:

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig']
========================================================

.. confval:: defaultPageTSconfig

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text

   Contains the default page TSconfig.

   Never set this configuration variable directly. Use the following methods instead:

   .. versionadded:: 12.0
      TSconfig stored in a file :file:`EXT:my_sitepackage/Configuration/page.tsconfig`
      will be automatically loaded before the content of
      :php:`$TYPO3_CONF_VARS[SYS][defaultPageTSconfig]`.

   Page TSconfig stored in files like
   :file:`EXT:my_sitepackage/Configuration/page.tsconfig` are loaded before
   :php:`$TYPO3_CONF_VARS[SYS][defaultPageTSconfig]`.
   This is done during build-time and therefore more performant than the legacy way of
   loading default Page Tsconfig during runtime by setting
   :php:`$TYPO3_CONF_VARS[SYS][defaultPageTSconfig]` or the API function
   :php:`ExtensionManagementUtility::addPageTSConfig`. It is therefore highly recommended
   to migrate to using files like :file:`EXT:my_sitepackage/Configuration/page.tsconfig`
   instead of setting this global variable.

   Read more about
   :ref:`Setting the Page TSconfig globally <t3tsconfig:pagesettingdefaultpagetsconfig>`.

.. index::
   TYPO3_CONF_VARS BE; defaultPermissions
.. _typo3ConfVars_be_defaultPermissions:

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions']
========================================================

.. confval:: defaultPermissions

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: array
   :Default: []


.. index::
   TYPO3_CONF_VARS BE; defaultUC
.. _typo3ConfVars_be_defaultUC:

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUC']
========================================================

.. confval:: defaultUC

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: array
   :Default: []


.. index::
   TYPO3_CONF_VARS BE; customPermOptions
.. _typo3ConfVars_be_customPermOptions:

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions']
========================================================

.. confval:: customPermOptions

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: array
   :Default: []

   Array with sets of custom permission options. Syntax is:


   .. code-block:: php
      :caption: typo3conf/AdditionalConfiguration.php

      'key' => array(
         'header' => 'header string, language split',
         'items' => array(
            'key' => array('label, language split','icon reference', 'Description text, language split')
         )
      )

   Keys cannot contain characters any of the following characters: :php:`:|,`.


.. index::
   TYPO3_CONF_VARS BE; fileDenyPattern
.. _typo3ConfVars_be_fileDenyPattern:

$GLOBALS['TYPO3_CONF_VARS']['BE']['fileDenyPattern']
====================================================

.. confval:: fileDenyPattern

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: ''

   A perl-compatible and JavaScript-compatible regular expression (without
   delimiters `/`) that - if it matches a filename - will deny the
   file upload/rename or whatever.

   For security reasons, files with multiple extensions have to be denied on
   an Apache environment with mod_alias, if the filename contains a valid php
   handler in an arbitrary position. Also, ".htaccess" files have to be denied.
   Matching is done case-insensitive.

   Default value is stored in PHP constant :php:`FILE_DENY_PATTERN_DEFAULT`

.. index::
   TYPO3_CONF_VARS BE; interfaces
.. _typo3ConfVars_be_interfaces:

$GLOBALS['TYPO3_CONF_VARS']['BE']['interfaces']
===============================================

.. confval:: interfaces

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: text
   :Default: backend

   This determines which interface options are available in the login prompt

   (All options: "backend,frontend")

.. _typo3ConfVars_be_explicitADmode:

$GLOBALS['TYPO3_CONF_VARS']['BE']['explicitADmode']
===================================================

.. versionchanged:: 12.0
   The handling of :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['explicitADmode']` has been changed and
   is now set using :php:`explicitAllow`. Extensions should not assume this global array
   key is set anymore as of TYPO3 Core v12. Extensions that need to stay compatible with v11
   and v12 should instead use: :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['explicitADmode'] ?? 'explicitAllow'`.

.. index::
   TYPO3_CONF_VARS BE; flexformForceCDATA
.. _typo3ConfVars_be_flexformForceCDATA:

$GLOBALS['TYPO3_CONF_VARS']['BE']['flexformForceCDATA']
=======================================================

.. confval:: flexformForceCDATA

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: 0

   If set, will add CDATA to Flexform XML. Some versions of libxml have a bug
   that causes HTML entities to be stripped from any XML content and this
   setting will avoid the bug by adding CDATA.

.. index::
   TYPO3_CONF_VARS BE; versionNumberInFilename
.. _typo3ConfVars_be_versionNumberInFilename:

$GLOBALS['TYPO3_CONF_VARS']['BE']['versionNumberInFilename']
============================================================

.. confval:: versionNumberInFilename

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

      If enabled, included CSS and JS files loaded in the TYPO3 Backend will
      have the timestamp embedded in the filename, ie. :php:`filename.1269312081.js` .
      This will make browsers and proxies reload the files if they change
      (thus avoiding caching issues).

      **IMPORTANT:** This feature requires extra :file:`.htaccess` rules to
      work (please refer to the
      :file:`typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
      file shipped with TYPO3).

      If disabled the last modification date of the file will be appended as a query-string.

.. index::
   TYPO3_CONF_VARS BE; debug
.. _typo3ConfVars_be_debug:

$GLOBALS['TYPO3_CONF_VARS']['BE']['debug']
==========================================

.. confval:: debug

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: bool
   :Default: false

   If enabled, the login refresh is disabled and pageRenderer is set to debug
   mode. Furthermore the fieldname is appended to the label of fields. Use
   this to debug the backend only!


.. index::
   TYPO3_CONF_VARS BE; toolbarItems (removed)
.. _typo3ConfVars_be_toolbarItems:

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems']
=================================================

.. warning::
   This configuration variable has been removed in TYPO3 version 12.0. Setting
   it has no effect.

Starting with version 12.0 toolbar items implementing
:php:`\TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface` are automatically
registered by adding the tag :yaml:`backend.toolbar.item`, if :yaml:`autoconfigure`
is enabled in :file:`Services.yaml`.

Migration
---------

Remove :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems']` from your
:file:`ext_localconf.php` file. If :yaml:`autoconfigure` is not enabled in
your :file:`Configuration/Services.(yaml|php)`, add the tag
:yaml:`backend.toolbar.item` to your toolbar item class.


.. index::
   TYPO3_CONF_VARS BE; HTTP
.. _typo3ConfVars_be_HTTP:

$GLOBALS['TYPO3_CONF_VARS']['BE']['HTTP']
=========================================

.. confval:: HTTP

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']
   :type: array
   :Default:
      .. code-block:: php

         [
            'Response' => [
               'Headers' => ['clickJackingProtection' => 'X-Frame-Options: SAMEORIGIN']
            ]
         ]

.. index::
   TYPO3_CONF_VARS BE; passwordHashing className
.. _typo3ConfVars_be_passwordHashing_className:

$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']['className']
=================================================================

.. confval:: passwordHashing className

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']
   :type: dropdown
   :Default: 'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash'

   :allowedValues:
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash':
         'Good password hash mechanism. Used by default if available.'
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2idPasswordHash':
         'Good password hash mechanism.'
      'TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash':
         'Good password hash mechanism.'
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Pbkdf2PasswordHash':
         'Fallback hash mechanism if argon and bcrypt are not available.'
      'TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash':
         'Fallback hash mechanism if none of the above are available.'


.. index::
   TYPO3_CONF_VARS BE; passwordHashing options
.. _typo3ConfVars_be_passwordHashing_options:

$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']['options']
=================================================================

.. confval:: passwordHashing options

   :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']
   :type: array
   :Default: []

   Special settings for specific hashes.
