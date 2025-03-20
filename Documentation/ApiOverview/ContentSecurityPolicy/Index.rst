..  include:: /Includes.rst.txt

..  index:: Content Security Policy
..  _content-security-policy:

=======================
Content Security Policy
=======================

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

CSP rules are used to describe, which external links or functionality are allowed for
certain HTML tags (like :html:`<script>`, :html:`<img>`, :html:`<iframe>`). This allows
to restrict external resources or JavaScript execution with security in mind. When
accessing a page, these rules are sent as part of the HTTP Request from the server to
the browser, and the browser will enforce these rules (and reject non-allowed content).
This rejection can also be logged.

Content Security Policy declarations can be applied to a TYPO3 website in
frontend and backend scope with a dedicated API.

To delegate Content Security Policy handling to TYPO3 frontend, at least one of
the feature flags

*   :confval:`globals-typo3-conf-vars-sys-features-security-frontend-enforceContentSecurityPolicy`
    (for enforcing)
*   :confval:`globals-typo3-conf-vars-sys-features-security-frontend-reportContentSecurityPolicy`
    (for report-only mode)

need to be enabled.

..  versionchanged:: 13.0

    In TYPO3 backend the Content Security Policy is always enforced.

Within the TYPO3 backend, a specific backend module is available to inspect policy
violations / reports, and there is also a list to see all configured CSP rules,
see section :ref:`content-security-policy-backend-rules`.


..  _content-security-policy-terminology:

Terminology
=============

This document will use very specific wording that is part of the CSP W3C specification,
these terms are not "invented" by TYPO3. Since reading the W3C RFC can be very
intimidating, here are a few key concepts:

*   CSP consists of multiple rules (or "directives"), that are part of a "policy". This
    policy says, what functionality the site's output is allowed to use.

*   With that, several HTML tags can be controlled, like from which URLs images can be
    requested from, if and from where iframes are allowed, if and from where JavaScripts
    are allowed and so on. There is a long list of applicable directives, see
    `https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy#directives`__
    with specific identifiers like `default-src`, `img-src` and so on.

*   Each directive may have several "attributes" (like the allowed URLs).

*   Directives may build upon each other, a bit like CSS definitions (`Cascading Style Sheet`)
    do. However, these are more meant to modify a basic rule on an earlier level,
    and called "mutations". The relation of a "child rule" to it's "parent" is
    also called "ancestor chain".

*   A final policy is compiled of all these directives, and then sent as a HTTP
    response header `Content-Security-Policy: ...`.

*   In TYPO3, directives can be specified via PHP syntax (within Extensions) and
    YAML syntax (within site configuration).

*   These rules can influence each other, this is where the concept of "mutations" come in.
    The "policy builder" of TYPO3 applies each configured mutation, no matter where it was
    defined.

*   Because of this, each mutation (directive definition) needs a specific "mode" that can
    instruct, how this mutation is applied: Should an existing directive be
    `appended`, `removed` or `added` to the final policy.

*   Each directive is then applied in regard to its defined mode and can list one or more
    "sources" with the values of additional parameters of a directive. Sources are
    web site addresses / URLs.

