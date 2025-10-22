..  include:: /Includes.rst.txt

..  index::
   TYPO3_CONF_VARS; BE
..  _typo3ConfVars_be:

==========================
BE - backend configuration
==========================

The following configuration variables can be used to configure the TYPO3 backend:

..  note::
    The configuration values listed here are keys in the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']` global PHP array.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-be
    :display: table
    :type:

..  _typo3ConfVars_be_fileadminDir:

..  confval:: fileadminDir
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir']
    :name: globals-typo3-conf-vars-be-fileadminDir
    :type: text
    :Default: 'fileadmin/'

    Path to the main file directory for editors. This is relative to
    the public web directory. DefaultStorage will be created with this configuration.
    Do not access manually but via
    :php:`\TYPO3\CMS\Core\Resource\ResourceFactory::getDefaultStorage()`.

..  _typo3ConfVars_be_lockBackendFile:

..  confval:: lockBackendFile
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockBackendFile']
    :name: globals-typo3-conf-vars-be-lockBackendFile
    :type: string (file path)
    :Default: `"var/lock/LOCK_BACKEND"` (Composer mode) | `"config/LOCK_BACKEND"` (Classic mode)

    ..  versionadded:: 13.3

    Defines the location of the flag file :file:`LOCK_BACKEND`. The file
    temporarily restricts backend access to prevent unauthorized
    changes or during critical updates.

..  _typo3ConfVars_be_lockRootPath:

..  confval:: lockRootPath
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath']
    :name: globals-typo3-conf-vars-be-lockRootPath
    :type: array of file paths
    :Default: :php:`[]`

    These absolute paths are used to check if paths outside of the project
    path should be allowed. This restriction also applies to the local driver
    in the :ref:`File Abstraction Layer <fal>`.

    This option supports an array of root path prefixes to
    allow multiple storage locations to be listed.

    See also the `Security bulletin "Path Traversal in TYPO3 File Abstraction
    Layer Storages" <https://typo3.org/security/advisory/typo3-core-sa-2024-001>`__.

    ..  attention::
        Trailing slashes are enforced automatically.

..  _typo3ConfVars_be_userHomePath:

..  confval:: userHomePath
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['userHomePath']
    :name: globals-typo3-conf-vars-be-userHomePath
    :type: text
    :Default: ''

    Combined folder identifier pointing to the directory where TYPO3 backend users have
    their home-dirs. A combined folder identifier looks like this:
    :php:`[storageUid]:[folderIdentifier]`, for example, :php:`2:users/`.
    The home directory identifier of backend user 2 would be: :php:`2:users/2/`. End slash required!

..  _typo3ConfVars_be_groupHomePath:

..  confval:: groupHomePath
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['groupHomePath']
    :name: globals-typo3-conf-vars-be-groupHomePath
    :type: text
    :Default: ''

    Combined folder identifier pointing to the directory where TYPO3 backend groups have
    their home-dirs. A combined folder identifier looks like this:
    :php:`[storageUid]:[folderIdentifier]`, for example, :php:`2:groups/`.
    The home directory identifier of backend group 1 would be: :php:`2:groups/1/`. End slash required!

..  _typo3ConfVars_be_userUploadDir:

..  confval:: userUploadDir
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['userUploadDir']
    :name: globals-typo3-conf-vars-be-userUploadDir
    :type: text
    :Default: ''

    Suffix which as added to the user home dir path when mounted in TYPO3.
    For example, if the user dir is :file:`../123_user/`  and the suffix
    is :file:`/upload`  then :file:`../123_user/upload` will be mounted.

..  _typo3ConfVars_be_warning_email_addr:

..  confval:: warning_email_addr
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['warning_email_addr']
    :name: globals-typo3-conf-vars-be-warning_email_addr
    :type: text
    :Default: ''

    Email address that will receive notifications whenever there is an attempt to
    login to the Install Tool. This address will also receive warnings
    when more than 3 failed backend login attempts are detected within an
    hour (regardless of user).

    See also :ref:`security guidelines
    <security-global-typo3-options-warning-email-addr>`.

..  _typo3ConfVars_be_warning_mode:

..  confval:: warning_mode
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['warning_mode']
    :name: globals-typo3-conf-vars-be-warning_mode
    :type: int
    :Default: 0
    :Allowed values:
       0:
           Default: Do not send notification-emails upon backend-login
       1:
           Send a notification-email every time a backend user logs in
       2:
           Send a notification-email every time an **admin** backend user logs in

    Send emails to :php:`warning_email_addr`  upon backend-login.

    See also :ref:`security guidelines
    <security-global-typo3-options-warning-mode>`.

