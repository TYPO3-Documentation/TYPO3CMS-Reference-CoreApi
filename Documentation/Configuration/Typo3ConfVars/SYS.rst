.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; SYS
   TYPO3_CONF_VARS SYS
.. _typo3ConfVars_sys:

==========================
SYS - System configuration
==========================

The following configuration variables can be used for system wide
configurations.

..  contents::
    :local:

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

.. index::
   TYPO3_CONF_VARS SYS; fileCreateMask
.. _typo3ConfVars_sys_fileCreateMask:

fileCreateMask
==============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['fileCreateMask']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 0664

   File mode mask for Unix file systems (when files are uploaded/created).

.. index::
   TYPO3_CONF_VARS SYS; folderCreateMask
.. _typo3ConfVars_sys_folderCreateMask:

folderCreateMask
================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['folderCreateMask']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 2775

   As above, but for folders.

.. index::
   TYPO3_CONF_VARS SYS; createGroup
.. _typo3ConfVars_sys_createGroup:

createGroup
===========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['createGroup']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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

.. index::
   TYPO3_CONF_VARS SYS; sitename
.. _typo3ConfVars_sys_sitename:

sitename
========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'TYPO3'

   Name of the base-site.

.. index::
   TYPO3_CONF_VARS SYS; defaultScheme
.. _typo3ConfVars_sys_defaultScheme:

defaultScheme
=============

.. versionadded:: 12.0
   The setting :php:`defaultScheme` was added in TYPO3 v12 to make it possible to
   configure the default URI scheme when links are created by the Core.
   Previously, :php:`'http'` was always used.

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['defaultScheme']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'http'

   Set the default URI scheme. This is used within links if no scheme is given.
   One can set this to :php:`'https'` if this should be used by default.

.. index::
   TYPO3_CONF_VARS SYS; encryptionKey
.. _typo3ConfVars_sys_encryptionKey:

encryptionKey
=============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   This is a "salt" used for various kinds of encryption, CRC checksums and
   validations. You can enter any rubbish string here but try to keep it
   secret. You should notice that a change to this value might invalidate
   temporary information, URLs etc. At least, clear all cache if you change
   this so any such information can be rebuilt with the new key.

.. index::
   TYPO3_CONF_VARS SYS; cookieDomain
.. _typo3ConfVars_sys_cookieDomain:

cookieDomain
============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Restricts the domain name for FE and BE session cookies. When setting the
   value to ".example.org" (replace example.org with your domain!), login
   sessions will be shared across subdomains. Alternatively, if you have more
   than one domain with sub-domains, you can set the value to a regular
   expression to match against the domain of the HTTP request.

   The result of the match is used as the domain for the cookie. for example :
   php:`/\.(example1|example2)\.com$/` or :php:`/\.(example1\.com)|(example2\.net)$/`.
   Separate domains for FE and BE can be set using
   :ref:`$TYPO3_CONF_VARS[FE][cookieDomain]<typo3ConfVars_fe_cookieDomain>` and
   :ref:`$TYPO3_CONF_VARS[BE][cookieDomain]<typo3ConfVars_be_cookieDomain>`
   respectively.

.. index::
   TYPO3_CONF_VARS SYS; trustedHostsPattern
.. _typo3ConfVars_sys_trustedHostsPattern:

trustedHostsPattern
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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


.. index::
   TYPO3_CONF_VARS SYS; devIPmask
.. _typo3ConfVars_sys_devIPmask:

devIPmask
=========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: '127.0.0.1,::1'

   Defines a list of IP addresses which will allow development-output to
   display. The :php:`debug()` function will use this as a filter. See the
   function :php:`\TYPO3\CMS\Core\Utility\GeneralUtilitycmpIP()` for details
   on syntax. Setting this to blank value will deny all.
   Setting to "*" will allow all.

   Have also a look into the :ref:`security guidelines
   <security-global-typo3-options-devIpMask>`.

.. index::
   TYPO3_CONF_VARS SYS; ddmmyy
.. _typo3ConfVars_sys_ddmmyy:

ddmmyy
======

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'd-m-y'

   Format of Day-Month-Year - see PHP-function `date() <https://www.php.net/manual/en/function.date.php>`__

.. index::
   TYPO3_CONF_VARS SYS; hhmm
.. _typo3ConfVars_sys_hhmm:

hhmm
====

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['hhmm']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'H:i'

   Format of Hours-Minutes - see PHP-function `date() <https://www.php.net/manual/en/function.date.php>`__

.. index::
   TYPO3_CONF_VARS SYS; loginCopyrightWarrantyProvider
.. _typo3ConfVars_sys_loginCopyrightWarrantyProvider:

loginCopyrightWarrantyProvider
==============================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyProvider']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   If you provide warranty for TYPO3 to your customers insert you (company)
   name here. It will appear in the login-dialog as the warranty provider.
   (You must also set URL below).

