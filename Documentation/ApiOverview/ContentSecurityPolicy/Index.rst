..  include:: /Includes.rst.txt

..  index:: Content Security Policy
..  _content-security-policy:

=======================
Content Security Policy
=======================

..  versionadded:: 12.3

..  contents::
    :local:

Introduction
============

Content Security Policy (CSP) is a security standard introduced to prevent
:ref:`cross-site scripting (XSS) <security-xss>`, clickjacking and other code
injection attacks resulting of malicious content being executed in the trusted
web page context.

..  seealso::
    If you are not familiar with Content Security Policy, please read the
    following resources:

    *   https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
    *   https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy

Content Security Policy declarations can be applied to a TYPO3 website in
frontend and backend scope with a dedicated API.

To delegate Content Security Policy handling to TYPO3, the scope-specific
feature flags need to be enabled:

*   :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.backend.enforceContentSecurityPolicy'] <typo3ConfVars_sys_features_security.backend.enforceContentSecurityPolicy>`
*   :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['security.frontend.enforceContentSecurityPolicy'] <typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy>`

For new installations :php:`security.backend.enforceContentSecurityPolicy` is
enabled by default.

..  todo: Explain general approach

Configuration
=============

Extension-specific
------------------

..  todo: Explain file Configuration/ContentSecurityPolicies.php in
          configuration section

Policies for frontend and backend can be applied automatically by providing a
:file:`Configuration/ContentSecurityPolicies.php` file in an extension, for
example:

..  literalinclude:: _ContentSecurityPolicies.php
    :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php

..  todo: Explain "Scope", "MutationCollection", "Mutation", "MutationMode", ...

Site-specific (frontend)
------------------------

..  todo: Explain file sites/my-site/csp.yaml in configuration section

In frontend, a dedicated :file:`sites/<my-site>/csp.yaml` can be
used to declare policies for a specific site, for example:

..  literalinclude:: _csp.yaml
    :language: yaml
    :caption: config/sites/<my-site>/csp.yaml | typo3conf/sites/<my-site>/csp.yaml

..  todo: Explain "inheritDefault", "mutations", "mode", "directive", "sources", ...

PSR-14 event
============

The following PSR-14 event is available:

*   :ref:`PolicyMutatedEvent`

