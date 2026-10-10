..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; SYS
    TYPO3_CONF_VARS SYS
..  _typo3confvars-sys:

==========================
SYS - system configuration
==========================

The following configuration variables can be used for system-wide
configuration.

..  note::
    The configuration values listed here are keys into the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']` global PHP array.

    These variables can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3confvars-settings>`
    *   :ref:`config/system/additional.php <typo3confvars-additional>`

..  versionchanged:: 14.0
    Options within `$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']` have been moved
    to key :ref:`$GLOBALS['TYPO3_CONF_VARS']['LANG'] <typo3confvars-lang>`.
    Option `$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']` has
    been moved to `$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-lang-resourceoverrides>`_.

..  confval-menu::
    :name: globals-typo3-conf-vars-sys
    :display: tree
    :type:


..  _globals-typo3-conf-vars-sys-caching:

caching
-------

..  confval:: caching
    :name: globals-typo3-conf-vars-sys-caching
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']
    :type: array
    :default: See :t3src:`core/Configuration/DefaultConfiguration.php`

    ..  confval:: cacheConfigurations
        :name: globals-typo3-conf-vars-sys-caching-cacheConfigurations
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']
        :type: array
        :default: See :t3src:`core/Configuration/DefaultConfiguration.php`

        Registry of configured caches. Each cache is identified by its array
        key. Each cache key can contain sub-keys `frontend`, `backend` and
        `options` which set the frontend, backend and backend options for a
        configured cache.

        See also `Cache configuration <https://docs.typo3.org/permalink/t3coreapi:caching-configuration>`_.

..  _typo3confvars-sys-filecreatemask:


fileCreateMask
--------------

..  confval:: fileCreateMask
    :name: globals-typo3-conf-vars-sys-fileCreateMask
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['fileCreateMask']
    :type: text
    :default: 0664

    File mode mask for Unix file systems (when files are uploaded/created).

..  _typo3confvars-sys-foldercreatemask:


folderCreateMask
----------------

..  confval:: folderCreateMask
    :name: globals-typo3-conf-vars-sys-folderCreateMask
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['folderCreateMask']
    :type: text
    :default: 2775

    As above, but for folders.

..  _typo3confvars-sys-creategroup:


createGroup
-----------

..  confval:: createGroup
    :name: globals-typo3-conf-vars-sys-createGroup
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['createGroup']
    :type: text
    :default: ''

    Group for newly created files and folders (Unix only). Group ownership can
    be changed on Unix file systems (see above). Set this if you want to change
    the group ownership of created files/folders to a specific group.

    This makes sense when the webserver is running on a
    different user/group to you. Create a new group on your system and add
    yourself and the webserver user to the group. Now you can safely set the last
    bit in fileCreateMask/folderCreateMask to 0 (for example 770). Note: the
    user running your webserver needs to be a member of the group you
    specify here otherwise there may be errors.

..  _typo3confvars-sys-sitename:


sitename
--------

..  confval:: sitename
    :name: globals-typo3-conf-vars-sys-sitename
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']
    :type: text
    :default: 'TYPO3'

    Name of the base site.

..  _typo3confvars-sys-defaultscheme:


defaultScheme
-------------

..  confval:: defaultScheme
    :name: globals-typo3-conf-vars-sys-defaultScheme
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['defaultScheme']
    :type: text
    :default: 'http'

    Set the default URI scheme. This is used in links if no scheme is set.
    It can be set to `'https'` for the default setting.

..  _typo3confvars-sys-encryptionkey:


encryptionKey
-------------

..  confval:: encryptionKey
    :name: globals-typo3-conf-vars-sys-encryptionKey
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']
    :type: text
    :default: ''

    This is a "salt" used for encryption, CRC checksums and
    validations. You can enter any string here but try to keep it
    secret.

  **When changing this value, flush all the caches:** A change to this value might invalidate
    temporary information, such as URLs mappings.


..  _typo3confvars-sys-cookiedomain:


cookieDomain
------------