.. index::
   TYPO3_CONF_VARS SYS; loginCopyrightWarrantyURL
.. _typo3ConfVars_sys_loginCopyrightWarrantyURL:

loginCopyrightWarrantyURL
=========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyURL']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Add the URL where you explain the extend of the warranty you provide.
   This URL is displayed in the login dialog as the place where people can
   learn more about the conditions of your warranty. Must be set
   (more than 10 chars) in addition with the
   :ref:`loginCopyrightWarrantyProvider<typo3ConfVars_sys_loginCopyrightWarrantyProvider>`
   message.

.. index::
   TYPO3_CONF_VARS SYS; textfile_ext
.. _typo3ConfVars_sys_textfile_ext:

textfile_ext
============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['textfile_ext']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'txt,ts,typoscript,html,htm,css,tmpl,js,sql,xml,csv,xlf,yaml,yml'

   Text file extensions. Those that can be edited. Executable PHP files may not
   be editable if disallowed!

.. index::
   TYPO3_CONF_VARS SYS; mediafile_ext
.. _typo3ConfVars_sys_mediafile_ext:

mediafile_ext
=============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: 'gif,jpg,jpeg,bmp,png,pdf,svg,ai,mp3,wav,mp4,ogg,flac,opus,webm,youtube,vimeo'

   Commalist of file extensions perceived as media files by TYPO3.
   Must be written in lower case with no spaces between.

.. index::
   TYPO3_CONF_VARS SYS; binPath
.. _typo3ConfVars_sys_binPath:

binPath
=======

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binPath']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   List of absolute paths where external programs should be searched for.
   for example :php:`/usr/local/webbin/,/home/xyz/bin/`. (ImageMagick path have to
   be configured separately)

.. index::
   TYPO3_CONF_VARS SYS; binSetup
.. _typo3ConfVars_sys_binSetup:

binSetup
========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['binSetup']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: multiline
   :Default: ''

   List of programs (separated by newline or comma). By default programs
   will be searched in default paths and the special paths defined by
   :ref:`binPath<typo3ConfVars_sys_binPath>`. When PHP has :php:`openbasedir`
   enabled, the programs can not be found and have to be configured here.

   Example: :php:`perl=/usr/bin/perl,unzip=/usr/local/bin/unzip`

.. index::
   TYPO3_CONF_VARS SYS; setMemoryLimit
.. _typo3ConfVars_sys_setMemoryLimit:

setMemoryLimit
==============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['setMemoryLimit']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: int
   :Default: 0

   Memory limit in MB: If more than 16, TYPO3 will try to use :php:`ini_set()`
   to set the memory limit of PHP to the value. This works only if the function
   :php:`ini_set()` is not disabled by your sysadmin.

.. index::
   TYPO3_CONF_VARS SYS; phpTimeZone
.. _typo3ConfVars_sys_phpTimeZone:

phpTimeZone
===========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Timezone to force for all :php:`date()` and :php:`mktime()` functions.
   A list of supported values can be found at
   `php.net <https://www.php.net/manual/en/timezones.php>`__.

   If blank, a valid fallback will be searched for by PHP (php.inis
   `date.timezone <https://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone>`__
   setting, server defaults, etc); and if no fallback is found, the value of
   "UTC" is used instead.

.. index::
   TYPO3_CONF_VARS SYS; UTF8filesystem
.. _typo3ConfVars_sys_UTF8filesystem:

UTF8filesystem
==============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: bool
   :Default: true

   .. versionchanged:: 12.0
      Before TYPO3 v12 the default value for new installations was always set to :php:`false`.
      However, because almost every file system now supports UTF-8 the new default value
      is set to :php:`true`.

   If set to :php:`true`, then TYPO3 uses UTF-8 to store file names. This allows for accented
   latin letters as well as any other non-latin characters like Cyrillic and
   Chinese.

   If set to :php:`false`, any file that contains characters like umlauts, or if the
   file name consists only of "special" characters such as Japanese, then the file will be renamed to
   something "safe" when uploaded in the backend.

   .. important::
      This requires a UTF-8 compatible locale in order to work. Otherwise
      problems with filenames containing special characters will occur.
      See :ref:`[SYS][systemLocale]<typo3ConfVars_sys_UTF8filesystem>` and
      `php function setlocale() <https://www.php.net/manual/en/function.setlocale.php>`__.

.. index::
   TYPO3_CONF_VARS SYS; systemLocale
.. _typo3ConfVars_sys_systemLocale:

systemLocale
============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLocale']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Locale used for certain system related functions, for example escaping shell
   commands. If problems with filenames containing special characters occur,
   the value of this option is probably wrong. See
   `php function setlocale() <https://www.php.net/manual/en/function.setlocale.php>`__.

