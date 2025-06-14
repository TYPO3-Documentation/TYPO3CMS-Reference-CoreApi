..  include:: /Includes.rst.txt

..  index::
   TYPO3_CONF_VARS; SYS
   TYPO3_CONF_VARS SYS
..  _typo3ConfVars_sys:

==========================
SYS - System configuration
==========================

The following configuration variables can be used for system wide
configurations.

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-sys
    :display: tree
    :type:

..  _typo3ConfVars_sys_fileCreateMask:

..  confval:: fileCreateMask
   :name: globals-typo3-conf-vars-sys-fileCreateMask
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['fileCreateMask']
   :type: text
   :Default: 0664

   File mode mask for Unix file systems (when files are uploaded/created).

..  _typo3ConfVars_sys_folderCreateMask:

..  confval:: folderCreateMask
   :name: globals-typo3-conf-vars-sys-folderCreateMask
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['folderCreateMask']
   :type: text
   :Default: 2775

   As above, but for folders.

..  _typo3ConfVars_sys_createGroup:

..  confval:: createGroup
   :name: globals-typo3-conf-vars-sys-createGroup
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['createGroup']
   :type: text
   :Default: ''

   Group for newly created files and folders (Unix only). Group ownership can
   be changed on Unix file systems (see above). Set this if you want to change
   the group ownership of created files/folders to a specific group.

   This makes sense in all cases where the webserver is running with a
   different user/group as you do. Create a new group on your system and add
   you and the webserver user to the group. Now you can safely set the last
   bit in fileCreateMask/folderCreateMask to 0 (for example 770). Important: The
   user who is running your webserver needs to be a member of the group you
   specify here! Otherwise you might get some error messages.

..  _typo3ConfVars_sys_sitename:

..  confval:: sitename
   :name: globals-typo3-conf-vars-sys-sitename
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']
   :type: text
   :Default: 'TYPO3'

   Name of the base-site.

..  _typo3ConfVars_sys_defaultScheme:

..  confval:: defaultScheme
   :name: globals-typo3-conf-vars-sys-defaultScheme
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['defaultScheme']
   :type: text
   :Default: 'http'

   Set the default URI scheme. This is used within links if no scheme is given.
   One can set this to :php:`'https'` if this should be used by default.

..  _typo3ConfVars_sys_encryptionKey:

..  confval:: encryptionKey
   :name: globals-typo3-conf-vars-sys-encryptionKey
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']
   :type: text
   :Default: ''

   This is a "salt" used for various kinds of encryption, CRC checksums and
   validations. You can enter any rubbish string here but try to keep it
   secret. You should notice that a change to this value might invalidate
   temporary information, URLs etc. At least, clear all cache if you change
   this so any such information can be rebuilt with the new key.

..  _typo3ConfVars_sys_cookieDomain:

..  confval:: cookieDomain
   :name: globals-typo3-conf-vars-sys-cookieDomain
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain']
   :type: text
   :Default: ''

   Restricts the domain name for FE and BE session cookies. When setting the
   value to ".example.org" (replace example.org with your domain!), login
   sessions will be shared across subdomains. Alternatively, if you have more
   than one domain with sub-domains, you can set the value to a regular
   expression to match against the domain of the HTTP request. This however requires
   that all sub-domains are within the same TYPO3 instance, because a session can be tied
   to only one database.

   The result of the match is used as the domain for the cookie. for example :
   php:`/\.(example1|example2)\.com$/` or :php:`/\.(example1\.com)|(example2\.net)$/`.
   Separate domains for FE and BE can be set using
   :ref:`$TYPO3_CONF_VARS[FE][cookieDomain]<typo3ConfVars_fe_cookieDomain>` and
   :ref:`$TYPO3_CONF_VARS[BE][cookieDomain]<typo3ConfVars_be_cookieDomain>`
   respectively.

..  _typo3ConfVars_sys_trustedHostsPattern:

..  confval:: trustedHostsPattern
   :name: globals-typo3-conf-vars-sys-trustedHostsPattern
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern']
   :type: text
   :Default: 'SERVER_NAME'

   Regular expression pattern that matches all allowed hostnames (including
   their ports) of this TYPO3 installation, or the string :php:`SERVER_NAME`
   (default).

   The default value :php:`SERVER_NAME` checks if the HTTP Host header equals
   the SERVER_NAME and SERVER_PORT. This is secure in correctly configured
   hosting environments and does not need further configuration. If you cannot
   change your hosting environment, you can enter a regular expression here.

   Examples:

   :php:`.*\.example\.org` matches all hosts that end with
   :file:`.example.org` with all corresponding subdomains.

   :php:`.*\.example\.(org|com)` matches all hostnames with
   subdomains from :file:`.example.org` and :file:`.example.com`.

   Be aware that HTTP Host header may also contain a port. If your installation

   runs on a specific port, you need to explicitly allow this in your pattern,

   for example :php:`example\.org:88` allows only :file:`example.org:88`,
   **not** :file:`example.org`. To disable this check completely
   (not recommended because it is **insecure**) you can use :php:`.*` as pattern.

   Have also a look into the :ref:`security guidelines
   <security-global-typo3-options-trustedHostsPattern>`.

..  _typo3ConfVars_sys_devIPmask:

..  confval:: devIPmask
   :name: globals-typo3-conf-vars-sys-devIPmask
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']
   :type: text
   :Default: '127.0.0.1,::1'

   Defines a list of IP addresses which will allow development output to
   display. The :php:`debug()` function will use this as a filter. See the
   function :php:`\TYPO3\CMS\Core\Utility\GeneralUtilitycmpIP()` for details
   on syntax. Setting this to blank value will deny all.
   Setting to "*" will allow all.

   Have also a look into the :ref:`security guidelines
   <security-global-typo3-options-devIpMask>`.

..  _typo3ConfVars_sys_ddmmyy:

..  confval:: ddmmyy
    :name: globals-typo3-conf-vars-sys-ddmmyy
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']
    :type: text
    :Default: 'Y-m-d'

    On how to format a date, see PHP function
    `date() <https://www.php.net/manual/en/function.date.php>`__.

..  _typo3ConfVars_sys_hhmm:

..  confval:: hhmm
    :name: globals-typo3-conf-vars-sys-hhmm
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['hhmm']
    :type: text
    :Default: 'H:i'

    Format of Hours-Minutes - see PHP-function `date() <https://www.php.net/manual/en/function.date.php>`__

..  _typo3ConfVars_sys_loginCopyrightWarrantyProvider:

..  confval:: loginCopyrightWarrantyProvider
    :name: globals-typo3-conf-vars-sys-loginCopyrightWarrantyProvider
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyProvider']
    :type: text
    :Default: ''

    If you provide warranty for TYPO3 to your customers insert you (company)
    name here. It will appear in the login-dialog as the warranty provider.
    (You must also set URL below).

..  _typo3ConfVars_sys_loginCopyrightWarrantyURL:

..  confval:: loginCopyrightWarrantyURL
    :name: globals-typo3-conf-vars-sys-loginCopyrightWarrantyURL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyURL']
    :type: text
    :Default: ''

    Add the URL where you explain the extend of the warranty you provide.
    This URL is displayed in the login dialog as the place where people can
    learn more about the conditions of your warranty. Must be set
    (more than 10 chars) in addition with the
    :ref:`loginCopyrightWarrantyProvider<typo3ConfVars_sys_loginCopyrightWarrantyProvider>`
    message.

..  _typo3ConfVars_sys_textfile_ext:

..  confval:: textfile_ext
    :name: globals-typo3-conf-vars-sys-textfile_ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['textfile_ext']
    :type: text
    :Default: 'txt,ts,typoscript,html,htm,css,tmpl,js,sql,xml,csv,xlf,yaml,yml'

    Text file extensions. Those that can be edited. Executable PHP files may not
    be editable if disallowed!

..  _typo3ConfVars_sys_mediafile_ext:

..  confval:: mediafile_ext
    :name: globals-typo3-conf-vars-sys-mediafile_ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
    :type: text
    :Default: 'gif,jpg,jpeg,bmp,png,pdf,svg,ai,mp3,wav,mp4,ogg,flac,opus,webm,youtube,vimeo'

    Commalist of file extensions perceived as media files by TYPO3.
    Must be written in lower case with no spaces between.

..  _typo3ConfVars_sys_miscfile_ext:

..  confval:: miscfile_ext
    :name: globals-typo3-conf-vars-sys-miscfile-ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['miscfile_ext']
    :type: text
    :Default: 'zip'

    ..  versionadded:: 13.4.12 / 12.4.31
        This property has been added with the security fix `Important: #106240 -
        Enforce File Extension and MIME-Type Consistency in File Abstraction
        Layer <https://docs.typo3.org/permalink/changelog:important-106240-1747316969>`_.

    Allows specifying file extensions that don't belong to either `textfile_ext`
    or `mediafile_ext`, such as `zip` or `xz`.

