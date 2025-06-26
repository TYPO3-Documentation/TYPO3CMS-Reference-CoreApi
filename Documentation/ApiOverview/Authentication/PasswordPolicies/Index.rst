..  include:: /Includes.rst.txt

..  index:: Password policies
..  _password-policies:

=================
Password policies
=================

..  versionadded::  12.0

.. contents::
   :depth: 1
   :local:


Introduction
============

TYPO3 includes a password policy validator which can be used to validate
passwords against configurable password policies. A default password policy is
included which ensures that passwords meet the following requirements:

*   At least 8 characters
*   At least one number
*   At least one upper case character
*   At least one special character
*   It must be different than current password (if available)

Password policies can be configured individually for both frontend and backend
context. It is also possible to extend a password policy with custom validation
requirements.

The password policy applies to:

*   Creating a backend user during installation
*   Setting a new password for a backend user in :guilabel:`User settings`
*   Resetting a password for a backend user
*   Resetting a password for a frontend user
*   Password fields in tables :sql:`be_users` and :sql:`fe_users`

Optionally, a password policy can be configured for custom TCA fields of the
type :ref:`password <t3tca:columns-password>`.

..  _configure-password-policies:

Configuring password policies
=============================

A password policy is defined in the TYPO3 global configuration. Each policy
must have a unique identifier (the identifier `default` is reserved by TYPO3)
and must at least contain one validator.

The password policy identifier is used to assign the defined password policy
to the backend and/or frontend context. By default, TYPO3 uses the
password policy `default`:

..  code-block:: php
    :caption: config/system/settings.php | typo3conf/system/settings.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy'] = 'default';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] = 'default';

..  seealso::

    :ref:`Default password policy configuration <typo3ConfVars_sys_passwordPolicies>`

A custom password policy with the identifier `simple` can be configured like:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies'] = [
        'simple' => [
            'validators' => [
                \TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator::class => [
                    'options' => [
                        'minimumLength' => 6,
                    ],
                ],
            ],
        ],
    ];

Then assign the custom password policy `simple` to frontend and/or backend
context:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy'] = 'simple';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] = 'simple';

..  attention::
    When implementing a custom password policy please refer to the
    :ref:`secure password guidelines <security-secure-passwords>`.


Password policy validators
==========================

TYPO3 ships with two password policy validators, which are both used in the
default password policy.

:php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator`
---------------------------------------------------------------------

This validator has the ability to ensure a complex password with a defined
minimum length and four individual requirements.

The following options are available:

..  confval:: minimumLength

    :type: int
    :Default: 8

    The minimum length of a given password.

..  confval:: upperCaseCharacterRequired

    :type: bool
    :Default: true

    If set to :php:`true` at least one upper case character (`A`-`Z`) is required.

..  confval:: lowerCaseCharacterRequired

    :type: bool
    :Default: true

    If set to :php:`true` at least one lower case character (`a`-`z`) is required.

..  confval:: digitCharacterRequired

    :type: bool
    :Default: true

    If set to :php:`true` at least one digit character (`0`-`9`) is required.

..  confval:: specialCharacterRequired

    :type: bool
    :Default: true

    If set to :php:`true` at least one special character (not `0`-`9`, `a`-`z`,
    `A`-`Z`) is required.


:php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\NotCurrentPasswordValidator`
---------------------------------------------------------------------------

This validator can be used to ensure, that the new user password is not
equal to the old password. The validator must always be configured with
the exclude action :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction::NEW_USER_PASSWORD`,
because it should be excluded, when a new user account is created.


..  _password-policies-third-party-validators:

Third-party validators
----------------------

The extension :t3ext:`add_pwd_policy` provides additional validators.

Disable password policies globally
==================================

To disable the password policy globally (e.g. for local development) an empty
string has to be supplied as password policy for frontend and backend context:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    if (\TYPO3\CMS\Core\Core\Environment::getContext()->isDevelopment()) {
        $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy'] = '';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] = '';
    }

..  warning::
    Do **not** deactivate the password policies on a production server as this
    decreases security massively. In the example above the deactivation of
    the password policies is wrapped into a condition which is only applied
    in development context.


..  _password-policies-custom-validator:

Custom password validator
=========================

To create a custom password validator, a new class has to be added which
extends :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\AbstractPasswordValidator`.
It is required to overwrite the following functions:

*   :php:`public function initializeRequirements(): void`
*   :php:`public function validate(string $password, ?ContextData $contextData = null): bool`

Please refer to :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator`
for a detailed implementation example.

..  tip::
    The third-party extension :composer:`derhansen/add_pwd_policy` provides additional
    password validators. It can also be used as a resource for writing your
    own password validator.

Validate a password manually
============================

You can use the :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyValidator` to validate a
password using the validators configured in :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']`.

The class cannot be injected as it must be instantiated with an action. Available actions can be found in
enum :t3src:`core/Classes/PasswordPolicy/PasswordPolicyAction.php`.

..  rubric:: Example:

In the following example a :ref:`command <symfony-console-commands>` to generate
a public-private key pair validates the password from user input against the
default policy of the current TYPO3 installation.

..  literalinclude:: _PrivateKeyGeneratorCommand.php
    :language: php
    :caption: EXT:my_extension/Classes/Command/PrivateKeyGeneratorCommand.php

Event
=====

The following PSR-14 event is available:

*   :ref:`EnrichPasswordValidationContextDataEvent <EnrichPasswordValidationContextDataEvent>`