.. index::
   TYPO3_CONF_VARS SYS; reverseProxyIP
.. _typo3ConfVars_sys_reverseProxyIP:

reverseProxyIP
==============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: list
   :Default: ''

   List of IP addresses. If TYPO3 is behind one or more (intransparent) reverse
   proxies the IP addresses must be added here.

.. index::
   TYPO3_CONF_VARS SYS; reverseProxyHeaderMultiValue
.. _typo3ConfVars_sys_reverseProxyHeaderMultiValue:

reverseProxyHeaderMultiValue
============================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :allowedValues:
      none
         Do not evaluate the reverse proxy header

      first
         Use the first IP address in the proxy header

      last
         Use the last IP address in the proxy header

   :Default: 'none'

   Defines which values of a proxy header (for example HTTP_X_FORWARDED_FOR) to use,
   if more than one is found.

.. index::
   TYPO3_CONF_VARS SYS; reverseProxyPrefix
.. _typo3ConfVars_sys_reverseProxyPrefix:

reverseProxyPrefix
==================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefix']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Optional prefix to be added to the internal URL (SCRIPT_NAME and
   REQUEST_URI).

   Example: When proxying external.example.org to internal.example.org/prefix this has to
   be set to :php:`prefix`

.. index::
   TYPO3_CONF_VARS SYS; reverseProxySSL
.. _typo3ConfVars_sys_reverseProxySSL:

reverseProxySSL
===============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   :php:`*` or a list of IP addresses of proxies that use SSL (https) for
   the connection to the client, but an unencrypted connection (http) to
   the server. If php:`*` all proxies defined in
   :ref:`[SYS][reverseProxyIP]<typo3ConfVars_sys_reverseProxyIP>` use SSL.

.. index::
   TYPO3_CONF_VARS SYS; reverseProxyPrefixSSL
.. _typo3ConfVars_sys_reverseProxyPrefixSSL:

reverseProxyPrefixSSL
=====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyPrefixSSL']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: text
   :Default: ''

   Prefix to be added to the internal URL (SCRIPT_NAME and REQUEST_URI)
   when accessing the server via an SSL proxy. This setting overrides
   :ref:`[SYS][reverseProxyPrefix]<typo3ConfVars_sys_reverseProxyPrefix>`.

.. index::
   TYPO3_CONF_VARS SYS;
.. _typo3ConfVars_sys_displayErrors:

displayErrors
=============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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

.. index::
   TYPO3_CONF_VARS SYS; productionExceptionHandler
.. _typo3ConfVars_sys_productionExceptionHandler:

productionExceptionHandler
==========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: phpClass
   :Default: :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler::class`

   Classname to handle exceptions that might happen in the TYPO3-code. Leave
   this empty to disable exception handling.  The default exception handler displays
   a nice error message when something goes wrong. The error message is
   logged to the configured logs.

   Note: The configured "productionExceptionHandler" is used if
   :ref:`[SYS][displayErrors]<typo3ConfVars_sys_displayErrors>` is set to "0"
   or is set to "-1" and
   :ref:`[SYS][devIPmask]<typo3ConfVars_sys_devIPmask>` doesnt match the user's IP.

.. index::
   TYPO3_CONF_VARS SYS; debugExceptionHandler
.. _typo3ConfVars_sys_debugExceptionHandler:

debugExceptionHandler
=====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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

.. index::
   TYPO3_CONF_VARS SYS; errorHandler
.. _typo3ConfVars_sys_errorHandler:

errorHandler
============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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

.. index::
   TYPO3_CONF_VARS SYS; errorHandlerErrors
.. _typo3ConfVars_sys_errorHandlerErrors:

errorHandlerErrors
==================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: errors
   :Default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`

   The E_* constants that will be handled by the
   :ref:`[SYS][errorHandler]<typo3ConfVars_sys_errorHandler>`. Not all PHP error
   types can be handled:

   :php:`E_USER_DEPRECATED` will always be handled, regardless of this setting.
   Default is 30466 =
   :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR)`
   (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

.. index::
   TYPO3_CONF_VARS SYS; exceptionalErrors
.. _typo3ConfVars_sys_exceptionalErrors:

exceptionalErrors
=================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: errors
   :Default: :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`

   The E_* constant that will be converted into an exception by the default
   ref:`[SYS][errorHandler]<typo3ConfVars_sys_errorHandler>`. Default is
   4096 = :php:`E_ALL & ~(E_STRICT | E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING)`
   (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

   E_USER_DEPRECATED is always excluded to avoid exceptions to be thrown for deprecation messages.

.. index::
   TYPO3_CONF_VARS SYS; belogErrorReporting
.. _typo3ConfVars_sys_belogErrorReporting:

belogErrorReporting
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: errors
   :Default: `E_ALL & ~(E_STRICT | E_NOTICE)`

   Configures which PHP errors should be logged to the "syslog" database table
   (extension belog). If set to "0" no PHP errors are logged to the
   :sql:`sys_log` table. Default is 30711 =
   :php:`E_ALL & ~(E_STRICT | E_NOTICE)`
   (see `PHP documentation <https://www.php.net/manual/en/errorfunc.constants.php>`__).

.. index::
   TYPO3_CONF_VARS SYS; generateApacheHtaccess
.. _typo3ConfVars_sys_generateApacheHtaccess:

generateApacheHtaccess
======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['generateApacheHtaccess']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: bool
   :Default: 1

   TYPO3 can create :file:`.htaccess` files which are used by Apache Webserver.
   They are useful for access protection or performance improvements. Currently
   :file:`.htaccess` files in the following directories are created,
   if they do not exist: typo3temp/compressor/.

   You want to disable this feature, if you are not running Apache or
   want to use own rule sets.

.. index::
   TYPO3_CONF_VARS SYS; ipAnonymization
.. _typo3ConfVars_sys_ipAnonymization:

ipAnonymization
===============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['ipAnonymization']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
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

.. index::
   TYPO3_CONF_VARS SYS; systemMaintainers
.. _typo3ConfVars_sys_systemMaintainers:

systemMaintainers
=================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemMaintainers']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']
   :type: array
   :Default: null

   A list of backend user IDs allowed to access the Install Tool