..  _typo3ConfVars_sys_binPath:

..  confval:: binPath
    :name: globals-typo3-conf-vars-sys-binPath
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binPath']
    :type: text
    :Default: ''

    List of absolute paths where external programs should be searched for.
    for example :php:`/usr/local/webbin/,/home/xyz/bin/`. (ImageMagick path have to
    be configured separately)

..  index::
    TYPO3_CONF_VARS SYS; binSetup
..  _typo3ConfVars_sys_binSetup:

..  confval:: binSetup
    :name: globals-typo3-conf-vars-sys-binSetup
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binSetup']
    :type: multiline
    :Default: ''

    List of programs (separated by newline or comma). By default programs
    will be searched in default paths and the special paths defined by
    :ref:`binPath<typo3ConfVars_sys_binPath>`. When PHP has :php:`openbasedir`
    enabled, the programs can not be found and have to be configured here.

    Example: :php:`perl=/usr/bin/perl,unzip=/usr/local/bin/unzip`

..  _typo3ConfVars_sys_setMemoryLimit:

..  confval:: setMemoryLimit
    :name: globals-typo3-conf-vars-sys-setMemoryLimit
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['setMemoryLimit']
    :type: int
    :Default: 0

    Memory limit in MB: If more than 16, TYPO3 will try to use :php:`ini_set()`
    to set the memory limit of PHP to the value. This works only if the function
    :php:`ini_set()` is not disabled by your sysadmin.

..  _typo3ConfVars_sys_phpTimeZone:

..  confval:: phpTimeZone
    :name: globals-typo3-conf-vars-sys-phpTimeZone
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone']
    :type: text
    :Default: ''

    Timezone to force for all :php:`date()` and :php:`mktime()` functions.
    A list of supported values can be found at
    `php.net <https://www.php.net/manual/en/timezones.php>`__.

    If blank, a valid fallback will be searched for by PHP (
    `date.timezone <https://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone>`__
    in :file:`php.ini`, server defaults, etc); and if no fallback is found, the value of
    "UTC" is used instead.

..  _typo3ConfVars_sys_UTF8filesystem:

..  confval:: UTF8filesystem
    :name: globals-typo3-conf-vars-sys-UTF8filesystem
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem']
    :type: bool
    :Default: true

    If set to :php:`true`, then TYPO3 uses UTF-8 to store file names. This allows for accented
    latin letters as well as any other non-latin characters like Cyrillic and
    Chinese.

    If set to :php:`false`, any file that contains characters like umlauts, or if the
    file name consists only of "special" characters such as Japanese, then the file will be renamed to
    something "safe" when uploaded in the backend.

    ..  attention::
        This requires a UTF-8 compatible locale in order to work. Otherwise
        problems with filenames containing special characters will occur.
        See :ref:`[SYS][systemLocale]<typo3ConfVars_sys_UTF8filesystem>` and
        `php function setlocale() <https://www.php.net/manual/en/function.setlocale.php>`__.

..  _typo3ConfVars_sys_systemLocale:

..  confval:: systemLocale
    :name: globals-typo3-conf-vars-sys-systemLocale
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLocale']
    :type: text
    :Default: ''

    Locale used for certain system related functions, for example escaping shell
    commands. If problems with filenames containing special characters occur,
    the value of this option is probably wrong. See
    `php function setlocale() <https://www.php.net/manual/en/function.setlocale.php>`__.

..  _typo3ConfVars_sys_reverseProxyIP:

..  confval:: reverseProxyIP
    :name: globals-typo3-conf-vars-sys-reverseProxyIP
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP']
    :type: list
    :Default: ''
    :allowedValues:
        `''`, `'*'` or a comma separated list of IPv4 or IPv6 addresses in CIDR-notation.
        For IPv4 addresses wildcards are additionally supported.

    If TYPO3 is behind one or more (intransparent) reverse
    proxies or load balancers the IP addresses or CIDR ranges must be added here and
    :confval:`globals-typo3-conf-vars-sys-reverseProxyHeaderMultiValue` must be set to `first` or `last`.

    ..  code-block:: php
        :caption: config/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue'] = 'first';
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '192.168.0.0/16';

    ..  seealso::

        *   `Running TYPO3 behind a reverse proxy <https://docs.typo3.org/permalink/t3coreapi:reverse-proxy-setup>`_
        *   `reverseProxySSL  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyssl>`_