..  confval:: cookieDomain
    :name: globals-typo3-conf-vars-sys-cookieDomain
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain']
    :type: text
    :default: ''

    Restricts the domain name for FE and BE session cookies. When setting the
    value to ".example.org" (replace example.org with your domain!), login
    sessions will be shared across subdomains. Alternatively, if you have more
    than one domain with sub-domains, you can set the value to a regular
    expression to match against the domain of the HTTP request. However, this requires
    that all sub-domains are within the same TYPO3 instance because a session can be tied
    to only one database.

    The result of the match is used as the cookie domain. For example :
    php:`/\.(example1|example2)\.com$/` or :php:`/\.(example1\.com)|(example2\.net)$/`.
    Separate domains for FE and BE can be set using
    :ref:`$TYPO3_CONF_VARS[FE][cookieDomain]<typo3confvars-fe-cookiedomain>` and
    :ref:`$TYPO3_CONF_VARS[BE][cookieDomain]<typo3confvars-be-cookiedomain>`
    respectively.

..  _typo3confvars-sys-trustedhostspattern:


trustedHostsPattern
-------------------

..  confval:: trustedHostsPattern
    :name: globals-typo3-conf-vars-sys-trustedHostsPattern
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern']
    :type: text
    :default: 'SERVER_NAME'

    Regular expression pattern that matches all valid hostnames (including
    their ports) of this TYPO3 installation, or the string :php:`SERVER_NAME`
    (default).

    The default value :php:`SERVER_NAME` checks if the HTTP Host header equals
    the `SERVER_NAME` and `SERVER_PORT`. This is secure in **correctly configured
    hosting environments** - meaning the web server determines `SERVER_NAME`
    and `SERVER_PORT` from its own configuration rather than from the
    client-supplied Host header - and does not need further configuration. If you
    cannot change your hosting environment, you can enter a regular expression here.

    Examples:

    :php:`.*\.example\.org` matches all hosts that end with
    :file:`.example.org` with all corresponding subdomains.

    :php:`.*\.example\.(org|com)` matches all hostnames with
    subdomains from :file:`.example.org` and :file:`.example.com`.

    Be aware that HTTP Host header may also contain a port. If your installation
    runs on a specific port, you need to explicitly allow this in your pattern,
    for example :php:`example\.org:88` allows only :file:`example.org:88`,
    **not** :file:`example.org`. To disable this check completely
    (not recommended because it is **insecure**) you can use a :php:`.*` pattern.

    See also :ref:`security guidelines
    <security-global-typo3-options-trustedhostspattern>`.

..  _typo3confvars-sys-devipmask:


devIPmask
---------

..  confval:: devIPmask
    :name: globals-typo3-conf-vars-sys-devIPmask
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']
    :type: text
    :default: '127.0.0.1,::1'

    Defines a list of IP addresses which allows development output to
    be displayed. The :php:`debug()` function will use this as a filter. See the
    function :php:`\TYPO3\CMS\Core\Utility\GeneralUtilitycmpIP()` for details
    on syntax. Setting this to blank value will deny all.
    Setting to "*" will allow all.

    See also :ref:`security guidelines
    <security-global-typo3-options-devipmask>`.

..  _typo3confvars-sys-ddmmyy:


ddmmyy
------

..  confval:: ddmmyy
    :name: globals-typo3-conf-vars-sys-ddmmyy
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']
    :type: text
    :default: 'Y-m-d'

    On how to format a date, see PHP function
    `date() <https://www.php.net/manual/en/function.date.php>`__.

..  _typo3confvars-sys-hhmm:


hhmm
----

..  confval:: hhmm
    :name: globals-typo3-conf-vars-sys-hhmm
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['hhmm']
    :type: text
    :default: 'H:i'

    Format of Hours-Minutes - see PHP-function `date() <https://www.php.net/manual/en/function.date.php>`__

..  _typo3confvars-sys-logincopyrightwarrantyprovider:


loginCopyrightWarrantyProvider
------------------------------

..  confval:: loginCopyrightWarrantyProvider
    :name: globals-typo3-conf-vars-sys-loginCopyrightWarrantyProvider
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyProvider']
    :type: text
    :default: ''

    If you provide a warranty for TYPO3 to your customers insert your (company)
    name here. It will appear in the login dialog as the warranty provider.
    (You must also set URL below).

..  _typo3confvars-sys-logincopyrightwarrantyurl:


loginCopyrightWarrantyURL
-------------------------

