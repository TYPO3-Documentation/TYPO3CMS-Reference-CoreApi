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

    *   `Introduction to Content Security Policy (CSP) <https://b13.com/blog/introduction-to-content-security-policy-csp>`__
    *   https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
    *   https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy

    At the TYPO3 Developer Days 2023 Oliver Hader talked about Content Security
    Policy in general and in TYPO3:

    *   https://www.youtube.com/watch?v=a_cS2XfCplI&t=28766s

Content Security Policy declarations can be applied to a TYPO3 website in
frontend and backend scope with a dedicated API.

To delegate Content Security Policy handling to TYPO3 frontend, the feature flag
:ref:`security.frontend.enforceContentSecurityPolicy <typo3ConfVars_sys_features_security.frontend.enforceContentSecurityPolicy>`
needs to be enabled.

..  versionchanged:: 13.0

In TYPO3 backend the Content Security Policy is always enforced.

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

..  note::
    The policy builder is the low-level representation and interaction in PHP,
    any other configuration is using the same verbs to describe the CSP
    instructions. The :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\Policy`
    object is used for compiling the CSP in a :ref:`middleware <request-handling>`.
    Thus, custom controllers or middlewares could use this approach; the last
    line

    ..  code-block:: php

        header('Content-Security-Policy: ' . $policy->compile($nonce));

    is an example to show the basic principle without having to explain
    :ref:`PSR-7 <typo3-request>`/:ref:`PSR-15 <request-handling>` details.

    For project integrations the "mutations" (via
    :ref:`configuration <content-security-policy-extension>`,
    :ref:`YAML <content-security-policy-site>`,
    :ref:`resolutions in the UI <content-security-policy-reporting>` or
    :ref:`events <content-security-policy-events>`) shall be used.


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


.. _content-security-policy-nonce:

Nonce
=====

    The nonce attribute is useful to allowlist specific elements, such as a
    particular inline script or style elements. It can help you to avoid using
    the CSP unsafe-inline directive, which would allowlist all inline scripts or
    styles.

    -- MDN Web Docs, https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/nonce

It may look like this in your HTML code:

..  code-block:: html

    <link
        rel="stylesheet"
        href="/_assets/af46f1853e4e259cbb8ebcb816eb0403/Css/styles.css?1687696548"
        media="all"
        nonce="sqK8LkqFp-aWHc7jkHQ4aT-RlUp5cde9ZW0F0-BlrQbExX-PRMoTkw"
    >

    <style nonce="sqK8LkqFp-aWHc7jkHQ4aT-RlUp5cde9ZW0F0-BlrQbExX-PRMoTkw">
        /* some inline styles */
    </style>

    <script
        src="/_assets/27334a649e36d0032b969fa8830590c2/JavaScript/scripts.js?1684880443"
        nonce="sqK8LkqFp-aWHc7jkHQ4aT-RlUp5cde9ZW0F0-BlrQbExX-PRMoTkw"
    ></script>

    <script nonce="sqK8LkqFp-aWHc7jkHQ4aT-RlUp5cde9ZW0F0-BlrQbExX-PRMoTkw">
        /* some inline JavaScript */
    </script>

The nonce changes with each request so that (possibly malicious) inline scripts
or styles are blocked by the browser.

The nonce is applied automatically, when scripts or styles are defined with the
TYPO3 API, like TypoScript (:typoscript:`page.includeJS`, etc.) or the
:ref:`asset collector <assets>`.

TYPO3 provides APIs to get the nonce for the current request:

Retrieve with PHP
-----------------

The nonce can be retrieved via the
:ref:`nonce request attribute <typo3-request-attribute-nonce>`:

..  code-block:: php

    // use TYPO3\CMS\Core\Domain\ConsumableString

    /** @var ConsumableString|null $nonce */
    $nonceAttribute = $this->request->getAttribute('nonce');
    if ($nonceAttribute instanceof ConsumableString) {
        $nonce = $nonceAttribute->consume();
    }

In a Fluid template
-------------------

The :ref:`f:security.nonce <t3viewhelper:typo3-fluid-security-nonce>` ViewHelper
is available, which provides the nonce in a Fluid template, for example:

..  code-block:: html

    <script nonce="{f:security.nonce()}">const inline = 'script';</script>


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

PSR-14 events
=============

The following PSR-14 events are available:

*   :ref:`InvestigateMutationsEvent`
*   :ref:`PolicyMutatedEvent`

