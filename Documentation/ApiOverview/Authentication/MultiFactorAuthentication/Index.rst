..  include:: /Includes.rst.txt
..  index:: Authentication, MFA, OTP
..  _multi-factor-authentication:

===========================
Multi-factor authentication
===========================

..  contents::
    :local:

Introduction
============

TYPO3 is capable of authentication via multiple factors, in short
"multi-factor authentication" or "MFA". This is sometimes also referred to
"2FA" as a 2-factor authentication process, where - in order to log in - the
user needs

1.  "something to know" (= the password) and
2.  "something to own" (= an authenticator device, or an authenticator app
    on mobile phones or desktop devices).

Read more about the concepts of MFA here:
https://en.wikipedia.org/wiki/Multi-factor_authentication

..  figure:: /Images/ManualScreenshots/Frontend/Authentication/MfaEnterCode.png
    :alt: TYPO3 Login Screen for entering MFA code (TOTP)
    :class: with-border with-shadow

TYPO3 ships with some built-in MFA providers by default. But more importantly,
TYPO3 provides an API to allow extension authors to integrate their own
MFA providers.

The API is designed in a way to allow providers to be used for TYPO3 backend
authentication or frontend authentication with a multi-factor step in-between.

..  note::
    Currently, TYPO3 provides the integration for the TYPO3 backend. It is
    planned to support multi-factor authentication for the frontend in the
    future.

Managing MFA providers is currently possible via the :guilabel:`User Settings`
module in the tab called :guilabel:`Account security`.

..  include:: /Images/AutomaticScreenshots/Authentication/MfaActivate.rst.txt

The :guilabel:`Account security` tab displays the current state:

-   whether MFA can be configured
-   whether MFA is activated or
-   whether some MFA providers are locked


..  _multi-factor-authentication-included-providers:

Included MFA providers
----------------------

TYPO3 Core includes two MFA providers:

Time-based one-time password (TOTP)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

TOTP is the most common MFA implementation. A QR code is scanned (or alternatively,
a shared secret can be entered) to connect an authenticator app such as Google
Authenticator, Microsoft Authenticator, 1Password, Authly, or others to the
system and then synchronize a token, which changes every 30 seconds.

On each log-in, after successfully entering the password, the six-digit code
shown by the authenticator app must be entered.

Recovery codes
~~~~~~~~~~~~~~

This is a special provider which can only be activated, if at least one other
provider is active. It is only meant as a fallback provider, in case the
authentication credentials for the "main" provider(s) are lost. It is encouraged
to activate this provider, and keep the codes at a safe place.

..  include:: /Images/AutomaticScreenshots/Authentication/MfaSelectProvider.rst.txt

Third-party MFA providers
-------------------------

Some third-party MFA providers are available:

*   `E-Mail MFA Provider <https://extensions.typo3.org/extension/mfa_email>`__
*   `HOTP MFA Provider <https://extensions.typo3.org/extension/mfa_hotp>`__
*   `WebAuthn Provider (FIDO2/U2F) for MFA <https://extensions.typo3.org/extension/mfa_webauthn>`__
*   `YubiKey OTP MFA provider <https://extensions.typo3.org/extension/mfa_yubikey>`__


Setting up MFA for a backend user
---------------------------------

Each provider is displayed with its icon, the name and a short description in
the MFA configuration module. In case a provider is active, this is indicated by
a corresponding label, next to the provider's title. The same goes for a locked
provider - an active provider, which can currently not be used since the
provider-specific implementation detected some unusual behaviour, for example,
too many false authentication attempts. Additionally, the configured default
provider indicates this state with a "star" icon, next to the provider's title.

Each inactive provider contains a :guilabel:`Setup` button which opens the
corresponding configuration view. This view can be different depending on the
MFA provider.

..  include:: /Images/AutomaticScreenshots/Authentication/MfaQrCode.rst.txt

Each provider contains an :guilabel:`Edit/Change` button, which allows to adjust
the provider's settings. This view allows, for example, to set a provider as the
default (primary) provider, to be used on authentication.

..  note::
    The default provider setting will be automatically applied on activation of
    the first provider, or in case it is the recommended provider for this user.

In case the provider is locked, the :guilabel:`Edit/Change` button changes its button
title to :guilabel:`Unlock`. This button can be used to unlock the provider.
This, depending on the provider to unlock, may require further actions by the
user.

The :guilabel:`Deactivate` button can be used to deactivate the provider.
Depending on the provider, this will usually completely remove all
provider-specific settings.

The "Authentication view" is displayed as soon as a user
with at least one active provider has successfully passed the username and
password mask.

As for the other views, it is up to the specific provider, used for the current
multi-factor authentication attempt, what content is displayed in which view.
If the user has further active providers, the view displays them
as "Alternative providers" in the footer to allow the user to switch between all
activated providers on every authentication attempt.

All providers need to define a locking functionality. In case of the TOTP and
recovery code providers, this, for example, includes an attempts count. These
providers are locked in case a wrong OTP was entered three times in a
row. The count is automatically reset as soon as a correct OTP is
entered or the user unlocks the provider in the backend.

All TYPO3 Core providers also feature the "Last used" and "Last updated"
information which can be retrieved in the "Edit/Change" view.

By default, the field in the :guilabel:`User Settings` module is displayed for
every backend user. It is possible to
:ref:`disable <t3tsref:user-setup-fields-fieldName-disabled>` it for specific
users via user TSconfig:

..  code-block:: typoscript

    setup.fields.mfaProviders.disabled = 1