..  confval:: loginCopyrightWarrantyURL
    :name: globals-typo3-conf-vars-sys-loginCopyrightWarrantyURL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyURL']
    :type: text
    :default: ''

    Add the URL of the page describing the extent of the warranty provided.
    This URL is displayed in the login dialog as the place where people can
    learn more about the conditions of your warranty. Must be set
    (more than 10 chars) together with the
    :ref:`loginCopyrightWarrantyProvider<typo3confvars-sys-logincopyrightwarrantyprovider>`
    message.

..  _typo3confvars-sys-textfile-ext:


textfile_ext
------------

..  confval:: textfile_ext
    :name: globals-typo3-conf-vars-sys-textfile_ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['textfile_ext']
    :type: text
    :default: 'txt,ts,typoscript,html,htm,css,tmpl,js,sql,xml,csv,xlf,yaml,yml'

    Text file extensions (files that can be edited). Executable PHP files may not
    be editable if disallowed!

..  _typo3confvars-sys-mediafile-ext:


mediafile_ext
-------------

..  confval:: mediafile_ext
    :name: globals-typo3-conf-vars-sys-mediafile_ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
    :type: text
    :default: '3gp,aac,ai,aif,avif,bmp,flac,gif,heic,ico,jpeg,jpg,m4a,m4v,mov,mp3,mp4,ogg,opus,pdf,png,psd,svg,vimeo,wav,webm,webp,youtube'

    ..  versionadded:: 14.0

        The default list has been extended to include 3gp, aac, aif, avif, heic, ico, m4a,
        m4v, mov, psd and webp file types.

    Comma-separated list of file extensions recognized as media files by TYPO3.
    Must be in lowercase with no spaces in between.

..  _typo3confvars-sys-miscfile-ext:


miscfile_ext
------------

..  confval:: miscfile_ext
    :name: globals-typo3-conf-vars-sys-miscfile-ext
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['miscfile_ext']
    :type: text
    :default: 'zip'

    Allows file extensions to be specified that don't belong to either `textfile_ext`
    or `mediafile_ext`, such as `zip` or `xz`.

..  _typo3confvars-sys-binpath:


binPath
-------

..  confval:: binPath
    :name: globals-typo3-conf-vars-sys-binPath
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binPath']
    :type: text
    :default: ''

    List of absolute paths as search locations for external programs,
    for example :php:`/usr/local/webbin/,/home/xyz/bin/`. (ImageMagick paths have to
    be configured separately)

..  index::
    TYPO3_CONF_VARS SYS; binSetup
..  _typo3confvars-sys-binsetup:


binSetup
--------

..  confval:: binSetup
    :name: globals-typo3-conf-vars-sys-binSetup
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binSetup']
    :type: multiline
    :default: ''

    List of programs separated by newlines or commas. By default, programs
    will be searched in default paths and the special paths defined by
    :ref:`binPath<typo3confvars-sys-binpath>`. When PHP has :php:`openbasedir`
    enabled, the programs can not be found and have to be configured here.

    Example: :php:`perl=/usr/bin/perl,unzip=/usr/local/bin/unzip`

..  _typo3confvars-sys-setmemorylimit:


setMemoryLimit
--------------

..  confval:: setMemoryLimit
    :name: globals-typo3-conf-vars-sys-setMemoryLimit
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['setMemoryLimit']
    :type: int
    :default: 0

    Memory limit in MB: if more than 16, TYPO3 will try to use :php:`ini_set()`
    to set the memory limit of PHP. This works only if the function
    :php:`ini_set()` is not disabled by your sysadmin.

..  _typo3confvars-sys-phptimezone:


phpTimeZone
-----------

..  confval:: phpTimeZone
    :name: globals-typo3-conf-vars-sys-phpTimeZone
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone']
    :type: text
    :default: ''

    Timezone to force for all :php:`date()` and :php:`mktime()` functions.
    A list of supported values can be found at
    `php.net <https://www.php.net/manual/en/timezones.php>`__.

    If blank, a valid fallback will be searched for by PHP (
    `date.timezone <https://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone>`__
    in :file:`php.ini`, server defaults, etc). If no fallback is found, the value of
    "UTC" is used instead.

..  _typo3confvars-sys-reverseproxyip:


reverseProxyIP
--------------

..  confval:: reverseProxyIP
    :name: globals-typo3-conf-vars-sys-reverseProxyIP
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP']
    :type: list
    :default: ''
    :Allowed values:
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