..  _typo3ConfVars_be_passwordReset:

..  confval:: passwordReset
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordReset']
    :name: globals-typo3-conf-vars-be-passwordReset
    :type: bool
    :Default: true

    Enable password reset in the backend login for TYPO3 Backend
    users. Can be disabled for systems where only LDAP or OAuth login is allowed.

    Password reset will still work via CLI and for admins in the backend.

..  _typo3ConfVars_be_passwordResetForAdmins:

..  confval:: passwordResetForAdmins
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordResetForAdmins']
    :name: globals-typo3-conf-vars-be-passwordResetForAdmins
    :type: bool
    :Default: true

    Enable password reset for TYPO3 Administrators. This will
    affect both backend login and CLI. Disable this option for
    increased security.

..  _typo3ConfVars_be_requireMfa:

..  confval:: requireMfa
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['requireMfa']
    :name: globals-typo3-conf-vars-be-requireMfa
    :type: int
    :Default: 0
    :Allowed values: 0-4

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

    Define users that should be required to set up
    :ref:`multi-factor authentication <multi-factor-authentication>`.

..  _typo3ConfVars_be_recommendedMfaProvider:

..  confval:: recommendedMfaProvider
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['recommendedMfaProvider']
    :name: globals-typo3-conf-vars-be-recommendedMfaProvider
    :type: text
    :Default: 'totp'

    Set the identifier of the
    :ref:`multi-factor authentication provider <multi-factor-authentication-included-providers>`.
    Recommended for all users.

..  _typo3ConfVars_be_loginRateLimit:

..  confval:: loginRateLimit
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimit']
    :name: globals-typo3-conf-vars-be-loginRateLimit
    :type: int
    :Default: 5

    Maximum amount of login attempts in time interval
    :ref:`[BE][loginRateLimitInterval]<typo3ConfVars_be_loginRateLimitInterval>`
    before further login requests will be denied. Setting this value to
    :php:`"0"` will disable login rate limiting.

..  _typo3ConfVars_be_loginRateLimitInterval:

..  confval:: loginRateLimitInterval
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimitInterval']
    :name: globals-typo3-conf-vars-be-loginRateLimitInterval
    :type: string, PHP relative format
    :Default: '15 minutes'
    :Allowed values: '1 minute', '5 minutes', '15 minutes', '30 minutes'

    Time interval for the configured rate limit. Individual values
    using
    `PHP relative formats <https://www.php.net/manual/de/datetime.formats.relative.php>`__
    can be set in :file:`config/system/additional.php`.

..  _typo3ConfVars_be_loginRateLimitIpExcludeList:

..  confval:: loginRateLimitIpExcludeList
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimitIpExcludeList']
    :name: globals-typo3-conf-vars-be-loginRateLimitIpExcludeList
    :type: string
    :Default: ''

    IP addresses (with :php:`*`-wildcards) that are excluded from rate limiting.
    Syntax similar to :ref:`[BE][IPmaskList]<typo3ConfVars_be_IPmaskList>`.
    An empty value disables the exclude list check.

..  _typo3ConfVars_be_lockIP:

..  confval:: lockIP
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockIP']
    :name: globals-typo3-conf-vars-be-lockIP
    :type: int
    :Default: 0
    :Allowed values: 0-4

    0:
        Default: Do not lock Backend User sessions to their IP address
    1:
        Use the first part of the editors IPv4 address (for example "192.") as part of the session locking of Backend Users
    2:
        Use the first two parts of the editors IPv4 address (for example "192.168") as part of the session locking of Backend Users
    3:
        Use the first three parts of the editors IPv4 address (for example "192.168.13") as part of the session locking of Backend Users
    4:
        Use the editors full IPv4 address (for example "192.168.13.84") as part of the session locking of Backend Users (highest security)

    Session IP locking for backend users. See :ref:`[FE][lockIP]<typo3ConfVars_fe_lockIP>` for details.

    See also :ref:`security guidelines
    <security-global-typo3-options-lockIP>`.

..  _typo3ConfVars_be_lockIPv6:

..  confval:: lockIPv6
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockIPv6']
    :name: globals-typo3-conf-vars-be-lockIPv6
    :type: int
    :Default: 0
    :Allowed values: 0-8

    0:
        Default: Do not lock Backend User sessions to their IP address
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

