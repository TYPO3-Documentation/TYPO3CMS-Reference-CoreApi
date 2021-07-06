.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; FE
.. _typo3ConfVars_fe:

=================================
$GLOBALS['TYPO3_CONF_VARS']['FE']
=================================

.. index::
   TYPO3_CONF_VARS FE; addAllowedPaths
.. _typo3ConfVars_fe_addAllowedPaths:

$GLOBALS['TYPO3_CONF_VARS']['FE']['addAllowedPaths']
====================================================

.. confval:: addAllowedPaths

   :type: list
   :Default: ''

   Additional relative paths (comma-list) to allow TypoScript resources be in.
   Should be prepended with /. If not, then any path where the first part is
   like this path will match. That is myfolder/ , myarchive will match
   for example myfolder/, myarchive/, myarchive_one/, myarchive_2/ ...

   No check is done to see if this directory actually exists in the
   root of the site. Paths are matched by simply checking if these strings
   equals the first part of any TypoScript resource filepath.

   (See class template, function init() in
   :php:`\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser`)

.. index::
   TYPO3_CONF_VARS FE; debug
.. _typo3ConfVars_fe_debug:

$GLOBALS['TYPO3_CONF_VARS']['FE']['debug']
==========================================

.. confval:: debug

   :type: bool
   :Default: false

   If enabled, the total parse time of the page is added as HTTP response
   header :html:`X-TYPO3-Parsetime`. This can also be enabled/disabled via the
   TypoScript option :php:`config.debug = 0`.

.. index::
   TYPO3_CONF_VARS FE; compressionLevel
.. _typo3ConfVars_fe_compressionLevel:

$GLOBALS['TYPO3_CONF_VARS']['FE']['compressionLevel']
=====================================================

.. confval:: compressionLevel

   :type: int
   :Default: 0

   Determines output compression of FE output. Makes output smaller but
   slows down the page generation depending on the compression level. Requires
   zlib in your PHP installation. Range 1-9, where 1 is least compression and
   9 is greatest compression. true as value will set the compression based on
   the PHP default settings (usually 5). Suggested and most optimal value is 5.

.. index::
   TYPO3_CONF_VARS FE; pageNotFoundOnCHashError
.. _typo3ConfVars_fe_pageNotFoundOnCHashError:

$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError']
=============================================================

.. confval:: pageNotFoundOnCHashError

   :type: bool
   :Default: true

   If TRUE, a page not found call is made when cHash evaluation error occurs,
   otherwise caching is disabled and page output is displayed.

.. index::
   TYPO3_CONF_VARS FE; pageUnavailable_force
.. _typo3ConfVars_fe_pageUnavailable_force:

$GLOBALS['TYPO3_CONF_VARS']['FE']['pageUnavailable_force']
==========================================================

.. confval:: pageUnavailable_force

   :type: bool
   :Default: false

   If :php:`TRUE`, every frontend page is shown as "unavailable". If the
   client matches :ref:`[SYS][devIPmask] <typo3ConfVars_sys_devIPmask>`, the page is
   shown as normal. This is useful during temporary site maintenance.

.. index::
   TYPO3_CONF_VARS FE; addRootLineFields
.. _typo3ConfVars_fe_addRootLineFields:

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields']
======================================================

.. confval:: addRootLineFields

   :type: list
   :Default: ''

   Comma-list of fields from the pages-table. These fields are added to the
   select query for fields in the rootline.

.. index::
   TYPO3_CONF_VARS FE; checkFeUserPid
.. _typo3ConfVars_fe_checkFeUserPid:

$GLOBALS['TYPO3_CONF_VARS']['FE']['checkFeUserPid']
===================================================

.. confval:: checkFeUserPid

   :type: bool
   :Default: true

   If set, the pid of fe_user logins must be sent in the form as the field pid
   and then the user must be located in the pid. If you unset this, you should
   change the fe_users username eval-flag uniqueInPid to unique in $TCA.

   This will do :php:`$TCA[fe_users][columns][username][config][eval]= nospace,lower,required,unique;`