..  _typo3confvars-sys-reverseproxyheadermultivalue:


reverseProxyHeaderMultiValue
----------------------------

..  confval:: reverseProxyHeaderMultiValue
    :name: globals-typo3-conf-vars-sys-reverseProxyHeaderMultiValue
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue']
    :type: text
    :Allowed values:
        none
            Do not evaluate the reverse proxy header

        first
            Use the first IP address in the proxy header

        last
            Use the last IP address in the proxy header

    :default: 'none'

    Position of the authoritative IP address within the `X-Forwarded-For` header
    (for example, `X-Forwarded-For: 1.2.3.4, 2.3.4.5, 3.4.5.6` uses `1.2.3.4`
    with `first` and `3.4.5.6` with `last`).

..  _typo3confvars-sys-reverseproxyprefix:


reverseProxyPrefix
------------------

..  confval:: reverseProxyPrefix
    :name: globals-typo3-conf-vars-sys-reverseProxyPrefix
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefix']
    :type: text
    :default: ''

    Optional prefix to be added to the internal URL (SCRIPT_NAME and
    REQUEST_URI).

    Example: When proxying `external.example.org` to `internal.example.org/prefix` this has to
    be set to :php:`prefix`.

..  _typo3confvars-sys-reverseproxyssl:


reverseProxySSL
---------------

..  confval:: reverseProxySSL
    :name: globals-typo3-conf-vars-sys-reverseProxySSL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL']
    :type: text
    :default: ''
    :Allowed values:
        `''`, `'*'` or a comma separated list of IPv4 or IPv6 addresses in CIDR-notation.
        For IPv4 addresses, wildcards are supported.

    :php:`*` or a list of IP addresses of proxies that use SSL (https) for
    the connection to the client, but an unencrypted connection (http) to
    the server. If :php:`*` all proxies defined in
    :ref:`[SYS][reverseProxyIP]<typo3confvars-sys-reverseproxyip>` use SSL.

    If a client establishes a secure connection, TYPO3 also checks for
    `X-Forwarded-Proto` header.

    ..  seealso::

        *   `Running TYPO3 behind a reverse proxy <https://docs.typo3.org/permalink/t3coreapi:reverse-proxy-setup>`_
        *   `reverseProxyIP  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyip>`_

..  _typo3confvars-sys-reverseproxyprefixssl:


reverseProxyPrefixSSL
---------------------

..  confval:: reverseProxyPrefixSSL
    :name: globals-typo3-conf-vars-sys-reverseProxyPrefixSSL
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefixSSL']
    :type: text
    :default: ''

    Prefix added to the internal URL (SCRIPT_NAME and REQUEST_URI)
    when accessing the server via an SSL proxy. This setting overrides
    :ref:`[SYS][reverseProxyPrefix]<typo3confvars-sys-reverseproxyprefix>`.

..  _typo3confvars-sys-displayerrors:


displayErrors
-------------

..  confval:: displayErrors
    :name: globals-typo3-conf-vars-sys-displayErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']
    :type: int
    :default: -1
    :Allowed values:
        `-1`
            TYPO3 does not touch the PHP setting. If
            :ref:`[SYS][devIPmask] <typo3confvars-sys-devipmask>` matches the users
            IP address, the configured
            :ref:`[SYS][debugExceptionHandler] <typo3confvars-sys-debugexceptionhandler>`
            is used instead of the
            :ref:`[SYS][productionExceptionHandler] <typo3confvars-sys-productionexceptionhandler>`
            to handle exceptions.

        `0`
            Live: Do not display a PHP error message. Sets :php:`display_errors=0`.
            Overrides the value of
            :ref:`[SYS][exceptionalErrors]<typo3confvars-sys-exceptionalerrors>`
            and sets it to 0
            (= no errors are turned into exceptions). The configured
            :ref:`[SYS][productionExceptionHandler]<typo3confvars-sys-productionexceptionhandler>`
            is used as the exception handler.

        `1`
            Debug: Display error messages with the registered
            :ref:`[SYS][errorHandler]<typo3confvars-sys-errorhandler>`.
            Sets :php:`display_errors=1`. The configured
            :ref:`[SYS][debugExceptionHandler]<typo3confvars-sys-debugexceptionhandler>`
            is used as exception handler.


    Configures whether PHP errors or exceptions should be displayed,
    effectively setting the PHP option :php:`display_errors` during runtime.

    See also :ref:`security guidelines
    <security-global-typo3-options-displayerrors>`.