..  _typo3ConfVars_be_sessionTimeout:

..  confval:: sessionTimeout
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['sessionTimeout']
    :name: globals-typo3-conf-vars-be-sessionTimeout
    :type: int
    :Default: 28800

    Session timeout for backend users (in seconds). The value must be at least
    180 to avoid side effects. The default is 28800 seconds = 8 hours.

..  _typo3ConfVars_be_IPmaskList:

..  confval:: IPmaskList
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['IPmaskList']
    :name: globals-typo3-conf-vars-be-IPmaskList
    :type: list
    :Default: ''

    Lets you define a list of IP addresses (with \*-wildcards) that are the
    ONLY IP addresses that are allowed access to ANY backend activity. On error,
    an error header is sent and the script exits. Works like IP masking for users
    configurable through TSconfig.

    See syntax for that (or look up syntax for the function
    :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::cmpIP())`

    See also :ref:`security guidelines
    <security-global-typo3-options-IPmaskList>`.

..  _typo3ConfVars_be_lockSSL:

..  confval:: lockSSL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL']
    :name: globals-typo3-conf-vars-be-lockSSL
    :type: bool
    :Default: false

    If set, the backend can only be accessed via an SSL-encrypted
    connection (https). If a user tries to access non-https admin-urls,
    they will be redirected to the SSL version of the URL.

    See also :ref:`security guidelines
    <security-global-typo3-options-lockSSL>`.

..  _typo3ConfVars_be_lockSSLPort:

..  confval:: lockSSLPort
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSLPort']
    :name: globals-typo3-conf-vars-be-lockSSLPort
    :type: int
    :Default: 0

    Use a non-standard HTTPS port for lockSSL. Set this value if you use
    lockSSL and the HTTPS port of your webserver is not 443.

..  _typo3ConfVars_be_cookieDomain:

..  confval:: cookieDomain
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['cookieDomain']
    :name: globals-typo3-conf-vars-be-cookieDomain
    :type: text
    :Default: ''

    Same as :ref:`$TYPO3_CONF_VARS[SYS][cookieDomain]<typo3ConfVars_sys_cookieDomain>`
    but for BE cookies. If empty, the :php:`$TYPO3_CONF_VARS[SYS][cookieDomain]`
    value will be used.

..  _typo3ConfVars_be_cookieName:

..  confval:: cookieName
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['cookieName']
    :name: globals-typo3-conf-vars-be-cookieName
    :type: text
    :Default: 'be_typo_user'

    Set the cookie name for the back-end user session.

..  _typo3ConfVars_be_cookieSameSite:

..  confval:: cookieSameSite
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['cookieSameSite']
    :name: globals-typo3-conf-vars-be-cookieSameSite
    :type: text
    :Default: 'strict'
    :Allowed values: 'lax', 'strict', 'none'

    lax:
        Cookies set by TYPO3 are only available for the current site.
        Third-party integrations are not allowed to read cookies, except for
        links and simple HTML forms
    strict:
        Cookies set by TYPO3 are only available for the current site. They are never
        shared with third-party packages
    none:
        Allow cookies set by TYPO3 to be sent to other sites as well.
        Note: this only works with HTTPS connections

    Configures how cookies can be shared in the TYPO3 Backend (first-party
    cookies vs. third-party cookies)

..  _typo3ConfVars_be_showRefreshLoginPopup:

..  confval:: showRefreshLoginPopup
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['showRefreshLoginPopup']
    :name: globals-typo3-conf-vars-be-showRefreshLoginPopup
    :type: bool
    :Default: false

    If set, the Ajax relogin will show a popup window for relogin after
    a countdown. Some authorization services need this as they add custom validation
    to the login form. If it is not set, the Ajax relogin will show an inline
    relogin window.

..  _typo3ConfVars_be_adminOnly:

..  confval:: adminOnly
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly']
    :name: globals-typo3-conf-vars-be-adminOnly
    :type: int
    :Default: 0

    :Allowed values: -1 - +2

    -1:
        Total shutdown for maintenance purposes
    0:
        Default: All users can access the TYPO3 Backend
    1:
        Only administrators / system maintainers can log in and CLI interface is disabled
    2:
        Only administrators / system maintainers have access to the TYPO3 Backend. CLI executions are allowed

    Restricts access to the TYPO3 Backend. Useful when doing maintenance or updates

..  _typo3ConfVars_be_disable_exec_function:

..  confval:: disable_exec_function
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['disable_exec_function']
    :name: globals-typo3-conf-vars-be-disable_exec_function
    :type: bool
    :Default: false

    Don't use exec() function (except for ImageMagick which is disabled by
    `[GFX][im]<typo3ConfVars_gfx_im>` =0). If set, all file operations are done
    by the default PHP functions. This is necessary under Windows! On Unix
    system commands using exec() can be used, unless this is disabled.

..  _typo3ConfVars_be_compressionLevel:

..  confval:: compressionLevel
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['compressionLevel']
    :name: globals-typo3-conf-vars-be-compressionLevel
    :type: text
    :Default: 0
    :Range: 0-9

    Determines output compression of BE output. Output is smaller but
    page generation slows down depending on compression level. Requires

    *  zlib in your PHP installation and
    *  special rewrite rules for :file:`.css.gz` and :file:`.js.gz`
       (before version 12.0 the extension was :file:`.css.gzip` and :file:`.js.gzip`)

    Please see :file:`EXT:install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
    for an example. The range is `1`-`9`, where `1` is least
    compression and `9` is greatest compression. Setting the value to :php:`true`
    will set the compression based on the PHP default settings (usually `5` ). The
    recommended and most optimal value is `5`.