.. index::
   TYPO3_CONF_VARS FE; lockIP
.. _typo3ConfVars_fe_lockIP:

$GLOBALS['TYPO3_CONF_VARS']['FE']['lockIP']
===========================================

.. confval:: lockIP

   :type: int
   :Default: 0
   :allowedValues:
      0
         Default Do not lock Frontend User sessions to their IP address at all
      1
         Use the first part of the visitors IPv4 address (for example "192.") as part
         of the session locking of Frontend Users
      2
         Use the first two parts of the visitors IPv4 address (for example "192.168")
         as part of the session locking of Frontend Users
      3
         Use the first three parts of the visitors IPv4 address
         (for example "192.168.13") as part of the session locking of Frontend Users
      4
         Use the visitors full IPv4 address (for example "192.168.13.84") as part of
         the session locking of Frontend Users (highest security)

   If activated, Frontend Users are locked to (a part of) their public IP
   (:php:`$_SERVER[REMOTE_ADDR]`) for their session, if REMOTE_ADDR is an
   IPv4-address. Enhances security but may throw off users that may change IP
   during their session (in which case you can lower it). The integer indicates
   how many parts of the IP address to include in the check for the session.

.. index::
   TYPO3_CONF_VARS FE; lockIPv6
.. _typo3ConfVars_fe_lockIPv6:

$GLOBALS['TYPO3_CONF_VARS']['FE']['lockIPv6']
====================================================

.. confval:: lockIPv6

   :type: int
   :Default: 0
   :allowedValues:
      0
         Default: Do not lock Backend User sessions to their IP address at all
      1
         Use the first block (16 bits) of the editors IPv6 address
         (for example "2001") as part of the session locking of Backend Users
      2
         Use the first two blocks (32 bits) of the editors IPv6 address
         (for example "20010db8") as part of the session locking of Backend Users
      3
         Use the first three blocks (48 bits) of the editors IPv6 address
         (for example "20010db885a3") as part of the session locking of Backend Users
      4
         Use the first four blocks (64 bits) of the editors IPv6 address
         (for example "20010db885a308d3") as part of the session locking of
         Backend Users
      5
         Use the first five blocks (80 bits) of the editors IPv6 address
         (for example "20010db885a308d31319") as part of the session locking of
         Backend Users
      6
         Use the first six blocks (96 bits) of the editors IPv6 address
         (for example "20010db885a308d313198a2e") as part of the session locking of
         Backend Users
      7
         Use the first seven blocks (112 bits) of the editors IPv6 address
         (for example "20010db885a308d313198a2e0370") as part of the session locking of
         Backend Users
      8
         Use the visitors full IPv6 address
         (for example "20010db885a308d313198a2e03707344") as part of the session
         locking of Backend Users (highest security)

   If activated, Frontend Users are locked to (a part of) their public IP (
   :php:`$_SERVER[REMOTE_ADDR]`) for their session, if REMOTE_ADDR is an
   IPv6-address. Enhances security but may throw off users that may change IP
   during their session (in which case you can lower it).
   The integer indicates how many parts of the IP address to include in the check for the session.

.. index::
   TYPO3_CONF_VARS FE; loginSecurityLevel
.. _typo3ConfVars_fe_loginSecurityLevel:

$GLOBALS['TYPO3_CONF_VARS']['FE']['loginSecurityLevel']
=======================================================

.. deprecated:: 11.3
   This option got removed with version 11.3. The only possible
   value has been 'normal'. This behaviour stays unchanged.  When this option
   has been set in your :file:`LocalConfiguration.php`
   or :file:`AdditionalConfiguration.php` files, they are automatically
   removed when accessing the admin tool or system maintenance area.

.. index::
   TYPO3_CONF_VARS FE; lifetime
.. _typo3ConfVars_fe_lifetime:

$GLOBALS['TYPO3_CONF_VARS']['FE']['lifetime']
=============================================