..  _typo3confvars-sys-productionexceptionhandler:


productionExceptionHandler
--------------------------

..  confval:: productionExceptionHandler
    :name: globals-typo3-conf-vars-sys-productionExceptionHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler']
    :type: phpClass
    :default: :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler::class`

    Classname to handle exceptions that occur in the TYPO3 code. Leave
    this empty to disable exception handling.  The default exception handler displays
    a nice error message when something goes wrong. The error message is
    logged to the configured logs.

    Note: The configured "productionExceptionHandler" is used if
    :ref:`[SYS][displayErrors]<typo3confvars-sys-displayerrors>` is set to "0"
    or is set to "-1" and
    :ref:`[SYS][devIPmask]<typo3confvars-sys-devipmask>` does not match the user's IP.

..  _typo3confvars-sys-debugexceptionhandler:


debugExceptionHandler
---------------------

..  confval:: debugExceptionHandler
    :name: globals-typo3-conf-vars-sys-debugExceptionHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler']
    :type: phpClass
    :default: :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler::class`

    Classname to handle exceptions that occur in the TYPO3 code. Leave
    empty to disable exception handling. The default exception handler
    displays the complete stack trace of an exception. The error
    message and the stack trace are logged to the configured logs.

    Note: The configured "debugExceptionHandler" is used if
    :ref:`[SYS][displayErrors]<typo3confvars-sys-displayerrors>` is set to "1" or
    is set to "-1" or "2" and the :ref:`[SYS][devIPmask]<typo3confvars-sys-devipmask>`
    matches the users IP.

..  _typo3confvars-sys-errorhandler:


errorHandler
------------

..  confval:: errorHandler
    :name: globals-typo3-conf-vars-sys-errorHandler
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler']
    :type: phpClass
    :default: :php:`\TYPO3\CMS\Core\Error\ErrorHandler::class`

    Classname to handle PHP errors.
    This class displays and logs all errors that are registered as
    :ref:`[SYS][errorHandlerErrors]<typo3confvars-sys-errorhandlererrors>`.
    Leave empty to disable error handling. Errors will be logged and can be sent
    to the developer log (if installed) or to the :sql:`syslog` database table.
    If an error is registered in
    :ref:`[SYS][exceptionalErrors]<typo3confvars-sys-exceptionalerrors>`
    it will be turned into an exception to be handled by the configured
    exceptionHandler.

..  _typo3confvars-sys-errorhandlererrors:


errorHandlerErrors
------------------

..  confval:: errorHandlerErrors
    :name: globals-typo3-conf-vars-sys-errorHandlerErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors']
    :type: errors
    :default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`

    The E_* constants that will be handled by the
    :ref:`[SYS][errorHandler]<typo3confvars-sys-errorhandler>`. Not all PHP error
    types can be handled:

    :php:`E_USER_DEPRECATED` will always be handled, regardless of this setting.
    Default is 30466 =
    :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

..  _typo3confvars-sys-exceptionalerrors:


exceptionalErrors
-----------------

..  confval:: exceptionalErrors
    :name: globals-typo3-conf-vars-sys-exceptionalErrors
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors']
    :type: errors
    :default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`

    The E_* constant that will be converted into an exception by the default
    :ref:`[SYS][errorHandler]<typo3confvars-sys-errorhandler>`. Default is
    4096 = :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

    E_USER_DEPRECATED is always excluded to avoid exceptions being thrown for deprecation messages.

..  _typo3confvars-sys-belogerrorreporting:


belogErrorReporting
-------------------

