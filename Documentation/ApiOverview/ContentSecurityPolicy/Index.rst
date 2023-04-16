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

..  _content-security-policy-configuration:

Configuration
=============

Policy builder approach
-----------------------

The following approach illustrates how a policy is build:

..  literalinclude:: _Policy.php

The result of the compiled and serialized result as HTTP header would look
similar to this (the following sections are using the same example, but utilize
different techniques for the declarations):

..  code-block:: none

    Content-Security-Policy: default-src 'self';
        img-src 'self' data: https://*.typo3.org; script-src 'self' 'nonce-[random]';
        worker-src blob:


.. _content-security-policy-extension:

Extension-specific
------------------

Policies for frontend and backend can be applied automatically by providing a
:file:`Configuration/ContentSecurityPolicies.php` file in an extension, for
example:

..  literalinclude:: _ContentSecurityPolicies.php
    :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php

..  todo: Explain "Scope", "MutationCollection", "Mutation", "MutationMode", ...


.. _content-security-policy-site:

Site-specific (frontend)
------------------------

In frontend, a dedicated :file:`sites/<my_site>/csp.yaml` can be
used to declare policies for a specific site, for example:

..  literalinclude:: _csp.yaml
    :language: yaml
    :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml

..  todo: Explain "inheritDefault", "mutations", "mode", "directive", "sources", ...


.. _content-security-policy-reporting:

Reporting of violations
=======================

Potential CSP violations are reported back to the TYPO3 system and persisted
internally in the database table :sql:`sys_http_report`. A corresponding
:guilabel:`Admin Tools > Content Security Policy` backend module supports users
to keep track of recent violations and - if applicable - to select potential
resolutions (stored in the database table :sql:`sys_csp_resolution`) which
extends the Content Security Policy for the given scope during runtime:

..  figure:: /Images/ManualScreenshots/ContentSecurityPolicy/BackendModule.png
    :class: with-shadow

    Backend module "Content Security Policy" which displays the violations

Clicking on a row displays the details of this violation on the right side
including suggestions on how to resolve this violation. You have the choice to
apply this suggestion, or to mute or delete the specific violation.

..  note::
    If you apply the suggestion, it is stored in the database table
    :sql:`sys_csp_resolution`. To have all policies in one place, you
    should consider adding the suggestion to your
    :ref:`extension-specific <content-security-policy-extension>` or
    :ref:`site-specific <content-security-policy-site>` CSP definitions
    manually.


Using a third-party service
---------------------------

As an alternative, the reporting URL can be configured to use a third-party
service as well:

..  code-block:: php

    // For backend
    $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl']
        = 'https://csp-violation.example.org/';

    // For frontend
    $GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl']
        = 'https://csp-violation.example.org/';

Violations are then sent to the third-party service instead of the TYPO3
endpoint.


..  _content-security-policy-events:

PSR-14 event
============

The following PSR-14 event is available:

*   :ref:`PolicyMutatedEvent`