.. confval:: lifetime

   :type: int
   :Default: 0

   If greater then 0 and the option permalogin is greater or equal 0, the
   cookie of FE users will have a lifetime of the number of seconds this
   value indicates. Otherwise it will be a session cookie (deleted when
   browser is shut down). Setting this value to 604800 will result in automatic
   login of FE users during a whole week, 86400 will keep the FE users logged in
   for a day.

.. index::
   TYPO3_CONF_VARS FE; sessionTimeout
.. _typo3ConfVars_fe_sessionTimeout:

$GLOBALS['TYPO3_CONF_VARS']['FE']['sessionTimeout']
====================================================

.. confval:: sessionTimeout

   :type: int
   :Default: 6000

   Server side session timeout for frontend users in seconds. Will
   be overwritten by the lifetime property if the lifetime is longer.

.. index::
   TYPO3_CONF_VARS FE; sessionDataLifetime
.. _typo3ConfVars_fe_sessionDataLifetime:

$GLOBALS['TYPO3_CONF_VARS']['FE']['sessionDataLifetime']
========================================================

.. confval:: sessionDataLifetime

   :type: int
   :Default: 86400

   If greater then 0, the session data of an anonymous session will timeout
   and be removed after the number of seconds given
   (86400 seconds represents 24 hours).

.. index::
   TYPO3_CONF_VARS FE; permalogin
.. _typo3ConfVars_fe_permalogin:

$GLOBALS['TYPO3_CONF_VARS']['FE']['permalogin']
===============================================

.. confval:: permalogin

   :type: text
   :Default: 0

   -1
      Permanent login for FE users is disabled

   0
      By default permalogin is disabled for FE users but can be enabled by a
      form control in the login form.

   1
      Permanent login is by default enabled but can be disabled by a form
      control in the login form.

   2
      Permanent login is forced to be enabled.

   In any case, permanent login is only possible if
   :ref:`[FE][lifetime] <typo3ConfVars_fe_lifetime>` lifetime is greater then 0.

.. index::
   TYPO3_CONF_VARS FE; cookieDomain
.. _typo3ConfVars_fe_cookieDomain:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cookieDomain']
=================================================

.. confval:: cookieDomain

   :type: text
   :Default: ''

   Same as `$TYPO3_CONF_VARS[SYS][cookieDomain]<_typo3ConfVars_sys_cookieDomain>`
   but only for FE cookies. If empty, :php:`$TYPO3_CONF_VARS[SYS][cookieDomain]`
   value will be used.

.. index::
   TYPO3_CONF_VARS FE; cookieName
.. _typo3ConfVars_fe_cookieName:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cookieName']
===============================================

.. confval:: cookieName

   :type: text
   :Default: 'fe_typo_user'

    Sets the name for the cookie used for the front-end user session

.. index::
   TYPO3_CONF_VARS FE; cookieSameSite
.. _typo3ConfVars_fe_cookieSameSite:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cookieSameSite']
===================================================

.. confval:: cookieSameSite

   :type: text
   :Default: 'lax'
   :allowedValues:
      lax
         Cookies set by TYPO3 are only available for the current site,
         third-party integrations are not allowed to read cookies, except for links and simple HTML forms
      strict
         Cookies sent by TYPO3 are only available for the current site, never
         shared to other third-party packages
      none
         Allow cookies set by TYPO3 to be sent to other sites as well, please
         note - this only works with HTTPS connections

   Indicates that the cookie should send proper information where the cookie
   can be shared (first-party cookies vs. third-party cookies) in TYPO3 Frontend.

.. index::
   TYPO3_CONF_VARS FE; defaultUserTSconfig
.. _typo3ConfVars_fe_defaultUserTSconfig:

$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultUserTSconfig']
========================================================

.. confval:: defaultUserTSconfig

   :type: multiline
   :Default: ''

    Enter lines of default frontend user/group TSconfig.

.. index::
   TYPO3_CONF_VARS FE; defaultTypoScript_constants
