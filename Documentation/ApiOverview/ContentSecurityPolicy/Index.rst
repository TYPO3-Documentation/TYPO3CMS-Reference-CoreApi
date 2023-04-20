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

The following configuration properties are available:

..  option:: inheritDefault

    :type: bool
    :Required: false
    :Default: :yaml:`true`

    Whether to inherit default (site-unspecific) frontend policy mutations.

..  option:: mutations

    :type: array
    :Required: true

    A list of mutations which should be applied. Each mutation can provide the
    following properties:

    ..  option:: mode

        :type: string
        :Required: true

        The mode used in a mutation. It can be one of the following:

        :yaml:`set`
            Sets (overrides) a directive completely, for example:

            ..  literalinclude:: _csp-mode-set.yaml
                :language: yaml

        :yaml:`extend`
            Extends a directive by a given aspect, for example:

            ..  literalinclude:: _csp-mode-extend.yaml
                :language: yaml

        :yaml:`reduce`
            Reduces a directive by a given aspect.

            ..  literalinclude:: _csp-mode-reduce.yaml
                :language: yaml

        :yaml:`remove`
            Removes a directive completely, for example:

            ..  literalinclude:: _csp-mode-remove.yaml
                :language: yaml

    ..  option:: directive

        :type: string
        :Required: true

        The `directive`_ used in a mutation. It can be one of the following:

        *   `default-src`_
        *   `base-src`_
        *   `child-src`_
        *   `connect-src`_
        *   `font-src`_
        *   `form-action`_
        *   `frame-ancestors`_
        *   `frame-src`_
        *   `img-src`_
        *   `manifest-src`_
        *   `media-src`_
        *   `object-src`_
        *   `sandbox`_
        *   `script-src`_
        *   `script-src-attr`_
        *   `script-src-elem`_
        *   `style-src`_
        *   `style-src-attr`_
        *   `style-src-elem`_
        *   `worker-src`_

    ..  option:: sources

        :type: array
        :Required: false

        The `sources`_ used in a mutation.

        A source can be an internet host by name or IP address, for example:

        *   :yaml:`https://*.example.com`
        *   :yaml:`sub.example.com:443`
        *   :yaml:`*.example.com`
        *   :yaml:`https://*.example.com:8080/path/to/file.js`

        Or a schema, like:

        *   :yaml:`blob:`
        *   :yaml:`data:`
        *   :yaml:`filesystem:`
        *   :yaml:`mediastream:`

        Or a keyword, such as (note the :yaml:`'` at the beginning and end):

        *   :yaml:`'none'`
        *   :yaml:`'self'`
        *   :yaml:`'nonce-proxy'`
        *   :yaml:`'report-sample'`
        *   :yaml:`'strict-dynamic'`
        *   :yaml:`'unsafe-inline'`
        *   :yaml:`'unsafe-eval'`
        *   :yaml:`'unsafe-hashes'`
        *   :yaml:`'wasm-unsafe-eval'`

        :yaml:`'nonce-proxy'` is substituted woth the current nonce value when
        compiling the whole policy. This value does NOT exist in the CSP
        definition, it is specific to TYPO3 only.


..  _directive: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy#directives
..  _base-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/base-uri
..  _child-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/child-src
..  _connect-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/connect-src
..  _default-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/default-src
..  _font-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/font-src
..  _form-action: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/form-action
..  _frame-ancestors: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/frame-ancestors
..  _frame-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/frame-src
..  _img-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/img-src
..  _manifest-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/manifest-src
..  _media-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/media-src
..  _object-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/object-src
..  _sandbox: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox
..  _script-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src
..  _script-src-attr: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src-attr
..  _script-src-elem: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/script-src-elem
..  _style-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/style-src
..  _style-src-attr: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/style-src-attr
..  _style-src-elem: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/style-src-elem
..  _worker-src: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/worker-src
..  _sources: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/Sources

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

