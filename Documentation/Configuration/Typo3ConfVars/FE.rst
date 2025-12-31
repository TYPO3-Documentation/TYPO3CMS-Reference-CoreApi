..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; FE
..  _typo3ConfVars_fe:

===========================
FE - frontend configuration
===========================

The following configuration variables can be used to configure settings for
the TYPO3 frontend:

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['FE']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-fe
    :display: tree
    :type:

..  _typo3ConfVars_fe_addAllowedPaths:

..  confval:: addAllowedPaths
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['addAllowedPaths']
    :name: typo3-conf-vars-fe-addAllowedPaths
    :type: list
    :Default: ''

    Additional relative paths where resources may be placed. Used in some
    frontend-related places for images and TypoScript.
    It should be prefixed with :file:`/`. If not, then any path whose the first
    part is like this path will match. That is, `myfolder/ , myarchive` will
    match, for example, :file:`myfolder/`, :file:`myarchive/`,
    :file:`myarchive_one/`, :file:`myarchive_2/`, etc.

    No check is done whether this directory actually exists in the root folder
    of the site.

..  _typo3ConfVars_fe_debug:

..  confval:: debug
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['debug']
    :name: typo3-conf-vars-fe-debug
    :type: bool
    :Default: false

    If enabled, the total parse time of the page is added as HTTP response
    header :html:`X-TYPO3-Parsetime`. This can also be enabled/disabled via the
    TypoScript option :php:`config.debug = 0`.

..  _typo3ConfVars_fe_compressionLevel:

..  confval:: compressionLevel
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['compressionLevel']
    :name: typo3-conf-vars-fe-compressionLevel
    :type: text
    :Default: 0
    :Range: 0-9

    ..  versionchanged:: 14.0

        Frontend HTTP response compression has been removed. Response compression
        should be applied by web servers and not by the application layer.

        See also: `Breaking: #108055 - Removed frontend asset concatenation and compression <https://docs.typo3.org/permalink/changelog:breaking-108055-1762346705>`_.

..  _typo3ConfVars_fe_pageNotFoundOnCHashError:

..  confval:: pageNotFoundOnCHashError
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError']
    :name: typo3-conf-vars-fe-pageNotFoundOnCHashError
    :type: bool
    :Default: true

    If TRUE, a page not found call is made when cHash evaluation error occurs,
    otherwise caching is disabled and page output is displayed.

..  _typo3ConfVars_fe_pageUnavailable_force:

..  confval:: pageUnavailable_force
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['pageUnavailable_force']
    :name: typo3-conf-vars-fe-pageUnavailable-force
    :type: bool
    :Default: false

    If :php:`TRUE`, every frontend page is shown as "unavailable". If the
    client matches :ref:`[SYS][devIPmask] <typo3ConfVars_sys_devIPmask>`, the page is
    shown as normal. This is useful during temporary site maintenance.

..  _typo3ConfVars_fe_addRootLineFields:

..  confval:: addRootLineFields
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields']
    :name: typo3-conf-vars-fe-addRootLineFields

    ..  versionchanged:: 13.2
        The option `$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields']`
        has been removed without replacement with TYPO3 13.2.

        Relations of table :sql:`pages` are now always resolved with nearly
        no performance penalty in comparison to not having them resolved.

..  _typo3ConfVars_fe_checkFeUserPid:

..  confval:: checkFeUserPid
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['checkFeUserPid']
    :name: typo3-conf-vars-fe-checkFeUserPid
    :type: bool
    :Default: true

    If set, the pid of fe_user logins must be sent in the form as the field pid
    and then the user must be located in the pid. If you unset this, you should
    change the fe_users username eval-flag uniqueInPid to unique in $TCA.

    This will do :php:`$TCA[fe_users][columns][username][config][eval]= nospace,lower,required,unique;`

..  _typo3ConfVars_fe_loginRateLimit:

..  confval:: loginRateLimit
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['loginRateLimit']
    :name: typo3-conf-vars-fe-loginRateLimit
    :type: int
    :Default: 5

    Maximum amount of login attempts for the time interval in
    :ref:`[FE][loginRateLimitInterval]<typo3ConfVars_fe_loginRateLimitInterval>`,
    before further login requests will be denied. Setting this value to
    :php:`"0"` will disable login rate limiting.

..  _typo3ConfVars_fe_loginRateLimitInterval:

..  confval:: loginRateLimitInterval
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['loginRateLimitInterval']
    :name: typo3-conf-vars-fe-loginRateLimitInterval
    :type: string, PHP relative format
    :Default: '15 minutes'
    :allowedValues: '1 minute', '5 minutes', '15 minutes', '30 minutes'

    Allowed time interval for the configured rate limit. Individual values
    using
    `PHP relative formats <https://www.php.net/manual/de/datetime.formats.relative.php>`__
    can be set in :file:`config/system/additional.php`.

..  _typo3ConfVars_fe_loginRateLimitIpExcludeList:

..  confval:: loginRateLimitIpExcludeList
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['loginRateLimitIpExcludeList']
    :name: typo3-conf-vars-fe-loginRateLimitIpExcludeList
    :type: string
    :Default: ''

    IP addresses (with :php:`*`-wildcards) that are excluded from rate limiting.
    Syntax similar to :ref:`[BE][IPmaskList]<typo3ConfVars_be_IPmaskList>`
    and :ref:`[BE][loginRateLimitIpExcludeList]<typo3ConfVars_be_loginRateLimitIpExcludeList>`.
    An empty value disables the exclude list check.

..  _typo3ConfVars_fe_lockIP:

..  confval:: lockIP
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['lockIP']
    :name: typo3-conf-vars-fe-lockIP
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

    Have also a look into the :ref:`security guidelines
    <security-global-typo3-options-lockIP>`.

..  _typo3ConfVars_fe_lockIPv6:

..  confval:: lockIPv6
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['lockIPv6']
    :name: typo3-conf-vars-fe-lockIPv6
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

..  _typo3ConfVars_fe_lifetime:

..  confval:: lifetime
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['lifetime']
    :name: typo3-conf-vars-fe-lifetime
    :type: int
    :Default: 0

    If greater than 0 and the option permalogin is greater or equal 0, the
    cookie of FE users will have a lifetime of the number of seconds this
    value indicates. Otherwise it will be a session cookie (deleted when
    browser is shut down). Setting this value to 604800 will result in automatic
    login of FE users during a whole week, 86400 will keep the FE users logged in
    for a day.

..  _typo3ConfVars_fe_sessionTimeout:

..  confval:: sessionTimeout
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['sessionTimeout']
    :name: typo3-conf-vars-fe-sessionTimeout
    :type: int
    :Default: 6000

    Server side session timeout for frontend users in seconds. Will
    be overwritten by the lifetime property if the lifetime is longer.

..  _typo3ConfVars_fe_sessionDataLifetime:

..  confval:: sessionDataLifetime
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['sessionDataLifetime']
    :name: typo3-conf-vars-fe-sessionDataLifetime
    :type: int
    :Default: 86400

    If greater than 0, the session data of an anonymous session will timeout
    and be removed after the number of seconds given
    (86400 seconds represents 24 hours).

..  _typo3ConfVars_fe_permalogin:

..  confval:: permalogin
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['permalogin']
    :name: typo3-conf-vars-fe-permalogin
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
    :ref:`[FE][lifetime] <typo3ConfVars_fe_lifetime>` lifetime is greater than 0.

..  _typo3ConfVars_fe_cookieDomain:

..  confval:: cookieDomain
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieDomain']
    :name: typo3-conf-vars-fe-cookieDomain
    :type: text
    :Default: ''

    Same as `$TYPO3_CONF_VARS[SYS][cookieDomain]<_typo3ConfVars_sys_cookieDomain>`
    but only for FE cookies. If empty, :php:`$TYPO3_CONF_VARS[SYS][cookieDomain]`
    value will be used.

..  _typo3ConfVars_fe_cookieName:

..  confval:: cookieName
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieName']
    :name: typo3-conf-vars-fe-cookieName
    :type: text
    :Default: 'fe_typo_user'

    Sets the name for the cookie used for the front-end user session

..  _typo3ConfVars_fe_cookieSameSite:

..  confval:: cookieSameSite
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieSameSite']
    :name: typo3-conf-vars-fe-cookieSameSite
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

..  _typo3ConfVars_fe_defaultTypoScript_constants:

..  confval:: defaultTypoScript_constants
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_constants']
    :name: typo3-conf-vars-fe-defaultTypoScript-constants
    :type: multiline
    :Default: ''

    Enter lines of default TypoScript, constants-field.