.. _typo3ConfVars_fe_defaultTypoScript_constants:

$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_constants']
================================================================

.. confval:: defaultTypoScript_constants

   :type: multiline
   :Default: ''

    Enter lines of default TypoScript, constants-field.

.. index::
   TYPO3_CONF_VARS FE; defaultTypoScript_setup
.. _typo3ConfVars_fe_defaultTypoScript_setup:

$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_setup']
============================================================

.. confval:: defaultTypoScript_setup

   :type: multiline
   :Default: ''

    Enter lines of default TypoScript, setup-field.

.. index::
   TYPO3_CONF_VARS FE; additionalAbsRefPrefixDirectories
.. _typo3ConfVars_fe_additionalAbsRefPrefixDirectories:

$GLOBALS['TYPO3_CONF_VARS']['FE']['additionalAbsRefPrefixDirectories']
======================================================================

.. confval:: additionalAbsRefPrefixDirectories

   :type: text
   :Default: ''

   Enter additional directories to be prepended with absRefPrefix.
   Directories must be comma-separated. TYPO3 already prepends the following
   directories typo3/, typo3temp/, typo3conf/ext/ and all local storages

.. index::
   TYPO3_CONF_VARS FE; enable_mount_pids
.. _typo3ConfVars_fe_enable_mount_pids:

$GLOBALS['TYPO3_CONF_VARS']['FE']['enable_mount_pids']
======================================================

.. confval:: enable_mount_pids

   :type: bool
   :Default: true

   If enabled, the mount_pid feature allowing symlinks in the page tree
   (for frontend operation) is allowed.

.. index::
   TYPO3_CONF_VARS FE; hidePagesIfNotTranslatedByDefault
.. _typo3ConfVars_fe_hidePagesIfNotTranslatedByDefault:

$GLOBALS['TYPO3_CONF_VARS']['FE']['hidePagesIfNotTranslatedByDefault']
======================================================================

.. confval:: hidePagesIfNotTranslatedByDefault

   :type: bool
   :Default: false

   If enabled, pages that have no translation will be hidden by default.
   Basically this will inverse the effect of the page localization setting
   "Hide page if no translation for current language exists" to
   "Show page even if no translation exists"


.. index::
   TYPO3_CONF_VARS FE; eID_include
.. _typo3ConfVars_fe_eID_include:

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']
================================================

.. confval:: eID_include

   :type: array
   :Default: []

   Array of key/value pairs where the key is :php:`tx_[ext]_[optional suffix]`
   and value is relative filename of class to include.
   Key is used as "?eID=" for :php:`\TYPO3\CMS\Frontend\Http\RequestHandlerRequestHandler`
   to include the code file which renders the page from that point.

   (Useful for functionality that requires a low initialization footprint,
   for example frontend ajax applications)


.. index::
   TYPO3_CONF_VARS FE; disableNoCacheParameter
.. _typo3ConfVars_fe_disableNoCacheParameter:

$GLOBALS['TYPO3_CONF_VARS']['FE']['disableNoCacheParameter']
============================================================

.. confval:: disableNoCacheParameter

   :type: bool
   :Default: false

   If set, the no_cache request parameter will become ineffective.
   This is currently still an experimental feature and will require a website
   only with plugins that dont use this parameter. However, using
   "&amp;no_cache=1" should be avoided anyway because there are better ways to
   disable caching for a certain part of the website
   (see `COA_INT/USER_INT<t3tsref:cobj-coa-int>`).

.. index::
   TYPO3_CONF_VARS FE; additionalCanonicalizedUrlParameters
.. _typo3ConfVars_fe_additionalCanonicalizedUrlParameters:

$GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters']
=========================================================================

.. confval:: additionalCanonicalizedUrlParameters

   :type: array
   :Default: []

   The given parameters will be included when calculating canonicalized URL


.. index::
   TYPO3_CONF_VARS FE; cacheHash
.. _typo3ConfVars_fe_cacheHash:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']
==============================================