Administration of user's MFA providers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If a user is not able to access the backend anymore, for example, because all of
their active providers are locked, MFA needs to be disabled by an administrator
for this specific user.

Administrators are able to manage the user's MFA providers in the corresponding
user record. The new :guilabel:`Multi-factor authentication` field displays a
list of active providers and a button to deactivate MFA for the user, or
only a specific MFA provider.

..  note::
    All of these deactivate buttons are executed immediately, after
    confirming the dialog, and cannot be undone.

The listing of backend users in the :guilabel:`Administration > Users` module
also displays for each user, whether MFA is enabled or currently locked. This
allows an administrator to analyze the MFA usage of their users at a glance.

The :guilabel:`System > Configuration` administration module shows an overview
of all currently registered providers in the installation. This is especially
helpful to find out the exact provider identifier, needed for some
user TSconfig options.

..  include:: /Images/AutomaticScreenshots/Authentication/MfaConfigurationModule.rst.txt


Configuration
-------------

Enforcing MFA for users
~~~~~~~~~~~~~~~~~~~~~~~

It seems reasonable to require MFA for specific users or user groups. This can
be achieved with
:ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['requireMfa'] <typo3ConfVars_be_requireMfa>`
which allows four options:

`0`
    Do not require multi-factor authentication (default)

`1`
    Require multi-factor authentication for all users

`2`
    Require multi-factor authentication only for non-admin users

`3`
    Require multi-factor authentication only for admin users

To set this requirement only for a specific user or user group, a user TSconfig
option `auth.mfa.required <t3tsref:user-auth-mfa-required>` is available.
The user TSconfig option overrules the global configuration.

..  code-block:: typoscript

    auth.mfa.required = 1


Allowed provider
~~~~~~~~~~~~~~~~

It is possible to only allow a subset of the available providers for some users
or user groups.

A configuration option "Allowed multi-factor authentication providers" is
available in the user groups record in the "Access List" tab.

There may be use cases in which a single provider should be
disallowed for a specific user, which is configured to be allowed in
one of the assigned user groups. Therefore, the user TSconfig option
:ref:`auth.mfa.disableProviders <t3tsref:user-auth-mfa-disableProviders>` can
be used. It overrules the configuration from the "Access List": if a provider is
allowed in "Access List" but disallowed via user TSconfig, it will be disallowed
for the user or user group the TSconfig applies to.

This does not affect the remaining allowed providers from the "Access List".

..  code-block:: typoscript

    auth.mfa.disableProviders := addToList(totp)

Recommended provider
~~~~~~~~~~~~~~~~~~~~

To recommend a specific provider,
:ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['recommendedMfaProvider'] <typo3ConfVars_be_recommendedMfaProvider>`
can be used and is set to `totp` (time-based one-time password) by default.

To set a recommended provider on a per user or user group basis, the user
TSconfig option :ref:`auth.mfa.recommendedProvider <t3tsref:user-auth-mfa-recommendedProvider>`
can be used, which overrules the global configuration.

..  code-block:: typoscript

    auth.mfa.recommendedProvider = totp


TYPO3 integration and API
-------------------------

To register a custom MFA provider, the provider class has to implement the
:t3src:`core/Classes/Authentication/Mfa/MfaProviderInterface.php`, shipped via a
third-party extension. The provider then has to be configured in the extension's
:file:`Services.yaml` or :file:`Services.php` file with the :yaml:`mfa.provider`
tag.

..  literalinclude:: RegisterCustomProvider.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

This will register the provider :php:`MyProvider` with the :yaml:`my-provider`
identifier. To change the position of your provider the :yaml:`before` and
:yaml:`after` arguments can be useful. This can be needed, for example, if you
like your provider to show up prior to any other provider in the MFA
configuration module. The ordering is also taken into account in the
authentication step while logging in. Note that the user-defined default
provider will always take precedence.

If you do not want your provider to be selectable as a default provider, set the
:yaml:`defaultProviderAllowed` argument to `false`.

You can also completely deactivate existing providers with:

..  literalinclude:: DeactivateExistingProvider.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

You can also register multiple providers:

..  literalinclude:: RegisterMultipleProviders.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The :php:`MfaProviderInterface` contains a lot of methods to be implemented by
the providers. This can be split up into state-providing ones, for example,
:php:`isActive()` or :php:`isLocked()`, and functional ones, for example,
:php:`activate()` or :php:`update()`.

Their exact task is explained in the corresponding PHPDoc of the interface files
and the Core MFA provider implementations.

All of these methods are receiving either the current
:ref:`PSR-7 request object <typo3-request>`, the
:php:`\TYPO3\CMS\Core\Authentication\Mfa\MfaProviderPropertyManager` or both.
The :php:`MfaProviderPropertyManager` can be used to retrieve and update the
provider-specific properties and also contains the :php:`getUser()` method,
providing the current user object.

To store provider-specific data, the MFA API uses a new database field :sql:`mfa`,
which can be freely used by the providers. The field contains a JSON-encoded
array with the identifier of each provider as array key. Common properties of
such provider array could be `active` or `lastUsed`. Since the information is
stored in either the :sql:`be_users` or the :sql:`fe_users` table, the context
is implicit. Same goes for the user the providers deal with. It is important to
have such a generic field so providers are able to store arbitrary data, TYPO3
does not need to know about.

To retrieve and update the providers data, the already mentioned
:php:`MfaProviderPropertyManager`, which is automatically passed to all
necessary provider methods, should be used. It is highly discouraged
to directly access the :sql:`mfa` database field.
