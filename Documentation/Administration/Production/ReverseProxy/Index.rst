:navigation-title: Reverse Proxy

..  include:: /Includes.rst.txt
..  _reverse-proxy-setup:

=====================================================
Running TYPO3 behind a reverse proxy or load balancer
=====================================================

When running TYPO3 behind a reverse proxy or load balancer in a production
environment, you may encounter issues that are difficult to reproduce in a
local setup.

Please refer to the documentation of that server on what exact settings are needed.

..  contents:: Table of contents

..  _proxy-explanation:

Proxy and Reverse Proxy
=======================

Proxy
-----

A proxy server acts as an intermediary between client devices (such as web
browsers) and the internet. It processes requests from clients seeking resources
from other servers. The primary use cases include:

*   Privacy and anonymity by masking client IP addresses
*   Access control and content filtering
*   Caching frequently requested resources
*   Bypassing geographic restrictions

Difference Between Proxy and Reverse Proxy
------------------------------------------

While both types act as intermediaries, they serve different purposes:

*   **Forward Proxy (Standard Proxy)**:

    *   Sits in front of clients
    *   Helps clients access external resources
    *   Primarily client-focused
    *   Masks client identity from servers

*   **Reverse Proxy**:

    *   Sits in front of servers
    *   Handles incoming requests to backend servers
    *   Server-focused
    *   Masks server identity from clients

Benefits of a Reverse Proxy
---------------------------

Implementing a reverse proxy with TYPO3 offers several advantages:

#.  **Load Balancing**:

    *   Distributes incoming traffic across multiple TYPO3 instances
    *   Ensures high availability and optimal resource utilization

#.  **Enhanced Security**:

    *   Acts as a shield for backend TYPO3 servers
    *   Prevents direct access to backend infrastructure
    *   Provides additional layer for DDoS protection

#.  **SSL/TLS Termination**:

    *   Handles HTTPS encryption/decryption
    *   Reduces computational load on backend TYPO3 servers

#.  **Caching**:

    *   Caches static content
    *   Reduces load on TYPO3 backend servers
    *   Improves response times

Importance of Protocol Detection
--------------------------------

TYPO3 needs to accurately determine whether the original client connection was
HTTPS for several critical system functions. This information affects multiple
core functionalities:

Security Features
~~~~~~~~~~~~~~~~~

*   **Cookie Security**: Determines whether secure cookies should be set
*   **Form Security**: Influences CSRF token handling and form security measures
*   **Environment Detection**: Powers :php:`Environment::isHttps()` checks

URL Generation
~~~~~~~~~~~~~~

*   **Link Building**: Affects how the :php:`LinkBuilder` and
    :php:`UriBuilder` generate URLs
*   **Site Generator**: Influences the :php:`SiteGenerator` behavior
*   **Protocol Selection**: Determines whether URLs are generated
    with :php:`http://` or :php:`https://`
*   **Redirect Handling**: Controls whether redirects point
    to HTTP or HTTPS URLs

This accurate protocol detection is crucial for maintaining security standards
and ensuring proper functionality across the TYPO3 installation. Incorrect
protocol detection can lead to:

*   Security vulnerabilities due to insecure cookie handling
*   Mixed content warnings in browsers
*   Broken functionality due to incorrect redirect chains
*   Potential security token validation issues

Therefore, proper configuration of reverse proxy settings is essential for
maintaining both security and functionality in TYPO3 installations.

HTTPS Detection and Configuration
---------------------------------

TYPO3 cannot inherently determine whether the original client connection was
HTTP or HTTPS when operating behind a reverse proxy. This is because TYPO3 only
sees the connection between itself and the reverse proxy, which is typically
HTTP and often configured with "HTTPS=on" (e.g., via .htaccess).

*   If the reverse proxy **exclusively** handles HTTPS connections:

    *   Add the proxy's IP address to :php:`reverseProxySSL`
    *   Example: :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL'] = '192.0.2.1';`

*   If the reverse proxy handles **both** HTTP and HTTPS (since TYPO3 13.4):

    *   Add the proxy's IP address to :php:`reverseProxyIP`
    *   TYPO3 will then rely on the proxy's headers
        (typically X-Forwarded-Proto) to determine the protocol
    *   Example: :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '192.0.2.1';`


Protocol Detection Fallback
~~~~~~~~~~~~~~~~~~~~~~~~~~~

TYPO3 implements a hierarchical approach to detect secure connections:

#.  First, checks :php:`reverseProxySSL` configuration
#.  If using :php:`reverseProxyIP`, evaluates the :php:`X-Forwarded-Proto` header
#.  If no :php:`X-Forwarded-Proto` header is present, TYPO3 falls back to
    checking various other HTTP headers and server configuration settings to
    determine the connection security status

This multi-layered approach ensures maximum compatibility with different
reverse proxy configurations while maintaining security awareness in the
application.

..  _reverse-proxy-typo3-configuration:

Configuring TYPO3 to trust a reverse proxy
==========================================

TYPO3 must be explicitly configured to recognize and trust reverse proxy
headers and IP addresses.

For example, add the following lines to :file:`config/system/additional.php`:

..  code-block:: php
    :caption: config/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '192.0.2.1,192.168.0.0/16';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL'] = '192.0.2.1,192.168.0.0/16';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue'] = 'first';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '^(www\.)?example\.com$';

If you deploy the :file:`config/system/additional.php` or have it container in a custom
Docker image you can, for example, use the
`Application Context <https://docs.typo3.org/permalink/t3coreapi:application-context>`_
to limit the reverse proxy settings to the production environment:

..  literalinclude:: _codesnippets/_additional.php
    :caption: config/system/additional.php

You can also use environment variables for configuration

..  seealso::

    The following settings in :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']`:

    *   `reverseProxyIP  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyip>`_
    *   `reverseProxyHeaderMultiValue  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyheadermultivalue>`_
    *   `reverseProxyPrefix  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyprefix>`_
    *   `reverseProxyPrefixSSL  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-reverseproxyprefixssl>`_
    *   `trustedHostsPattern  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-trustedhostspattern>`_

    The following article from the symfony docs might be helpful in determining
    the correct IP address or CIDR ranges: `How to Configure Symfony to Work
    behind a Load Balancer or a Reverse Proxy <https://symfony.com/doc/current/deployment/proxies.html>`_.

In production environments, always use specific IP addresses or CIDR ranges
rather than wildcards.

Omitting parts of the IPv4 address acts as a wildcard (for example `192.168` is
equivalent to `192.168.*.*`). However, using the equivalent CIDR notation
(`192.168.0.0/16`) is the recommended and standardized approach.

Note that IPv6 addresses are supported only with CIDR notation, not wildcards.

..  _reverse-proxy-common-problems:

Common problems when using a reverse proxy
==========================================

TYPO3 installations behind an improperly configured reverse proxy may exhibit
issues such as:

-   Exceptions such as :php:`\TYPO3\CMS\Core\Http\Security\MissingReferrerException`
-   Redirects to the wrong scheme (`http` instead of `https`)
-   Backend login / Install tool login failures or redirect loops

These problems often point to missing or untrusted forwarded headers, or a
mismatch between the trusted host settings and the actual domain used.