*   There are possible exemptions to directives for specific content created on specific
    pages created by TYPO3 in your frontend (or backend modules). To verify, that these
    exemptions are valid in a policy, a so-called "Nonce" (Hash) is created.

    *   TYPO3 can manage these Nonces and apply them were configured.
    *   Nonces are retrieved from :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\ConsumableNonce`
        and will be used for any directive within the scope of a single HTTP request.

*   When a webpage with activated policies is shown in a client's browser, each HTML tag
    violating the policy will not be interpreted by the browser.

*   Depending on a configuration of a possible "Report", such violations can be submitted
    back to the server and be evaluated there. TYPO3 provides such an interface to receive
    and display reports in a backend module.

*   Policies can be declared with "dispositions", to indicate how they are handled.
    "Enforce" means that a policy is in effect, and "Report-Only" allows to only pretend
    a policy is in effect, to gather knowledge about possible improvements of a
    webpage's output. Both dispositions can be set independently in TYPO3.

*   All active rules can be seen in the backend configuration section, see
    :ref:`content-security-policy-backend-rules`.

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

    For project integrations, the "mutations" (via
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


..  _content-security-policy-site-active:

Disable CSP for a site
~~~~~~~~~~~~~~~~~~~~~~

The Content Security Policy for a particular site can be disabled with the
:yaml:`active` key set to :yaml:`false`:

..  literalinclude:: _csp_active.yaml
    :language: yaml
    :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml


..  _content-security-policy-site-endpoints:

Site-specific Content-Security-Policy endpoints
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The reporting endpoint is used to receive browser reports about violations to
the security policy, for example if a YouTube-URL was requested, but could
not be displayed in an iframe due to a directive not allowing this.

Reports like this can help to gain insight, what URLs are used by editors
and might need inclusion into the policy.

Since reports can be sent by any browser, they can possibly easily flood
a site with requests and take up storage space. Reports are stored in the
:sql:`sys_http_report` database table.

To influence whether this endpoint accepts reports,
the disposition-specific property `reportingUrl` can be configured and
set to either:

`true`
    to enable the reporting endpoint
`false`
    to disable the reporting endpoint
(string)
    to use the given value as external reporting endpoint

If defined, the site-specific configuration takes precedence over
the global configuration :ref:`contentSecurityPolicyReportingUrl <content-security-policy-reporting-contentSecurityPolicyReportingUrl>`.

In case the explicitly disabled endpoint still would be called, the
server-side process responds with a 403 HTTP error message.

..  _content-security-policy-site-endpoints-disable:

Example: Disabling the reporting endpoint
"""""""""""""""""""""""""""""""""""""""""

..  literalinclude:: _csp_reporting_false.yaml
    :caption: config/sites/<my-site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml

..  _content-security-policy-site-endpoints-custom:

Example: Using custom external reporting endpoint
"""""""""""""""""""""""""""""""""""""""""""""""""

..  literalinclude:: _csp_reporting_custom.yaml
    :caption: config/sites/<my-site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml

..  _content-security-policy-modes:

Content Security Police modes:
------------------------------

Adjusting specific directives / mutations for a policy can be performed
via the following modes:

..  confval-menu::
    :name: content-security-policy-modes

    ..  confval:: append
        :name: content-security-policy-mode-append
        :YAML: :yaml:`append`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::Append`

        Appends to a given directive.

        Example:

        ..  literalinclude:: _csp_mode_append.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 12-15

        ..  literalinclude:: _ContentSecurityPolicies_mode_append.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 27-31

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src 'self'; img-src example.org example.com

    ..  confval:: extend
        :name: content-security-policy-mode-extend
        :YAML: :yaml:`extend`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::Extend`

        Extends the given directive. It is a shortcut for
        :confval:`content-security-policy-mode-inherit-once` and
        :confval:`content-security-policy-mode-append`.

        Example:

        ..  literalinclude:: _csp_mode_extend.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 7-10

        ..  literalinclude:: _ContentSecurityPolicies_mode_extend.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 22-26

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src 'self'; img-src 'self' example.com

    ..  confval:: inherit-again
        :name: content-security-policy-mode-inherit-again
        :YAML: :yaml:`inherit-again`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::InheritAgain`

        Inherits again from the corresponding ancestor chain and merges existing
        sources.

        Example:

        ..  literalinclude:: _csp_mode_inherit_again.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 8-9,21-22

        ..  literalinclude:: _ContentSecurityPolicies_mode_inherit_again.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 23-26,37-40

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src data:; img-src data: 'self' example.com

        Note that `data:` is inherited to `img-src`
        (in opposite to :confval:`content-security-policy-mode-inherit-once`).

    ..  confval:: inherit-once
        :name: content-security-policy-mode-inherit-once
        :YAML: :yaml:`inherit-once`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::InheritOnce`

        Inherits once from the corresponding ancestor chain. When `inherit-once` is
        called multiple times on the same directive, only the first time is applied.

        Example:

        ..  literalinclude:: _csp_mode_inherit_once.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 8-9,21-22

        ..  literalinclude:: _ContentSecurityPolicies_mode_inherit_once.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 23-26,37-40

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src data:; img-src 'self' example.com

        Note that `data:` is not inherited to `img-src`. If you want to inherit
        also `data:` to `img-src` use
        :confval:`content-security-policy-mode-inherit-again`.

    ..  confval:: reduce
        :name: content-security-policy-mode-reduce
        :YAML: :yaml:`reduce`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::Reduce`

        Reduces a directive by a given aspect.

        Example:

        ..  literalinclude:: _csp_mode_reduce.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 9-12

        ..  literalinclude:: _ContentSecurityPolicies_mode_reduce.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 24-28

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src 'self' example.com

    ..  confval:: remove
        :name: content-security-policy-mode-remove
        :YAML: :yaml:`remove`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::Remove`

        Removes a directive completely.

        Example:

        ..  literalinclude:: _csp_mode_remove.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 12-13

        ..  literalinclude:: _ContentSecurityPolicies_mode_remove.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 27-30

        Results in:

        ..  code-block:: http

            Content-Security-Policy: default-src 'self'

    ..  confval:: set
        :name: content-security-policy-mode-set
        :YAML: :yaml:`set`
        :PHP: :php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode::Set`

        Sets (overrides) a directive completely.

        Example:

        ..  literalinclude:: _csp_mode_set.yaml
            :language: yaml
            :caption: config/sites/<my_site>/csp.yaml | typo3conf/sites/<my_site>/csp.yaml
            :emphasize-lines: 2-5

        ..  literalinclude:: _ContentSecurityPolicies_mode_set.php
            :language: php
            :caption: EXT:my_extension/Configuration/ContentSecurityPolicies.php
            :emphasize-lines: 16-20

        Results in:

        ..  code-block:: http

            Content-Security-Policy: img-src 'self'


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
:ref:`asset collector <assets>`. This only refers to referenced files
(via :html:`src` and :html:`href` attributes) and not inline scripts
or inline styles. For those, you should either use the PHP/Fluid approach
as listed below, or use TypoScript only for passing DOM attributes
and using external scripts to actually evaluate these attributes to control
functionality.

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
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <script nonce="{f:security.nonce()}">
        const inline = 'script';
    </script>

    <style nonce="{f:security.nonce()}">
        .some-style { color: red; }
    </style>