.. index::
   TYPO3_CONF_VARS FE; cacheHash cachedParametersWhiteList
.. _typo3ConfVars_fe_cacheHash_cachedParametersWhiteList:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['cachedParametersWhiteList']
___________________________________________________________________________

.. confval:: cachedParametersWhiteList:

   :type: array
   :Default: []

   Only the given parameters will be evaluated in the cHash calculation.
   Example::

      tx_news_pi1[uid]

.. index::
   TYPO3_CONF_VARS FE; cacheHash requireCacheHashPresenceParameters
.. _typo3ConfVars_fe_cacheHash_requireCacheHashPresenceParameters:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['requireCacheHashPresenceParameters']
____________________________________________________________________________________

.. confval:: requireCacheHashPresenceParameters

   :type: array
   :Default: []

   Configure Parameters that require a cHash. If no cHash is given but one of
   the parameters are set, then TYPO3 triggers the configured cHash Error
   behaviour

.. index::
   TYPO3_CONF_VARS FE; cacheHash excludedParameters
.. _typo3ConfVars_fe_cacheHash_excludedParameters:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters']
____________________________________________________________________

.. confval:: excludedParameters

   :type: array
   :Default: ['L', 'pk_campaign', 'pk_kwd', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid']

   The given parameters will be ignored in the cHash calculation.
   Example::

      L,tx_search_pi1[query]

.. index::
   TYPO3_CONF_VARS FE; cacheHash excludedParametersIfEmpty
.. _typo3ConfVars_fe_cacheHash_excludedParametersIfEmpty:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParametersIfEmpty']
___________________________________________________________________________

.. confval:: excludedParametersIfEmpty

   :type: array
   :Default: []

   Configure Parameters that are only relevant for the cHash if there's an
   associated value available. Set excludeAllEmptyParameters to true to skip
   all empty parameters.

.. index::
   TYPO3_CONF_VARS FE; cacheHash excludeAllEmptyParameters
.. _typo3ConfVars_fe_cacheHash_excludeAllEmptyParameters:

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludeAllEmptyParameters']
___________________________________________________________________________

.. confval:: excludeAllEmptyParameters

   :type: bool
   :Default: false

   If true, all parameters which are relevant for cHash are only considered
   if they are non-empty.

.. index::
   TYPO3_CONF_VARS FE; workspacePreviewLogoutTemplate
.. _typo3ConfVars_fe_workspacePreviewLogoutTemplate:

$GLOBALS['TYPO3_CONF_VARS']['FE']['workspacePreviewLogoutTemplate']
===================================================================

.. confval:: workspacePreviewLogoutTemplate

   :type: text
   :Default: ''

   If set, points to an HTML file relative to the TYPO3_site root which will be
   read and outputted as template for this message. Example
   :file:`fileadmin/templates/template_workspace_preview_logout.html`.

   Inside you can put the marker :html:`%1$s` to insert the URL to go back to.
   Use this in :html:`<a href="%1$s">Go back...</a>` links.

.. index::
   TYPO3_CONF_VARS FE; versionNumberInFilename
.. _typo3ConfVars_fe_versionNumberInFilename:

$GLOBALS['TYPO3_CONF_VARS']['FE']['versionNumberInFilename']
============================================================

.. confval:: versionNumberInFilename

   :type: dropdown
   :Default: 'querystring'
   :allowedValues:
      ''
         "Do not include the version/timestamp of the file at all"
      'embed'
         Include the timestamp of the last modification timestamp of files
         embedded in the filename - for example :file:`filename.1269312081.js`
      'querystring'
         Default - Append the last modification timestamp of the file as
         query string for example :file:`filename.js?1269312081`


   Allows to automatically include a version number (timestamp of the file)
   to referred CSS and JS filenames on the rendered page. This will make
   browsers and proxies reload the files if they change (thus avoiding
   caching issues).

   **IMPORTANT** embed requires extra :file:`.htaccess` rules to work
   (please refer to the :file:`root-htaccess` file shipped with TYPO3 in
   :file:`typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles`)


.. index::
   TYPO3_CONF_VARS FE; contentRenderingTemplates
.. _typo3ConfVars_fe_contentRenderingTemplates:

$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates']
==============================================================

.. confval:: contentRenderingTemplates

   :type: array
   :Default: []

   Array to define the TypoScript parts that define the main content rendering.

   Extensions like :file:`fluid_styled_content` provide content rendering
   templates. Other extensions like :file:`felogin` or :file:`indexed search`
   extend these templates and their TypoScript parts are added directly after
   the content templates.

   See :file:`EXT:fluid_styled_content/ext_localconf.php` and
   :file:`EXT:frontend/Classes/TypoScript/TemplateService.php`

.. index::
   TYPO3_CONF_VARS FE; ContentObjects
.. _typo3ConfVars_fe_ContentObjects:

$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']
===================================================

.. confval:: ContentObjects

   :type: array
   :Default: []

   Array to register ContentObjects (cObjects) like :typoscript:`TEXT` or
   :typoscript:`HMENU` within :file:`ext_localconf.php`,
   see :file:`EXT:frontend/ext_localconf.php`


.. index::
   TYPO3_CONF_VARS FE; typolinkBuilder
.. _typo3ConfVars_fe_typolinkBuilder:

$GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']
====================================================

.. confval:: typolinkBuilder

   :type: array

   Matches the LinkService implementations for generating URL, link text via typolink

   Default::

      [
            'page' => \TYPO3\CMS\Frontend\Typolink\PageLinkBuilder::class,
            'file' => \TYPO3\CMS\Frontend\Typolink\FileOrFolderLinkBuilder::class,
            'folder' => \TYPO3\CMS\Frontend\Typolink\FileOrFolderLinkBuilder::class,
            'url' => \TYPO3\CMS\Frontend\Typolink\ExternalUrlLinkBuilder::class,
            'email' => \TYPO3\CMS\Frontend\Typolink\EmailLinkBuilder::class,
            'record' => \TYPO3\CMS\Frontend\Typolink\DatabaseRecordLinkBuilder::class,
            'telephone' => \TYPO3\CMS\Frontend\Typolink\TelephoneLinkBuilder::class,
            'unknown' => \TYPO3\CMS\Frontend\Typolink\LegacyLinkBuilder::class,
        ]

.. index::
   TYPO3_CONF_VARS FE; passwordHashing
.. _typo3ConfVars_fe_passwordHashing:

$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']
====================================================


.. index::
   TYPO3_CONF_VARS FE; passwordHashing className
.. _typo3ConfVars_fe_passwordHashing_className:

$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['className']
_________________________________________________________________

.. confval:: className

   :type: text
   :Default: :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class`
   :allowedValues:
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash'
         Good password hash mechanism. Used by default if available.
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2idPasswordHash'
         Good password hash mechanism.
      'TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash'
         Good password hash mechanism.
      'TYPO3\CMS\Core\Crypto\PasswordHashing\Pbkdf2PasswordHash'
         Fallback hash mechanism if argon and bcrypt are not available.
      'TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash'
         Fallback hash mechanism if none of the above are available.


.. index::
   TYPO3_CONF_VARS FE; passwordHashing options
.. _typo3ConfVars_fe_passwordHashing_options:

$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['options']
_______________________________________________________________

.. confval:: options

   :type: array
   :Default: []

   Special settings for specific hashes.


.. index::
   TYPO3_CONF_VARS FE; exposeRedirectInformation
.. _typo3ConfVars_fe_exposeRedirectInformation:

$GLOBALS['TYPO3_CONF_VARS']['FE']['exposeRedirectInformation']
==============================================================

.. confval:: exposeRedirectInformation

   :type: bool
   :Default: false

   If set, redirects executed by TYPO3 publicly expose the page ID in the HTTP
   header. As this is an internal information about the TYPO3 system, it should
   only be enabled for debugging purposes.