..  _typo3ConfVars_be_installToolPassword:

..  confval:: installToolPassword
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']
    :name: globals-typo3-conf-vars-be-installToolPassword
    :type: string
    :Default: ''

    Hash of the install tool password. See also
    `Enabling and accessing the Install Tool <https://docs.typo3.org/permalink/t3coreapi:security-install-tool-access>`_.

..  _typo3ConfVars_be_checkStoredRecords:

..  confval:: checkStoredRecords
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['checkStoredRecords']
    :name: globals-typo3-conf-vars-be-checkStoredRecords

    ..  versionchanged:: 13.0
        This setting is obsolete. Instances setting this option in
        :file:`settings.php` are updated silently by the install tool during the
        upgrade process to TYPO3 v13.

..  _typo3ConfVars_be_checkStoredRecordsLoose:

..  confval:: checkStoredRecordsLoose
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['checkStoredRecordsLoose']
    :name: globals-typo3-conf-vars-be-checkStoredRecordsLoose

    ..  versionchanged:: 13.0
        This setting is obsolete. Instances setting this option in
        :file:`settings.php` are updated silently by the install tool during the
        upgrade process to TYPO3 v13.

..  index::
    TYPO3_CONF_VARS BE; defaultUserTSconfig
..  _typo3ConfVars_be_defaultUserTSconfig:

..  confval:: defaultUserTSconfig
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUserTSconfig']
    :name: globals-typo3-conf-vars-be-defaultUserTSconfig
    :type: text

    ..  deprecated:: 13.0
        This setting will be ignored with TYPO3 v14.0. Use
        :ref:`Configuration/user.tsconfig <extension-configuration-user_tsconfig>`
        instead.

        See also
        :ref:`Setting default User TSconfig <t3tsref:usersettingdefaultusertsconfig>`.
    Hash of the install tool password. See also
    `Enabling and accessing the Install Tool <https://docs.typo3.org/permalink/t3coreapi:security-install-tool-access>`_.

..  _typo3ConfVars_be_defaultPageTSconfig:

..  confval:: defaultPageTSconfig
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig']
    :name: globals-typo3-conf-vars-be-defaultPageTSconfig
    :type: text

    ..  deprecated:: 13.0
        This setting will be ignored with TYPO3 v14.0.
        Use :ref:`Configuration/page.tsconfig <extension-configuration-page_tsconfig>` instead.

        See also :ref:`Setting the page TSconfig globally <t3tsref:pagesettingdefaultpagetsconfig>`.

..  _typo3ConfVars_be_defaultPermissions:

..  confval:: defaultPermissions
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions']
    :name: globals-typo3-conf-vars-be-defaultPermissions
    :type: array
    :Default: []

    This option defines the default page permissions (`show`, `edit`, `delete`,
    `new`, `editcontent`). The following order applies:

    *   :php:`defaultPermissions` from :php:`TYPO3\CMS\Core\DataHandling\PagePermissionAssembler`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions']` (the option described here)
    *   Page TSconfig via :ref:`TCEMAIN.permissions <t3tsref:pagetcemain-permissions-user-group>`

    Example (with default permissions):

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions'] = [
            'user' => 'show,edit,delete,new,editcontent',
            'group' => 'show,edit,new,editcontent',
            'everybody' => '',
        ];

    If you want to deviate from the default permissions, for example, by changing the 'everybody' key,
    just modify that key:

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPermissions'] = [
            'everybody' => 'show',
        ];

