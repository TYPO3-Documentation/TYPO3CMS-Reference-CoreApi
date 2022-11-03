..  include:: /Includes.rst.txt

..  index:: Password policies
..  _password-policies:

=================
Password policies
=================

..  versionadded::  12.0

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

.. contents:: **Table of Contents**
   :depth: 1
   :local:


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
    :caption: config/system/settings.php | typo3conf/system/settings.php

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

+-----------------------------------+----------------------------+------+---------+
| Option                            | Description                | Type | Default |
+-----------------------------------+----------------------------+------+---------+
| :php:`minimumLength`              | Minimum length             | int  | 8       |
+-----------------------------------+----------------------------+------+---------+
| :php:`upperCaseCharacterRequired` | Upper case character check | bool | false   |
+-----------------------------------+----------------------------+------+---------+
| :php:`lowerCaseCharacterRequired` | Lower case character check | bool | false   |
+-----------------------------------+----------------------------+------+---------+
| :php:`digitCharacterRequired`     | Digit check                | bool | false   |
+-----------------------------------+----------------------------+------+---------+
| :php:`specialCharacterRequired`   | Special character check    | bool | false   |
+-----------------------------------+----------------------------+------+---------+

:php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\NotCurrentPasswordValidator`
---------------------------------------------------------------------------

This validator can be used to ensure, that the new user password is not
equal to the old password. The validator must always be configured with
the exclude action :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction::NEW_USER_PASSWORD`,
because it should be excluded, when a new user account is created.


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


Custom password validator
=========================

To create a custom password validator, a new class has to be added which
extends :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\AbstractPasswordValidator`.
It is required to overwrite the following functions:

*   :php:`public function initializeRequirements(): void`
*   :php:`public function validate(string $password, ?ContextData $contextData = null): bool`

Please refer to :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator`
for a detailed implementation example.
