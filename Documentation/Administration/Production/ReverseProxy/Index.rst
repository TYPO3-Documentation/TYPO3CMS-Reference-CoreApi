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

..  _reverse-proxy-typo3-configuration:

Configuring TYPO3 to trust a reverse proxy
==========================================

TYPO3 must be explicitly configured to recognize and trust reverse proxy
headers and IP addresses.

Add the following lines to :file:`config/system/additional.php`:

..  code-block:: php
    :caption: config/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '192.0.2.1,192.168.0.0/16';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxySSL'] = '192.0.2.1,192.168.0.0/16';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue'] = 'first';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '^(www\.)?example\.com$';

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