..  _typo3ConfVars_be_defaultUC:

..  confval:: defaultUC
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUC']
    :name: globals-typo3-conf-vars-be-defaultUC
    :type: array
    :Default: []

    Defines default user settings. The following order applies:

    *   :php:`uc_default` in :php:`TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUC']` (the option described here)
    *   User TSconfig via :ref:`setup <t3tsref:usersetup>`

    Example (with default user settings):

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUC'] = [
            'emailMeAtLogin' => 0,
            'titleLen' => 50,
            'edit_RTE' => '1',
            'edit_docModuleUpload' => '1',
        ];

    Visit the :ref:`setup <t3tsref:usersetup>` chapter of the User TSconfig guide for
    a list of available options.

..  _typo3ConfVars_be_customPermOptions:

..  confval:: customPermOptions
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['customPermOptions']
    :name: globals-typo3-conf-vars-be-customPermOptions
    :type: array
    :Default: []

    Array with sets of custom permission options. The syntax is:


    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        'key' => array(
            'header' => 'header string, language split',
            'items' => array(
               'key' => array('label, language split','icon reference', 'Description text, language split')
            )
        )

    Keys cannot contain any of the following characters: :php:`:|,`.

..  _typo3ConfVars_be_fileDenyPattern:

..  confval:: fileDenyPattern
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['fileDenyPattern']
    :name: globals-typo3-conf-vars-be-fileDenyPattern
    :type: text
    :Default: ''

    A perl and JavaScript-compatible regular expression that will block ('deny')
    operations on files with matching filenames (without delimiters `/`), for
    example, file upload, rename, etc.

    For security reasons, files with multiple extensions in an Apache environment must be blocked
    using mod_alias, if the filename contains a valid php
    handler in an arbitrary position. Also, ".htaccess" files must be blocked.
    Matching is case-insensitive.

    The default value is stored in class constant
    :php:`\TYPO3\CMS\Core\Resource\Security\FileNameValidator::FILE_DENY_PATTERN_DEFAULT`.

    See also :ref:`security guidelines
    <security-global-typo3-options-fileDenyPattern>`.

..  _typo3ConfVars_be_flexformForceCDATA:

..  confval:: flexformForceCDATA
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['flexformForceCDATA']
    :name: globals-typo3-conf-vars-be-flexformForceCDATA

    ..  versionchanged:: 13.0
        This option was removed in TYPO3 v13.0.

..  _typo3ConfVars_be_versionNumberInFilename:

..  confval:: versionNumberInFilename
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['versionNumberInFilename']
    :name: globals-typo3-conf-vars-be-versionNumberInFilename
    :type: bool
    :Default: false

    If enabled, CSS and JS files loaded in the TYPO3 Backend will
    have a timestamp in their filename, i.e. :php:`filename.1269312081.js` .
    This will force browsers and proxies to reload the files if they change
    (thus avoiding caching issues).

    **IMPORTANT:** This feature requires extra :file:`.htaccess` rules in order to
    work (please refer to the
    :file:`typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
    file shipped with TYPO3).

    If disabled, the last modification date of the file will be appended as a query-string.

..  _typo3ConfVars_be_debug:

..  confval:: debug
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['debug']
    :name: globals-typo3-conf-vars-be-debug
    :type: bool
    :Default: false

    If enabled, login refresh is disabled and pageRenderer is set to debug
    mode. Also, fieldnames are appended to field labels. Use
    this to debug the backend only!

    Disables the
    :ref:`$GLOBALS[TYPO3_CONF_VARS][BE][compressionLevel] <typo3ConfVars_be_compressionLevel>`
    setting.

..  _typo3ConfVars_be_HTTP:

..  confval:: HTTP
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['HTTP']
    :name: globals-typo3-conf-vars-be-http
    :type: array

    Set HTTP headers to be sent with each backend request. Keys other than
    :php:`['Response']['Headers']` are ignored.

    Default configuration:

    ..  code-block:: php

        [
            'Response' => [
                'Headers' => [
                    'clickJackingProtection' => 'X-Frame-Options: SAMEORIGIN',
                    'strictTransportSecurity' => 'Strict-Transport-Security: max-age=31536000',
                    'avoidMimeTypeSniffing' => 'X-Content-Type-Options: nosniff',
                    'referrerPolicy' => 'Referrer-Policy: strict-origin-when-cross-origin',
                ],
            ],
        ]

    ..  note::
        `Strict-Transport-Security` is only active if the option
        :ref:`$GLOBALS[TYPO3_CONF_VARS][BE][lockSSL] <typo3ConfVars_be_lockSSL>`
        is enabled.


..  confval:: passwordHashing
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']
    :name: globals-typo3-conf-vars-be-passwordHashing

    ..  _typo3ConfVars_be_passwordHashing_className:

    ..  confval:: className
        :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']['className']
        :name: globals-typo3-conf-vars-be-passwordHashing-className
        :type: string
        :Default: :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class`

        Allowed values:

        :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class`
            Good password hash mechanism. Used by default if available.
        :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2idPasswordHash::class`
            Good password hash mechanism.
        :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash::class`
            Good password hash mechanism.
        :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Pbkdf2PasswordHash::class`
            Fallback hash mechanism if argon and bcrypt are not available.
        :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash::class`
            Fallback hash mechanism if none of the above are available.

    ..  _typo3ConfVars_be_passwordHashing_options:

    ..  confval:: options
        :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordHashing']['options']
        :name: globals-typo3-conf-vars-be-passwordHashing-options
        :type: array
        :Default: []

        Special settings for specific hash algorithms.
        See :ref:`password-hashing-available-algorithms` for the different options.

..  _typo3ConfVars_be_passwordPolicy:

..  confval:: passwordPolicy
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy']
    :name: globals-typo3-conf-vars-be-passwordPolicy
    :type: string
    :Default: default

    Defines the :ref:`password policy <password-policies>` in the backend context.

..  _typo3ConfVars_be_stylesheets:

..  confval:: stylesheets
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']
    :name: globals-typo3-conf-vars-be-stylesheets
    :type: string
    :Default: default

    Load additional CSS files for the TYPO3 backend interface. This can be set
    for a site or in an extension :file:`ext_localconf.php` file.

    .. rubric:: Examples:

    Add a specific stylesheet:

    ..  code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['my_extension']
            = 'EXT:my_extension/Resources/Public/Css/myfile.css';

    Add all stylesheets from a folder:

    ..  code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['my_extension']
            = 'EXT:my_extension/Resources/Public/Css/';

..  _typo3ConfVars_be_contentSecurityPolicyReportingUrl:

..  confval:: contentSecurityPolicyReportingUrl
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl']
    :name: globals-typo3-conf-vars-be-contentSecurityPolicyReportingUrl
    :type: string
    :Default: ''

    Configure the reporting HTTP endpoint of
    :ref:`Content Security Policy <content-security-policy>` violations in the
    backend; if it is empty, the TYPO3 endpoint will be used.

    Setting this configuration to `'0'` disables Content Security Policy
    reporting. If the endpoint is still called, the
    server-side process responds with a 403 HTTP error message.

    If defined, :ref:`site-specific configuration <content-security-policy-site-endpoints>`
    in :file:`config/sites/my_site/csp.yaml` takes precedence over the global configuration.

    ..  code-block:: php
        :caption: config/system/additional.php

        // Set a custom endpoint for Content Security Policy reporting
        $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl']
            = 'https://csp-violation.example.org/';

    ..  code-block:: php
        :caption: config/system/additional.php

        // Disables Content Security Policy reporting
        $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl'] = '0';

    Use :ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl'] <t3coreapi:confval-typo3-conf-vars-fe-contentsecuritypolicyreportingurl>`
    to configure Content Security Policy reporting for the frontend.

..  _typo3ConfVars_be_entryPoint:

..  confval:: entryPoint
    :Path: $GLOBALS['TYPO3_CONF_VARS']['BE']['entryPoint']
    :name: globals-typo3-conf-vars-be-entryPoint
    :type: string
    :Default: '/typo3'

    ..  versionadded:: 13.0

    A custom backend entry point can be configured by specifying a custom URL
    path or domain name.

    ..  rubric:: Example:

    ..  code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['BE']['entryPoint'] = '/my-specific-path';

    ..  seealso::
        :ref:`backend-entry-point`