..  _typo3ConfVars_sys_reverseProxyHeaderMultiValue:

..  confval:: reverseProxyHeaderMultiValue
    :name: globals-typo3-conf-vars-sys-reverseProxyHeaderMultiValue
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue']
    :type: text
    :allowedValues:
        none
            Do not evaluate the reverse proxy header

        first
            Use the first IP address in the proxy header

        last
            Use the last IP address in the proxy header

    :Default: 'none'

    Position of the authoritative IP address within the `X-Forwarded-For` header
    (for example, `X-Forwarded-For: 1.2.3.4, 2.3.4.5, 3.4.5.6` uses `1.2.3.4`
    with `first` and `3.4.5.6` with `last`).

..  _typo3ConfVars_sys_reverseProxyPrefix:

..  confval:: reverseProxyPrefix
    :name: globals-typo3-conf-vars-sys-reverseProxyPrefix
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefix']
    :type: text
    :Default: ''

    Optional prefix to be added to the internal URL (SCRIPT_NAME and
    REQUEST_URI).

    Example: When proxying `external.example.org` to `internal.example.org/prefix` this has to
    be set to :php:`prefix`

..  _typo3ConfVars_sys_reverseProxySSL:

..  confval:: reverseProxySSL
    :name: globals-typo3-conf-vars-sys-reverseProxySSL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL']
    :type: text
    :Default: ''
    :allowedValues:
        `''`, `'*'` or a comma separated list of IPv4 or IPv6 addresses in CIDR-notation.
        For IPv4 addresses wildcards are additionally supported.

    :php:`*` or a list of IP addresses of proxies that use SSL (https) for
    the connection to the client, but an unencrypted connection (http) to
    the server. If :php:`*` all proxies defined in
    :ref:`[SYS][reverseProxyIP]<typo3ConfVars_sys_reverseProxyIP>` use SSL.

    ..  versionadded:: 13.4
        If client establishes a secure connection, TYPO3 now also checks for
        `X-Forwarded-Proto` header.

    ..  seealso::

        *   `Running TYPO3 behind a reverse proxy <https://docs.typo3.org/permalink/t3coreapi:reverse-proxy-setup>`_
        *   `reverseProxyIP  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyip>`_

..  _typo3ConfVars_sys_reverseProxyPrefixSSL:

..  confval:: reverseProxyPrefixSSL
    :name: globals-typo3-conf-vars-sys-reverseProxyPrefixSSL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefixSSL']
    :type: text
    :Default: ''

    Prefix to be added to the internal URL (SCRIPT_NAME and REQUEST_URI)
    when accessing the server via an SSL proxy. This setting overrides
    :ref:`[SYS][reverseProxyPrefix]<typo3ConfVars_sys_reverseProxyPrefix>`.

..  _typo3ConfVars_sys_displayErrors:

..  confval:: displayErrors
    :name: globals-typo3-conf-vars-sys-displayErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']
    :type: int
    :Default: -1
    :allowedValues:
        `-1`
            TYPO3 does not touch the PHP setting. If
            :ref:`[SYS][devIPmask] <typo3ConfVars_sys_devIPmask>` matches the users
            IP address, the configured
            :ref:`[SYS][debugExceptionHandler] <typo3ConfVars_sys_debugExceptionHandler>`
            is used instead of the
            :ref:`[SYS][productionExceptionHandler] <typo3ConfVars_sys_productionExceptionHandler>`
            to handle exceptions.

        `0`
            Live: Do not display any PHP error message. Sets :php:`display_errors=0`.
            Overrides the value of
            :ref:`[SYS][exceptionalErrors]<typo3ConfVars_sys_exceptionalErrors>`
            and sets it to 0
            (= no errors are turned into exceptions). The configured
            :ref:`[SYS][productionExceptionHandler]<typo3ConfVars_sys_productionExceptionHandler>`
            is used as exception handler.

        `1`
            Debug: Display error messages with the registered
            :ref:`[SYS][errorHandler]<typo3ConfVars_sys_errorHandler>`.
            Sets :php:`display_errors=1`. The configured
            :ref:`[SYS][debugExceptionHandler]<typo3ConfVars_sys_debugExceptionHandler>`
            is used as exception handler.


    Configures whether PHP errors or exceptions should be displayed,
    effectively setting the PHP option :php:`display_errors` during runtime.

    Have also a look into the :ref:`security guidelines
    <security-global-typo3-options-displayErrors>`.