..  confval:: belogErrorReporting
    :name: globals-typo3-conf-vars-sys-belogErrorReporting
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting']
    :type: errors
    :default: `E_ALL & ~(E_STRICT | E_NOTICE)`

    Configures which PHP errors should be logged to the "syslog" database table
    (extension belog). If set to "0" no PHP errors are logged to the
    :sql:`sys_log` table. Default is 30711 =
    :php:`E_ALL & ~(E_STRICT | E_NOTICE)`
    (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

..  _typo3confvars-sys-generateapachehtaccess:


generateApacheHtaccess
----------------------

..  confval:: generateApacheHtaccess
    :name: globals-typo3-conf-vars-sys-generateApacheHtaccess
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['generateApacheHtaccess']
    :type: bool
    :default: 1

    TYPO3 can create :file:`.htaccess` files which are used by Apache Webserver.
    They are useful for access protection and performance improvements. Currently, if
    the files don't exist, they are created from the following directories: typo3temp/compressor/.

    You should disable this feature if you are not running Apache or
    want to use your own rule sets.

..  _typo3confvars-sys-ipanonymization:


ipAnonymization
---------------

..  confval:: ipAnonymization
    :name: globals-typo3-conf-vars-sys-ipAnonymization
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ipAnonymization']
    :type: int
    :default: 1
    :Allowed values:
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
    anonymization tasks only, not when creating new log entries.

..  _typo3confvars-sys-systemmaintainers:


systemMaintainers
-----------------

..  confval:: systemMaintainers
    :name: globals-typo3-conf-vars-sys-systemMaintainers
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemMaintainers']
    :type: array
    :default: null

    A list of backend user IDs that are allowed to access the Install Tool.

..  _typo3confvars-sys-features:


features
--------

..  confval:: features
    :name: globals-typo3-conf-vars-sys-features
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']

    New features of TYPO3 that are activated on new installations (but upgrading
    installations may still use the old behavior).

    These settings are :ref:`feature toggles <feature-toggles>` and can be
    changed in the Backend module :guilabel:`Settings` in the section
    :guilabel:`Feature Toggles`, but not in :guilabel:`Configure Installation-Wide Options`.

    ..  _typo3ConfVars_sys_features_form.legacyUploadMimeTypes:

    ..  confval:: form.legacyUploadMimeTypes
        :name: globals-typo3-conf-vars-sys-features-form-legacyUploadMimeTypes
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['form.legacyUploadMimeTypes']
        :type: bool
        :default: true

       If enabled, some mime types are predefined for the "FileUpload" and "ImageUpload"
       elements of the "form" extension which always allows file uploads of these
       types, regardless of the form element definition.

    ..  _typo3ConfVars_sys_features_redirects.hitCount:

    ..  confval:: redirects.hitCount
        :name: globals-typo3-conf-vars-sys-features-redirects-hitCount
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['redirects.hitCount']
        :type: bool
        :default: false

       If enabled, and extension "redirects" is loaded, each redirect is
       counted and the last hit time is logged to the database.

    ..  _typo3ConfVars_sys_features_security.backend.enforceReferrer:

    ..  confval:: security.backend.enforceReferrer
        :name: globals-typo3-conf-vars-sys-features-security-backend-enforceReferrer
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.backend.enforceReferrer']
        :type: bool
        :default: true

       If enabled, HTTP referrer headers are enforced for backend and install tool requests to mitigate
       potential same-site request forgery attacks. The behavior can be disabled if HTTP proxies filter
       the required referrer header. As this is a potential security risk, it is recommended to enable this option.

    ..  _typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy:

    ..  confval:: security.frontend.enforceContentSecurityPolicy
        :name: globals-typo3-conf-vars-sys-features-security-frontend-enforceContentSecurityPolicy
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.enforceContentSecurityPolicy']
        :type: bool
        :default: false

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
        :default: false

        If enabled, the :ref:`Content Security Policy <content-security-policy>`
        is applied in the frontend scope as report-only (HTTP header
        `Content-Security-Policy-Report-Only`).

        This option can be enabled in combination with
        :confval:`globals-typo3-conf-vars-sys-features-security-frontend-enforceContentSecurityPolicy`
        to set both headers.

    ..  _typo3ConfVars_sys_features_security.frontend.allowInsecureFrameOptionInShowImageController:

    ..  confval:: security.frontend.allowInsecureFrameOptionInShowImageController
        :name: globals-typo3-conf-vars-sys-features-security-frontend-allowInsecureFrameOptionInShowImageController
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureFrameOptionInShowImageController']
        :type: bool
        :default: false

        This option configures whether the show image controller (eID
        `tx_cms_showpic`) is allowed to supply an insecure `&frame` URI
        parameter (for backwards compatibility). The `&frame` parameter is no
        longer used in the TYPO3 core.

        It is disabled by default and it is strongly recommended to leave it
        turned off. For details see
        :ref:`Important: #103306 <changelog:important-103306-1714976257>`. To
        enable it:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureFrameOptionInShowImageController'] = true;

    ..  _typo3ConfVars_sys_features_security.frontend.allowInsecureSiteResolutionByQueryParameters:

    ..  confval:: security.frontend.allowInsecureSiteResolutionByQueryParameters
        :name: globals-typo3-conf-vars-sys-features-security-frontend-allowInsecureSiteResolutionByQueryParameters
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureSiteResolutionByQueryParameters']
        :type: bool
        :default: false

        Resolving sites with the `id` and `L` HTTP query parameters is now denied by
        default. However, it is still allowed for particular pages, for
        example, "example.org" - as long as the page ID `123` is in the scope of the
        site configured for the base URL "example.org".

        The flag can be used to reactivate the previous behavior:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.allowInsecureSiteResolutionByQueryParameters'] = true;

..  _typo3confvars-sys-availablepasswordhashalgorithms:


availablePasswordHashAlgorithms
-------------------------------

..  confval:: availablePasswordHashAlgorithms
    :name: globals-typo3-conf-vars-sys-availablePasswordHashAlgorithms
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['availablePasswordHashAlgorithms']
    :type: array
    :default:

   A list of available password hash mechanisms. Extensions may register
   additional mechanisms here.

..  _typo3confvars-sys-linkhandler:


$GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']
-------------------------------------------------

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
        :ref:`Link handling <linkhandling>`


..  _typo3confvars-sys-passwordpolicies:


passwordPolicies
----------------

..  confval:: passwordPolicies
    :name: globals-typo3-conf-vars-sys-passwordPolicies
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']
    :type: array

    Defines the available :ref:`password policies <password-policies>`,
    including validators and generators. Each
    policy must have a unique identifier.

    TYPO3 ships with three preconfigured policies:

    *   `default` Used for backend and frontend users
    *   `installTool` Used for Install Tool passwords
    *   `secretToken` Used for secret token fields (e.g. webhooks, reactions)

    For the default configuration see the default configuration on GitHub:
    https://github.com/TYPO3/typo3/blob/main/typo3/sysext/core/Configuration/DefaultConfiguration.php

..  _typo3confvars-sys-messenger:


messenger
---------

..  confval:: messenger
    :name: globals-typo3-conf-vars-sys-messenger

    ..  _typo3ConfVars_sys_messenger_routing:

    ..  confval:: routing
        :name: globals-typo3-conf-vars-sys-messenger-routing
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing']
        :type: array

        The configuration of the routing for the
        :ref:`messenger component <message-bus>`. By default, TYPO3 uses
        synchronous transport (:php:`default`) for all messages (:php:`*`):

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing'] = [
                '*' => 'default',
            ];

        You can set transport types for specific messages, for example:

        ..  code-block:: php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger']['routing'][\MyVendor\MyExtension\Queue\Message\DemoMessage::class]
                = 'doctrine';

        ..  seealso::
            :ref:`Configuring the message bus transport <message-bus-routing>`

