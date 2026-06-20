:navigation-title: Validator

..  include:: /Includes.rst.txt
..  index:: Password, Validator
..  _password-policies-validators:

==========================
Password policy validators
==========================

TYPO3 ships with two password policy validators, which are both used in the
default password policy.

..  contents::

..  _password-policies-validators-CorePasswordValidator:

CorePasswordValidator
=====================

The :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator`
validator has the ability to ensure a complex password with a defined
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

..  _password-policies-validators-NotCurrentPasswordValidator:

NotCurrentPasswordValidator
===========================

The :php:`\TYPO3\CMS\Core\PasswordPolicy\Validator\NotCurrentPasswordValidator`
validator can be used to ensure, that the new user password is not
equal to the old password. The validator must always be configured with
the exclude action :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction::NEW_USER_PASSWORD`,
because it should be excluded, when a new user account is created.


..  _password-policies-third-party-validators:

Third-party password validators
===============================

The extension :t3ext:`add_pwd_policy` provides additional validators.


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

..  _password-policies-third-party-extbase:

Using password policy validation in Extbase
===========================================

If you need to validate a plaintext password within Extbase, for example in a
`Data transfer object (DTO) <https://docs.typo3.org/permalink/t3coreapi:extbase-dto>`_,
you can call the :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyValidator` from
within a custom validator, for example:

..  literalinclude:: _codesnippets/_ExtbasePasswordPolicyValidator.php
    :caption: packages/my_extension/Classes/Domain/Validator/ExtbasePasswordPolicyValidator.php

The error code should be a unique integer. It is common practice in TYPO3
to use the current Unix timestamp in milliseconds when creating a new
validator, as this provides a simple way to generate a unique value.

You can then use your custom Extbase validator in the DTO:

..  literalinclude:: _codesnippets/_UserRegistrationDto.php
    :caption: packages/my_extension/Classes/Domain/Model/Dto/UserRegistrationDto.php

..  warning::
    The password in the DTO is stored in **plaintext**, you have to hash the password
    (see `Password hashing <https://docs.typo3.org/permalink/t3coreapi:password-hashing>`_)
    before saving it to the database. Never persist a password that was not properly hashed.

..  _password-policies-manual-validation:

Validate a password manually in PHP
===================================

You can use the :php:`\TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyValidator` to validate a
password using the validators configured in :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']`.

The class cannot be injected as it must be instantiated with an action. Available actions can be found in
enum :t3src:`core/Classes/PasswordPolicy/PasswordPolicyAction.php`.

..  rubric:: Example:

In the following example a :ref:`command <symfony-console-commands>` to generate
a public-private key pair validates the password from user input against the
default policy of the current TYPO3 installation.

..  literalinclude:: _codesnippets/_PrivateKeyGeneratorCommand.php
    :caption: EXT:my_extension/Classes/Command/PrivateKeyGeneratorCommand.php

..  _password-policies-events:

Events regarding password policy validation
===========================================

The following PSR-14 event is available:

*   :ref:`EnrichPasswordValidationContextDataEvent <EnrichPasswordValidationContextDataEvent>`