You can also use the :ref:`f:asset.script <t3viewhelper:typo3-fluid-asset-script>`
or :ref:`f:asset.css <t3viewhelper:typo3-fluid-asset-css>`
ViewHelpers with the `useNonce` attribute:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:asset.script identifier="my-inline-script" useNonce="1">
        const inline = 'script';
    </f:asset.script>

    <f:asset.css identifier="my-inline-style" useNonce="1">
        .some-style { color: red; }
    </f:asset.css>

.. _content-security-policy-nonce-caching:

Notes about nonces and caching
------------------------------

Nonces are implemented via a PSR middleware and thus applied dynamically. This
also means, they are somewhat "bad" for caching (especially for reverse proxies),
since they create unique output for a specific visitor.

Since the goal of nonces are to allow "exemptions" for otherwise forbidden content,
this closely relates to validity or integrity of this forbidden content. Instead
of emitting unique nonces, another possibility is to utilize hashing functionality
to content regarded as "safe".

This can be done with sha256/sha384/sha512 hashing of referenced script, and including
them as a valid directive, like this:

..  code-block

    - mode: "extend"
      directive: "script-src"
      sources:
        - "sha256-6c7d3c1bf856597a2c8ae2ca7498cb4454a32286670b20cf36202fa578b491a9"

The "sha256-..." block would be the SHA256 hash created from a file like 'script.js'.

For example, a file like this:

..  code-block:: javascript

    console.log('Hello.');

would correspond to a SHA256 hash of `6c7d3c1bf856597a2c8ae2ca7498cb4454a32286670b20cf36202fa578b491a9`

The browser would evaluate a reference JavaScript file and calculate it's SHA256
hash and compare it to the list of allowed hashes.

The downside of this is: Everytime an embedded file changes (like via build processes),
the CSP SHA hash would need to be adopted. This could be automated by a PHP definition
of CSP rules and hashing files automatically, which would be a performance-intense
process and call for its own caching.

There is no automatism for this kind of hashing in TYPO3 (yet), so it has to be done manually.

.. _content-security-policy-backend:
.. _content-security-policy-reporting:

Reporting of violations, CSP Backend module
===========================================

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

..  warning::
    Resolutions, once applied, can not be removed again via the GUI. You would
    need to manually remove entries in the :sql:`sys_csp_resolution` database
    table.

..  _content-security-policy-reporting-contentSecurityPolicyReportingUrl:

Using a third-party service
---------------------------

As an alternative to the built-in reporting module, an external reporting URL
can be configured to use a third-party service as well:

..  code-block:: php
    :caption: config/system/additional.php

    // For backend
    $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl']
        = 'https://csp-violation.example.org/';

    // For frontend
    $GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl']
        = 'https://csp-violation.example.org/';

Violations are then sent to the third-party service instead of the TYPO3
endpoint. Resolutions would then not be applied dynamically.

..  _content-security-policy-reporting-disable:

Disabling content security policy reporting globally
----------------------------------------------------

Administrators can disable the reporting endpoint globally or configure it per
site as needed. (See :ref:`content-security-policy-site-endpoints-disable`).

If defined, the site-specific configuration takes precedence over
the global configuration.

In case the explicitly disabled endpoint still would be called, the
server-side process responds with a 403 HTTP error message.

The global scope-specific setting `contentSecurityPolicyReportingUrl` can
be set to zero ('0') to disable the CSP reporting endpoint:

..  code-block:: php
    :caption: config/system/additional.php

    // For backend
    $GLOBALS['TYPO3_CONF_VARS']['BE']['contentSecurityPolicyReportingUrl'] = '0';

    // For frontend
    $GLOBALS['TYPO3_CONF_VARS']['FE']['contentSecurityPolicyReportingUrl'] = '0';

..  _content-security-policy-backend-rules:

Active content security policy rules
------------------------------------

The backend module :guilabel:`System > Configuration > Content Security Policy Mutations`
uses a simple tree display of all configured directives, grouped by
frontend or backend. Each rule shows where it is defined, and what
its final policy is set to:

..  figure:: /Images/ManualScreenshots/ContentSecurityPolicy/CspBackendConfiguration.png
    :class: with-shadow

    Backend module "Configuration > Content Security Policy Mutations" which displays
    a tree of all policy directives.

..  _content-security-policy-events:

PSR-14 events
=============

The following PSR-14 events are available:

*   :ref:`InvestigateMutationsEvent`
*   :ref:`PolicyMutatedEvent`