..  _typo3confvars-sys-localization:


localization
------------

..  confval:: localization
    :name: globals-typo3-conf-vars-sys-localization

    ..  _typo3ConfVars_sys_localization_locales:

    ..  confval:: locales
        :name: globals-typo3-conf-vars-sys-localization-locales

        ..  _typo3ConfVars_sys_localization_locales_user:

        ..  confval:: user
            :name: globals-typo3-conf-vars-sys-localization-locales-user
            :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user']
            :type: array

            Define custom languages:

            ..  code-block:: php

                $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user'] = [
                    'gsw_CH' => 'Swiss German',
                ];

        ..  _typo3ConfVars_sys_localization_locales_dependencies:

        ..  confval:: dependencies
            :name: globals-typo3-conf-vars-sys-localization-locales-dependencies
            :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies']
            :type: array

            Add fallback to another language:

            ..  code-block:: php

                $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies'] = [
                    'gsw_CH' => ['de_AT', 'de'],
                ];

    ..  seealso::

        *   `Adding custom languages <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-languages>`_
        *   `Feature: #86913 - Automatic support for language files of languages with region suffix <https://docs.typo3.org/permalink/changelog:feature-86913-1673955088>`_


..  _globals-typo3-conf-vars-sys-fileinfo:

FileInfo
--------