..  _typo3ConfVars_sys_productionExceptionHandler:

..  confval:: productionExceptionHandler
    :name: globals-typo3-conf-vars-sys-productionExceptionHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler']
    :type: phpClass
    :Default: :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler::class`

    Classname to handle exceptions that might happen in the TYPO3-code. Leave
    this empty to disable exception handling.  The default exception handler displays
    a nice error message when something goes wrong. The error message is
    logged to the configured logs.

    Note: The configured "productionExceptionHandler" is used if
    :ref:`[SYS][displayErrors]<typo3ConfVars_sys_displayErrors>` is set to "0"
    or is set to "-1" and
    :ref:`[SYS][devIPmask]<typo3ConfVars_sys_devIPmask>` does not match the user's IP.

..  _typo3ConfVars_sys_debugExceptionHandler:

..  confval:: debugExceptionHandler
    :name: globals-typo3-conf-vars-sys-debugExceptionHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler']
    :type: phpClass
    :Default: :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler::class`

    Classname to handle exceptions that might happen in the TYPO3 code. Leave
    empty to disable the exception handling. The default exception handler
    displays the complete stack trace of any encountered exception. The error
    message and the stack trace is logged to the configured logs.

    Note: The configured "debugExceptionHandler" is used if
    :ref:`[SYS][displayErrors]<typo3ConfVars_sys_displayErrors>` is set to "1" or
    is set to "-1" or "2" and the :ref:`[SYS][devIPmask]<typo3ConfVars_sys_devIPmask>`
    matches the users IP.

..  _typo3ConfVars_sys_errorHandler:

..  confval:: errorHandler
    :name: globals-typo3-conf-vars-sys-errorHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler']
    :type: phpClass
    :Default: `\TYPO3\CMS\Core\Error\ErrorHandler::class`

    Classname to handle PHP errors.
    This class displays and logs all errors that are registered as
    :ref:`[SYS][errorHandlerErrors]<typo3ConfVars_sys_errorHandlerErrors>`.
    Leave empty to disable error handling. Errors will be logged and can be sent
    to the optionally installed developer log or to the :sql:`syslog` database table.
    If an error is registered in
    :ref:`[SYS][exceptionalErrors]<typo3ConfVars_sys_exceptionalErrors>`
    it will be turned into an exception to be handled by the configured
    exceptionHandler.

..  _typo3ConfVars_sys_errorHandlerErrors:

..  confval:: errorHandlerErrors
    :name: globals-typo3-conf-vars-sys-errorHandlerErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors']
    :type: errors
    :Default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`

    The E_* constants that will be handled by the
    :ref:`[SYS][errorHandler]<typo3ConfVars_sys_errorHandler>`. Not all PHP error
    types can be handled:

    :php:`E_USER_DEPRECATED` will always be handled, regardless of this setting.
    Default is 30466 =
    :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

..  _typo3ConfVars_sys_exceptionalErrors:

..  confval:: exceptionalErrors
    :name: globals-typo3-conf-vars-sys-exceptionalErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors']
    :type: errors
    :Default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`

    The E_* constant that will be converted into an exception by the default
    :ref:`[SYS][errorHandler]<typo3ConfVars_sys_errorHandler>`. Default is
    4096 = :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

    E_USER_DEPRECATED is always excluded to avoid exceptions to be thrown for deprecation messages.

..  _typo3ConfVars_sys_belogErrorReporting:

..  confval:: belogErrorReporting
    :name: globals-typo3-conf-vars-sys-belogErrorReporting
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting']
    :type: errors
    :Default: `E_ALL & ~(E_STRICT | E_NOTICE)`

    Configures which PHP errors should be logged to the "syslog" database table
    (extension belog). If set to "0" no PHP errors are logged to the
    :sql:`sys_log` table. Default is 30711 =
    :php:`E_ALL & ~(E_STRICT | E_NOTICE)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

..  _typo3ConfVars_sys_generateApacheHtaccess:

..  confval:: generateApacheHtaccess
    :name: globals-typo3-conf-vars-sys-generateApacheHtaccess
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['generateApacheHtaccess']
    :type: bool
    :Default: 1

    TYPO3 can create :file:`.htaccess` files which are used by Apache Webserver.
    They are useful for access protection or performance improvements. Currently
    :file:`.htaccess` files in the following directories are created,
    if they do not exist: typo3temp/compressor/.

    You want to disable this feature, if you are not running Apache or
    want to use own rule sets.

..  _typo3ConfVars_sys_ipAnonymization:

..  confval:: ipAnonymization
    :name: globals-typo3-conf-vars-sys-ipAnonymization
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ipAnonymization']
    :type: int
    :Default: 1
    :allowedValues:
        0
            Disabled - Do not modify IP addresses at all
        1
            Mask the last byte for IPv4 addresses / Mask the Interface ID for
            IPv6 addresses (default)
        2
            Mask the last two bytes for IPv4 addresses / Mask the Interface
            ID and SLA ID for IPv6 addresses

    Configures if and how IP addresses stored via TYPO3s API should be anonymized
    ("masked") with a zero-numbered replacement. This is respected within
    anonymization task only, not while creating new log entries.

..  _typo3ConfVars_sys_systemMaintainers:

..  confval:: systemMaintainers
    :name: globals-typo3-conf-vars-sys-systemMaintainers
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemMaintainers']
    :type: array
    :Default: null

    A list of backend user IDs allowed to access the Install Tool

..  _typo3ConfVars_sys_features:

..  confval:: features
   :name: globals-typo3-conf-vars-sys-features
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']

    New features of TYPO3 that are activated on new installations but upgrading
    installations may still use the old behaviour.

    These settings are :ref:`feature toggles <feature-toggles>` and can be
    changed in the Backend module :guilabel:`Settings` in the section
    :guilabel:`Feature Toggles`, but not in :guilabel:`Configure Installation-Wide Options`.

    ..  _typo3ConfVars_sys_features_form.legacyUploadMimeTypes:

    ..  confval:: form.legacyUploadMimeTypes
       :name: globals-typo3-conf-vars-sys-features-form-legacyUploadMimeTypes
       :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['form.legacyUploadMimeTypes']
       :type: bool
       :Default: true

       If on, some mime types are predefined for the "FileUpload" and "ImageUpload"
       elements of the "form" extension, which always allows file uploads of these
       types, no matter the specific form element definition.

    ..  _typo3ConfVars_sys_features_redirects.hitCount:

    ..  confval:: redirects.hitCount
       :name: globals-typo3-conf-vars-sys-features-redirects-hitCount
       :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['redirects.hitCount']
       :type: bool
       :Default: false

       If on, and if extension "redirects" is loaded, each performed redirect is
       counted and last hit time is logged to the database.

    ..  _typo3ConfVars_sys_features_security.backend.enforceReferrer:

    ..  confval:: security.backend.enforceReferrer
       :name: globals-typo3-conf-vars-sys-features-security-backend-enforceReferrer
       :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.backend.enforceReferrer']
       :type: bool
       :Default: true

       If on, HTTP referrer headers are enforced for backend and install tool requests to mitigate
       potential same-site request forgery attacks. The behavior can be disabled in case HTTP proxies filter
       required referer header. As this is a potential security risk, it is recommended to enable this option.

    ..  _typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy:

    ..  confval:: security.frontend.enforceContentSecurityPolicy
        :name: globals-typo3-conf-vars-sys-features-security-frontend-enforceContentSecurityPolicy
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.enforceContentSecurityPolicy']
        :type: bool
        :Default: false

        If enabled, the :ref:`Content Security Policy <content-security-policy>`
        is enforced in frontend scope (HTTP header `Content-Security-Policy`).

        This option can be enabled in combination with
        :confval:`globals-typo3-conf-vars-sys-features-security-frontend-reportContentSecurityPolicy`.
        Then both headers are set.

    ..  _typo3ConfVars_sys_features_security.frontend.reportContentSecurityPolicy:

    ..  confval:: security.frontend.reportContentSecurityPolicy
        :name: globals-typo3-conf-vars-sys-features-security-frontend-reportContentSecurityPolicy
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.reportContentSecurityPolicy']
        :type: bool
        :Default: false

        If enabled, the :ref:`Content Security Policy <content-security-policy>`
        is applied in frontend scope as report-only (HTTP header
        `Content-Security-Policy-Report-Only`).

        This option can be enabled in combination with
        :confval:`globals-typo3-conf-vars-sys-features-security-frontend-enforceContentSecurityPolicy`.
        Then both headers are set.

    ..  _typo3ConfVars_sys_features_security.frontend.allowInsecureFrameOptionInShowImageController:

    ..  confval:: security.frontend.allowInsecureFrameOptionInShowImageController
        :name: globals-typo3-conf-vars-sys-features-security-frontend-allowInsecureFrameOptionInShowImageController
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureFrameOptionInShowImageController']
        :type: bool
        :Default: false

        ..  versionadded:: 13.1, 12.4.15, 11.5.37

        This option configures,  whether the show image controller (eID
        `tx_cms_showpic`) is allowed to supply an unsecured `&frame` URI
        parameter for backwards compatibility. The `&frame` parameter is not
        utilized by the TYPO3 core itself anymore.

        It is disabled by default and is strongly suggested to leave it
        turned off, for details see :ref:`<changelog:important-103306-1714976257>`. To enable it:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureFrameOptionInShowImageController'] = true;

    ..  _typo3ConfVars_sys_features_security.frontend.allowInsecureSiteResolutionByQueryParameters:

    ..  confval:: security.frontend.allowInsecureSiteResolutionByQueryParameters
        :name: globals-typo3-conf-vars-sys-features-security-frontend-allowInsecureSiteResolutionByQueryParameters
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureSiteResolutionByQueryParameters']
        :type: bool
        :Default: false

        Resolving sites by the `id` and `L` HTTP query parameters is now denied by
        default. However, it is still allowed to resolve a particular page by, for
        example, "example.org" - as long as the page ID `123` is in the scope of the
        site configured for the base URL "example.org".

        The flag can be used to reactivate the previous behavior:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureSiteResolutionByQueryParameters'] = true;

    ..  _typo3ConfVars_sys_features_security.usePasswordPolicyForFrontendUsers:


    ..  confval:: security.usePasswordPolicyForFrontendUsers
        :name: globals-typo3-conf-vars-sys-features-security-usePasswordPolicyForFrontendUsers

        ..  versionchanged:: 13.0
            The feature toggle `security.usePasswordPolicyForFrontendUsers` has been
            removed, because TypoScript-based password
            validation in :doc:`EXT:felogin <ext_felogin:Index>` has been removed, too.

            The :ref:`password policy <password-policies>` configured in
            :ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] <typo3ConfVars_fe_passwordPolicy>`
            is now always active for frontend user records in
            :ref:`DataHandler <datahandler-basics>` and for the password recovery
            functionality in EXT:felogin.