..  _typo3ConfVars_fe_defaultTypoScript_setup:

..  confval:: defaultTypoScript_setup
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_setup']
    :name: typo3-conf-vars-fe-defaultTypoScript-setup
    :type: multiline
    :Default: ''

    Enter lines of default TypoScript, setup-field.

..  _typo3ConfVars_fe_additionalAbsRefPrefixDirectories:

..  confval:: additionalAbsRefPrefixDirectories
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalAbsRefPrefixDirectories']
    :name: typo3-conf-vars-fe-additionalAbsRefPrefixDirectories
    :type: text
    :Default: ''

    Enter additional directories to be prepended with absRefPrefix.
    Directories must be comma-separated. TYPO3 already prepends the following
    directories :file:`public/_assets/`, :file:`public/typo3temp/` and all
    local storages including :file:`public/fileadmin/`.

    In Classic mode installations without Composer :file:`typo3conf/ext`
    and :file:`typo3/` are also prefixed.

..  _typo3ConfVars_fe_enable_mount_pids:

..  confval:: enable_mount_pids
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['enable_mount_pids']
    :name: typo3-conf-vars-fe-enable-mount-pids
    :type: bool
    :Default: true

    If enabled, the mount_pid feature allowing symlinks in the page tree
    (for frontend operation) is allowed.

..  _typo3ConfVars_fe_hidePagesIfNotTranslatedByDefault:

..  confval:: hidePagesIfNotTranslatedByDefault
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['hidePagesIfNotTranslatedByDefault']
    :name: typo3-conf-vars-fe-hidePagesIfNotTranslatedByDefault
    :type: bool
    :Default: false

    If enabled, pages that have no translation will be hidden by default.
    Basically this will inverse the effect of the page localization setting
    "Hide page if no translation for current language exists" to
    "Show page even if no translation exists"

..  _typo3ConfVars_fe_eID_include:

..  confval:: eID_include
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']
    :name: typo3-conf-vars-fe-eID-include
    :type: array
    :Default: []

    Array of key/value pairs where the key is :php:`tx_[ext]_[optional suffix]`
    and value is relative filename of class to include.
    Key is used as "?eID=" for :php:`\TYPO3\CMS\Frontend\Http\RequestHandlerRequestHandler`
    to include the code file which renders the page from that point.

    (Useful for functionality that requires a low initialization footprint,
    for example frontend Ajax applications)

..  _typo3ConfVars_fe_disableNoCacheParameter:

..  confval:: disableNoCacheParameter
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['disableNoCacheParameter']
    :name: typo3-conf-vars-fe-disableNoCacheParameter
    :type: bool
    :Default: false

    If set, the no_cache request parameter will become ineffective.
    This is currently still an experimental feature and will require a website
    only with plugins that dont use this parameter. However, using
    "&amp;no_cache=1" should be avoided anyway because there are better ways to
    disable caching for a certain part of the website
    (see `COA_INT/USER_INT<t3tsref:cobj-coa-int>`).

..  _typo3ConfVars_fe_additionalCanonicalizedUrlParameters:

..  confval:: additionalCanonicalizedUrlParameters
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters']
    :name: typo3-conf-vars-fe-additionalCanonicalizedUrlParameters
    :type: array
    :Default: []

    The given parameters will be included when calculating canonicalized URL.
    See :ref:`canonicalapi-additionalparameters` for details.

..  _typo3ConfVars_fe_cacheHash:

..  confval:: cacheHash
    :name: typo3-conf-vars-fe-cacheHash
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']

    ..  _typo3ConfVars_fe_cacheHash_cachedParametersWhiteList:

    ..  confval:: cachedParametersWhiteList
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['cachedParametersWhiteList']
        :name: typo3-conf-vars-fe-cacheHash-cachedParametersWhiteList
        :type: array
        :Default: []

        Only the given parameters will be evaluated in the cHash calculation.
        Example:

        ..  code-block:: php
            :caption: config/system/additional.php | typo3conf/system/additional.php

            $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['cachedParametersWhiteList'][] = 'tx_news_pi1[uid]';

    ..  _typo3ConfVars_fe_cacheHash_requireCacheHashPresenceParameters:

    ..  confval:: requireCacheHashPresenceParameters
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['requireCacheHashPresenceParameters']
        :name: typo3-conf-vars-fe-cacheHash-requireCacheHashPresenceParameters
        :type: array
        :Default: []

        Configure Parameters that require a cHash. If no cHash is given but one of
        the parameters are set, then TYPO3 triggers the configured cHash Error
        behaviour

    ..  _typo3ConfVars_fe_cacheHash_excludedParameters:

    ..  confval:: excludedParameters
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters']
        :name: typo3-conf-vars-fe-cacheHash-excludedParameters
        :type: array
        :Default: ['L', 'pk_campaign', 'pk_kwd', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid']

        The given parameters will be ignored in the cHash calculation.
        Example:

        ..  code-block:: php
            :caption: config/system/additional.php | typo3conf/system/additional.php

            $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'] = ['L','tx_search_pi1[query]'];

    ..  _typo3ConfVars_fe_cacheHash_excludedParametersIfEmpty:

    ..  confval:: excludedParametersIfEmpty
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParametersIfEmpty']
        :name: typo3-conf-vars-fe-cacheHash-excludedParametersIfEmpty
        :type: array
        :Default: []

        Configure Parameters that are only relevant for the cHash if there's an
        associated value available. Set excludeAllEmptyParameters to true to skip
        all empty parameters.

    ..  index::
        TYPO3_CONF_VARS FE; cacheHash excludeAllEmptyParameters
    ..  _typo3ConfVars_fe_cacheHash_excludeAllEmptyParameters:

    ..  confval:: excludeAllEmptyParameters
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludeAllEmptyParameters']
        :name: typo3-conf-vars-fe-cacheHash-excludeAllEmptyParameters
        :type: bool
        :Default: false

        If true, all parameters which are relevant for cHash are only considered
        if they are non-empty.

    ..  _typo3ConfVars_fe_cacheHash_enforceValidation:

    ..  confval:: enforceValidation
        :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['enforceValidation']
        :name: typo3-conf-vars-fe-cacheHash-enforceValidation
        :type: bool
        :Default: false (for existing installations), true (for new installations)

        If this option is enabled, the same validation is used to calculate a
        "cHash" value as when a valid or invalid "cHash" parameter is given to a
        request, even when no "cHash" is given.

        ..  note::
            The option is disabled for existing installations, but enabled for new
            installations. It is also highly recommended to enable this option in
            your existing installations as well.

        **Details:**

        Since TYPO3 v9 and the :ref:`PSR-15 middleware concept <request-handling>`,
        cHash validation has been moved outside of plugins and rendering code inside
        a validation middleware to check if a given "cHash" acts as a signature of
        other query parameters in order to use a cached version of a frontend page.

        However, the check only provided information about an invalid "cHash" in the
        query parameters. If no "cHash" was given, the only option was to add a
        "required list" (global TYPO3 configuration option
        :ref:`requireCacheHashPresenceParameters <typo3ConfVars_fe_cacheHash_requireCacheHashPresenceParameters>`),
        but not based on the final
        :ref:`excludedParameters <typo3ConfVars_fe_cacheHash_excludedParameters>`
        for the cache hash calculation of the given query parameters.


..  index::
    TYPO3_CONF_VARS FE; workspacePreviewLogoutTemplate
..  _typo3ConfVars_fe_workspacePreviewLogoutTemplate:

..  confval:: workspacePreviewLogoutTemplate
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['workspacePreviewLogoutTemplate']
    :name: typo3-conf-vars-fe-workspacePreviewLogoutTemplate
    :type: text
    :Default: ''

    If set, points to an HTML file relative to the TYPO3_site root which will be
    read and outputted as template for this message. Example
    :file:`fileadmin/templates/template_workspace_preview_logout.html`.

    Inside you can put the marker :html:`%1$s` to insert the URL to go back to.
    Use this in :html:`<a href="%1$s">Go back...</a>` links.

..  index::
    TYPO3_CONF_VARS FE; versionNumberInFilename
..  _typo3ConfVars_fe_versionNumberInFilename:

..  confval:: versionNumberInFilename
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['versionNumberInFilename']
    :name: typo3-conf-vars-fe-versionNumberInFilename
    :type: bool
    :Default: false

    If enabled, included CSS and JS files loaded in the TYPO3 frontend will
    have the timestamp embedded in the filename, for example,
    :php:`filename.1676276352.js`. This will make browsers and proxies reload
    the files, if they change (thus avoiding caching issues).

    ..  attention::
        This feature requires extra :file:`.htaccess` rules to work (please
        refer to the :t3src:`install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
        file shipped with TYPO3).

    If disabled, the last modification date of the file will be appended as a
    query string.


..  index::
    TYPO3_CONF_VARS FE; contentRenderingTemplates
..  _typo3ConfVars_fe_contentRenderingTemplates:

..  confval:: contentRenderingTemplates
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates']
    :name: typo3-conf-vars-fe-contentRenderingTemplates
    :type: array
    :Default: []

    Array to define the TypoScript parts that define the main content rendering.

    Extensions like :file:`fluid_styled_content` provide content rendering
    templates. Other extensions like :file:`felogin` or :file:`indexed search`
    extend these templates and their TypoScript parts are added directly after
    the content templates.

    See :file:`EXT:fluid_styled_content/ext_localconf.php` and
    :file:`EXT:core/Classes/TypoScript/IncludeTree/TreeBuilder.php`

..  index::
    TYPO3_CONF_VARS FE; typolinkBuilder
..  _typo3ConfVars_fe_typolinkBuilder:

..  confval:: typolinkBuilder
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']
    :name: typo3-conf-vars-fe-typolinkBuilder
    :type: array

    Matches the LinkService implementations for generating URLs and link texts
    via typolink. This configuration value can be used to register a
    :ref:`custom link builder <tutorial-typolink-builder>` for the frontend
    generation of links.

    ..  code-block:: php
        :caption: Default value of $GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']

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

..  index::
    TYPO3_CONF_VARS FE; passwordHashing
..  _typo3ConfVars_fe_passwordHashing:

..  confval:: passwordHashing


..  index::
    TYPO3_CONF_VARS FE; passwordHashing className
..  _typo3ConfVars_fe_passwordHashing_className:

..  confval:: className
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['className']
    :name: typo3-conf-vars-fe-className
    :type: string
    :Default: :php:`\TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class`
    :allowedValues:
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


..  index::
    TYPO3_CONF_VARS FE; passwordHashing options
..  _typo3ConfVars_fe_passwordHashing_options:

..  confval:: options
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['options']
    :name: typo3-conf-vars-fe-options
    :type: array
    :Default: []

    Special settings for specific hashes.


..  index::
    TYPO3_CONF_VARS FE; passwordPolicy
..  _typo3ConfVars_fe_passwordPolicy:

..  confval:: passwordPolicy
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy']
    :name: typo3-conf-vars-fe-passwordPolicy
    :type: string
    :Default: default

    Defines the :ref:`password policy <password-policies>` in frontend context.


..  index::
    TYPO3_CONF_VARS FE; exposeRedirectInformation
..  _typo3ConfVars_fe_exposeRedirectInformation:

..  confval:: exposeRedirectInformation
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['exposeRedirectInformation']
    :name: typo3-conf-vars-fe-exposeRedirectInformation
    :type: bool
    :Default: false

    If set, redirects executed by TYPO3 publicly expose the page ID in the HTTP
    header. As this is an internal information about the TYPO3 system, it should
    only be enabled for debugging purposes.

..  index::
    TYPO3_CONF_VARS FE; contentSecurityPolicyReportingUrl
..  _typo3ConfVars_fe_contentSecurityPolicyReportingUrl:

..  confval:: contentSecurityPolicyReportingUrl
    :Path: $GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl']
    :name: typo3-conf-vars-fe-contentSecurityPolicyReportingUrl
    :type: string
    :Default: ''

    Configure the reporting HTTP endpoint of
    :ref:`Content Security Policy <content-security-policy>` violations in the
    frontend; if it is empty, the TYPO3 endpoint will be used.

    Setting this configuration to `'0'` disables Content Security Policy
    reporting. If the endpoint is still called then, the
    server-side process responds with a 403 HTTP error message.

    If defined, the :ref:`site-specific configuration <content-security-policy-site-endpoints>`
    in :file:`config/sites/my_site/csp.yaml` takes precedence over the global configuration.

    ..  code-block:: php
        :caption: config/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl']
            = 'https://csp-violation.example.org/';

    ..  code-block:: php
        :caption: config/system/additional.php

        // Disables Content Security Policy reporting
        $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl'] = '0';


    Use :ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl'] <t3coreapi:confval-globals-typo3-conf-vars-be-contentSecurityPolicyReportingUrl>`
    to configure Content Security Policy reporting for the backend.