..  confval:: FileInfo
    :name: globals-typo3-conf-vars-sys-FileInfo

    ..  _typo3ConfVars_sys_FileInfo_fileExtensionToMimeType:

    ..  confval:: fileExtensionToMimeType
        :name: globals-typo3-conf-vars-sys-FileInfo-fileExtensionToMimeType
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType']
        :type: array

        `$GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType']`
        is supported for backward compatibility reasons.

    ..  _typo3ConfVars-sys-FileInfo-mimeTypeCompatibility:

    ..  confval:: mimeTypeCompatibility
        :name: globals-typo3-conf-vars-sys-FileInfo-mimeTypeCompatibility
        :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['mimeTypeCompatibility']
        :type: array
        :default: see `EXT:core/Configuration/DefaultConfiguration.php <https://github.com/TYPO3/typo3/blob/006db645e4716529390fc3f07d84fe36b8694c43/typo3/sysext/core/Configuration/DefaultConfiguration.php#L369>`_

        For each generic MIME type (as detected by PHP MIME type detection) a
        map from file extension to a valid MIME type can be supplied.

        The Core predefines common file extensions and MIME types. Custom types
        can be configured.

        As PHP file detection methods can not reliably detect all IANA defined MIME
        types, mime-db based heuristics are applied to map generic MIME types like
        `text/plain` to `text/csv` for `*.csv` files.

        One example shipped in the Core is that `*.jfif` files are
        detected as an image/jpeg and mapped to image/pjpeg, which is the
        defined MIME type per IANA and enforced by the FAL persistence layer.

        ..  code-block:: php
            :caption: Example from the TYPO3 Core

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['mimeTypeCompatibility']['image/jpeg']['jfif'] =
                'image/pjpeg';

        Below is a generic example which allows a file ending in `*.foo`, that is detected
        to contain text/plain contents, to be mapped to the MIME type text/x-foo.
        Other contents (e.g. if the file contains binary data) will not be mapped:

        ..  code-block:: php
            :caption: config/system/additional.php

            $GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['mimeTypeCompatibility']['text/plain']['foo'] =
                'text/x-foo';


..  _globals-typo3-conf-vars-sys-allowedphpdisablefunctions:

allowedPhpDisableFunctions
--------------------------

..  confval:: allowedPhpDisableFunctions
    :name: globals-typo3-conf-vars-sys-allowedPhpDisableFunctions
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['allowedPhpDisableFunctions']
    :type: array
    :default: `[]`

    A configuration option to modify the environment check in
    :guilabel:`System > Environment` to incorporate a list of sanctioned
    `disable_functions`.

    Using this configuration option
    a system maintainer can add native PHP function names to the list,
    which are then reported as environment warnings instead of errors.

    ..  code-block:: php
        :caption: config/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['allowedPhpDisableFunctions']
            = ['set_time_limit', 'set_file_buffer'];

    You can also define this manually in your :file:`settings.php` file
    or via :guilabel:`System > Settings > Configure options`.


..  _globals-typo3-conf-vars-sys-ratelimiter:

rateLimiter
-----------

..  confval:: rateLimiter
    :name: globals-typo3-conf-vars-sys-rateLimiter
    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['rateLimiter']
    :type: array
    :default: `[]`

    Override rate limiter configuration by limiter ID. Each key is a limiter ID
    (for example, `login-be`, `backend-password-recovery`), and each value is an
    array with keys like `limit`, `interval`, and/or `policy` to override the
    programmatic defaults.

    Examples:

    ..  literalinclude:: _codesnippets/_SysRateLimiter.php
        :caption: config/system/additional.php | typo3conf/system/additional.php

    Known limiter IDs:

    *   :php:`login-be` — Backend login
    *   :php:`login-fe` — Frontend login
    *   :php:`backend-password-recovery` — Backend password reset
    *   :php:`felogin-password-recovery` — Frontend password recovery
    *   :php:`extbase-<classSlug>-<actionMethod>` —
        :ref:`Extbase #[RateLimit] actions <rate-limiting-extbase-action>`