..  _typo3ConfVars_sys_availablePasswordHashAlgorithms:

..  confval:: availablePasswordHashAlgorithms
   :name: globals-typo3-conf-vars-sys-availablePasswordHashAlgorithms
   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['availablePasswordHashAlgorithms']
   :type: array
   :Default:

   A list of available password hash mechanisms. Extensions may register
   additional mechanisms here.

..  _typo3ConfVars_sys_linkHandler:

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']
    :name: globals-typo3-conf-vars-sys-linkHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']
    :type: array

    Links entered in the TYPO3 backend are stored in an internal format in the
    database, like `t3://page?uid=42`. The handlers for the different resource
    keys (like `page` in the example) are registered as link handlers.

    The TYPO3 Core registers the following link handlers:

    *   `page` (see :t3src:`core/Classes/LinkHandling/PageLinkHandler.php`)
    *   `file` (see :t3src:`core/Classes/LinkHandling/FileLinkHandler.php`)
    *   `folder` (see :t3src:`core/Classes/LinkHandling/FolderLinkHandler.php`)
    *   `url` (see :t3src:`core/Classes/LinkHandling/UrlLinkHandler.php`)
    *   `email` (see :t3src:`core/Classes/LinkHandling/EmailLinkHandler.php`)
    *   `record` (see :t3src:`core/Classes/LinkHandling/RecordLinkHandler.php`)
    *   `telephone` (see :t3src:`core/Classes/LinkHandling/TelephoneLinkHandler.php`)

    Additional link handlers can be added by extensions.

    ..  seealso::
        :ref:`LinkHandling`

..  _typo3ConfVars_sys_lang:

..  confval:: lang
    :name: globals-typo3-conf-vars-sys-lang
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']

    ..  _typo3ConfVars_sys_lang_requireApprovedLocalizations:

    ..  confval:: requireApprovedLocalizations
        :name: globals-typo3-conf-vars-sys-lang-requireApprovedLocalizations
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['requireApprovedLocalizations']
        :type: bool
        :Default: true

        The attribute :xml:`approved` of the :ref:`XLIFF <xliff>` standard is
        respected by TYPO3 since version 12.0 when parsing XLF files. This attribute
        can either have the value :xml:`yes` or :xml:`no` and indicates whether the
        translation is final or not.

        ..  code-block:: xml
            :caption: EXT:my_extension/Resources/Private/Language/locallang.xml

            <trans-unit id="label2" approved="yes">
                <source>This is label #2</source>
                <target>Ceci est le libellé no. 2</target>
            </trans-unit>

        This setting can be used to control the behavior:

        :php:`true`
            Only translations with the attribute :xml:`approved` set to :xml:`yes`
            will be used. Any non-approved translation (value is set to :xml:`no`)
            will be ignored. If the attribute :xml:`approved` is omitted, the
            translation is still taken into account.

        :php:`false`
            All translations are used.

..  _typo3ConfVars_sys_passwordPolicies:

..  confval::passwordPolicies
    :name: globals-typo3-conf-vars-sys-passwordPolicies
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']
    :type: array

    Defines the available :ref:`password policies <password-policies>`. Each
    policy must have a unique identifier (the identifier `default` is reserved
    by TYPO3) and must at least contain one validator.

    The default configuration:

    ..  code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['default'] = [
            'validators' => [
                \TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator::class => [
                    'options' => [
                        'minimumLength' => 8,
                        'upperCaseCharacterRequired' => true,
                        'lowerCaseCharacterRequired' => true,
                        'digitCharacterRequired' => true,
                        'specialCharacterRequired' => true,
                    ],
                    'excludeActions' => [],
                ],
                \TYPO3\CMS\Core\PasswordPolicy\Validator\NotCurrentPasswordValidator::class => [
                    'options' => [],
                    'excludeActions' => [
                        \TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction::NEW_USER_PASSWORD,
                    ],
                ],
            ],
        ];

..  _typo3ConfVars_sys_messenger:

..  confval:: messenger
    :name: globals-typo3-conf-vars-sys-messenger

    ..  _typo3ConfVars_sys_messenger_routing:

    ..  confval:: routing
        :name: globals-typo3-conf-vars-sys-messenger-routing
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing']
        :type: array

        The configuration of the routing for the
        :ref:`messenger component <message-bus>`. By default, TYPO3 uses a
        synchronous transport (:php:`default`) for all messages (:php:`*`):

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing'] = [
                '*' => 'default',
            ];

        You can set a different transport for a specific message, for example:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing'][\MyVendor\MyExtension\Queue\Message\DemoMessage::class]
                = 'doctrine';

        ..  seealso::
            :ref:`message-bus-routing`

..  confval:: FileInfo
    :name: globals-typo3-conf-vars-sys-FileInfo

    ..  _typo3ConfVars_sys_FileInfo_fileExtensionToMimeType:

    ..  confval:: fileExtensionToMimeType
        :name: globals-typo3-conf-vars-sys-FileInfo-fileExtensionToMimeType
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType']
        :type: array
        :Default: see :file:`EXT:core/Configuration/DefaultConfiguration.php`

        Static mapping for file extensions to mime types. In special cases the mime
        type is not detected correctly. Override this array only for cases where the
        automatic detection does not work correctly!

        It is not possible to change this value in the Backend!

        This is the default:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType'] = [
                'fileExtensionToMimeType' => [
                    'svg' => 'image/svg+xml',
                    'youtube' => 'video/youtube',
                    'vimeo' => 'video/vimeo',
                ],
            ],

..  confval:: allowedPhpDisableFunctions
    :name: globals-typo3-conf-vars-sys-allowedPhpDisableFunctions
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['allowedPhpDisableFunctions']
    :type: array
    :Default: `[]`

    ..  versionadded:: 13.2

    A configuration option to adapt the environment check in the :guilabel:`Admin Tools`
    for a list of sanctioned :php:`disable_functions`.

    With this configuration option
    a system maintainer can add native PHP function names to this list,
    which are then reported as environment warnings instead of errors.

    ..  code-block:: php
        :caption: config/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['allowedPhpDisableFunctions']
            = ['set_time_limit', 'set_file_buffer'];

    You can also define this in your :file:`settings.php` file manually
    or via :guilabel:`Admin Tools > Settings > Configure options`.
