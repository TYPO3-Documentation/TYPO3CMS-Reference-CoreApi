..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; HTTP
    TYPO3_CONF_VARS HTTP
..  _typo3ConfVars_http:

====================
HTTP - tune requests
====================

HTTP configuration to tune how TYPO3 behaves on HTTP requests made by TYPO3.
See `Guzzle documentation <https://docs.guzzlephp.org/en/latest/request-options.html>`__
for more background information on many of those settings.

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['HTTP']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-http
    :display: tree
    :type:

..  _typo3ConfVars_http_allow_redirects:

..  confval:: allow_redirects
    :name: globals-typo3-conf-vars-sys-http-allow_redirects
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['allow_redirects']
    :type: mixed

    Mixed, set to false if you want to disallow redirects, or use it as an
    array to add more configuration values (see below).

    ..  _typo3ConfVars_http_allow_redirects_strict:

    ..  confval:: strict
        :name: globals-typo3-conf-vars-sys-http-allow_redirects-strict
        :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['allow_redirects']['strict']
        :type: bool
        :Default: false

        Whether to keep request method on redirects via status 301 and 302

        :php:`TRUE`
            Strict RFC compliant redirects mean that POST redirect requests are
            sent as POST requests. This is needed for compatibility with
            `RFC 2616 <http://www.faqs.org/rfcs/rfc2616>`__)
        :php:`FALSE`
            redirect POST requests with GET requests,
            needed for compatibility with most browsers

    ..  _typo3ConfVars_http_allow_redirects_max:

    ..  confval:: max
        :name: globals-typo3-conf-vars-sys-http-allow_redirects-max
        :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['allow_redirects']['max']
        :type: int
        :Default: 5

        Maximum number of tries before an exception is thrown.

..  _typo3ConfVars_http_allowed_hosts:


..  confval:: allowed_hosts
    :name: globals-typo3-conf-vars-sys-http-allowed_hosts
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['allowed_hosts']
    :type: array / null

    ..  versionadded:: 13.4.12 / 12.4.31
        This property has been added with the security fix
        `Important: #106229 - Allow filtering request hosts in webhook messages
        <https://docs.typo3.org/permalink/changelog:important-106229-1747304339>`_.

    This option is not passed on to guzzle. Instead, it configures
    an array of allowed hosts to interact with TYPO3.

    ..  _typo3ConfVars_http_allowed_hosts_webhooks:

    ..  confval:: webhooks
        :name: globals-typo3-conf-vars-sys-http-allowed_hosts-webhooks
        :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['allowed_hosts']['webhooks']
        :type: array / null
        :Default: null

        For now, the only supported array key is `webhooks` to configure an array
        of allowed hostnames that webhooks of `EXT:webhooks`are allowed to connect to
        (see :issue:`106229` as a protection against DNS rebinding).

        Wildcards in the array values are allowed, like `*.example.com`.

        An empty array is allowed, but in that case it is better to actually remove
        the `EXT:webhooks` extension (all hosts are blocked).

        Setting this option to null (or having it unset) is the default,
        and will allow any connection.

..  _typo3ConfVars_http_cert:

..  confval:: cert
    :name: globals-typo3-conf-vars-sys-http-cert
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['cert']
    :type: mixed
    :Default: null

    Set to a string to specify the path to a file containing a
    PEM formatted client side certificate. See
    `Guzzle option cert <https://docs.guzzlephp.org/en/latest/request-options.html#cert>`__

..  _typo3ConfVars_http_connect_timeout:

..  confval:: connect_timeout
    :name: globals-typo3-conf-vars-sys-http-connect_timeout
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['connect_timeout']
    :type: int
    :Default: 10

    Default timeout for connection in seconds. Exception will be thrown if
    connecting to a remote host

..  _typo3ConfVars_http_proxy:

..  confval:: proxy
    :name: globals-typo3-conf-vars-sys-http-proxy
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['proxy']
    :type: mixed
    :Default: null

    Enter a single proxy server as string, for example :php:`'proxy.example.org'`

    Multiple proxies for different protocols can be added separately as an
    array as authentication and port; see
    `Guzzle documentation <https://docs.guzzlephp.org/en/latest/request-options.html#proxy>`__
    for details.

    The configuration with an array must be made in the
    :file:`config/system/additional.php`; see :ref:`typo3ConfVars-additional`
    for details.

..  _typo3ConfVars_http_ssl_key:

..  confval:: ssl_key
    :name: globals-typo3-conf-vars-sys-http-ssl_key
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['ssl_key']
    :type: mixed
    :Default: null

    Local certificate and an optional passphrase, see
    `Guzzle option ssl-key <https://docs.guzzlephp.org/en/latest/request-options.html#ssl-key>`__

..  _typo3ConfVars_http_timeout:

..  confval:: timeout
    :name: globals-typo3-conf-vars-sys-http-timeout
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['timeout']
    :type: int
    :Default: 0

    Default timeout for whole request. Exception will be thrown if sending the
    request takes more than this number of seconds.

    Should be greater than the
    :ref:`connection timeout<typo3ConfVars_http_connect_timeout>` or
    :php:`0` to not set a limit.

..  _typo3ConfVars_http_verify:

..  confval:: verify
    :name: globals-typo3-conf-vars-sys-http-verify
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['verify']
    :type: mixed
    :Default: true

    Describes the SSL certificate verification behavior of a request, see
    `Guzzle option verify <https://docs.guzzlephp.org/en/latest/request-options.html#verify>`__

..  _typo3ConfVars_http_version:

..  confval:: version
    :name: globals-typo3-conf-vars-sys-http-version
    :Path: $GLOBALS['TYPO3_CONF_VARS']['HTTP']['version']
    :type: text
    :Default: '1.1'

    Default HTTP protocol version. Use either "1.0" or "1.1".