.. index::
   TYPO3_CONF_VARS SYS; features
.. _typo3ConfVars_sys_features:

features
========

New features of TYPO3 that are activated on new installations but upgrading
installations may still use the old behaviour.


.. index::
   TYPO3_CONF_VARS SYS; features form.legacyUploadMimeTypes
.. _typo3ConfVars_sys_features_form.legacyUploadMimeTypes:

form.legacyUploadMimeTypes
--------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['form.legacyUploadMimeTypes']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']
   :type: bool
   :Default: true

   If on, some mime types are predefined for the "FileUpload" and "ImageUpload"
   elements of the "form" extension, which always allows file uploads of these
   types, no matter the specific form element definition.

.. index::
   TYPO3_CONF_VARS SYS; features redirects.hitCount
.. _typo3ConfVars_sys_features_redirects.hitCount:

redirects.hitCount
------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['redirects.hitCount']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']
   :type: bool
   :Default: false

   If on, and if extension "redirects" is loaded, each performed redirect is
   counted and last hit time is logged to the database.

.. index::
   TYPO3_CONF_VARS SYS; features security.backend.enforceReferrer
.. _typo3ConfVars_sys_features_security.backend.enforceReferrer:

security.backend.enforceReferrer
--------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.backend.enforceReferrer']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']
   :type: bool
   :Default: true

   If on, HTTP referrer headers are enforced for backend and install tool requests to mitigate
   potential same-site request forgery attacks. The behavior can be disabled in case HTTP proxies filter
   required referer header. As this is a potential security risk, it is recommended to enable this option.


.. index::
   TYPO3_CONF_VARS SYS; availablePasswordHashAlgorithms
.. _typo3ConfVars_sys_availablePasswordHashAlgorithms:

availablePasswordHashAlgorithms
===============================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['availablePasswordHashAlgorithms']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']
   :type: array
   :Default:

   A list of available password hash mechanisms. Extensions may register
   additional mechanisms here.


..  index::
    TYPO3_CONF_VARS SYS; lang
..  _typo3ConfVars_sys_lang:

lang
====

..  index::
    TYPO3_CONF_VARS SYS; lang requireApprovedLocalizations
..  _typo3ConfVars_sys_lang_requireApprovedLocalizations:

requireApprovedLocalizations
----------------------------

..  versionadded:: 12.0
    Before TYPO3 v12.0 all translations are taken into account when parsing XLF
    files. As of TYPO3 v12.0, only approved translations are available by
    default.

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['requireApprovedLocalizations']

    :Path: $GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['requireApprovedLocalizations']
    :type: bool
    :Default: true

    The attribute :xml:`approved` of the :ref:`XLIFF <xliff>` standard is
    respected by TYPO3 since version 12.0 when parsing XLF files. This attribute
    can either have the value :xml:`yes` or :xml:`no` and indicates whether the
    translation is final or not.

    ..  code-block:: xml
        :caption: EXT:my_extension/Resources/Private/Language/locallang.xml

        <trans-unit id="label2" resname="label2" approved="yes">
            <source>This is label #2</source>
            <target>Ceci est le libellé no. 2</target>
        </trans-unit>

    This setting can be used to control the behavior:

    :php:`true`
        Only translations with the attribute :xml:`approved` set to :xml:`yes`
        will be used. Any non-approved translation will be ignored.

    :php:`false`
        All translations are used.
