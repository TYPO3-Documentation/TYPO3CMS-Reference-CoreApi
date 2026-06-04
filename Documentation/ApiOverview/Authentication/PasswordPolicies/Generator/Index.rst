:navigation-title: Generator

..  include:: /Includes.rst.txt
..  index:: Password generators
..  _password-generator:

==================
Password generator
==================

..  versionadded::  14.2
    Introduced to replace the now deprecated `passwordRules` option
    of the `passwordGenerator` field control

..  contents::

TYPO3 provides a password generator field control for TCA fields. It can be
used to generate passwords or secret values directly in backend forms.

Password generation is configured through password policies registered in
:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']`.

Each password policy can define a `generator` section. The generator must
use a class implementing
:php-short:`TYPO3\CMS\Core\PasswordPolicy\Generator\PasswordGeneratorInterface`.

The TCA field control references the password policy by name via the
`passwordPolicy <https://docs.typo3.org/permalink/t3tca:confval-password-passwordpolicy>`_
option.

..  _password-generator-configuration:

Configure a password generator
==============================

By default the following password policy generator is defined:

..  literalinclude:: _codesnippets/_default.php
    :caption: Default password generator

You can configure its options by overriding or adding them in your
:file:`config/system/additional.php` or :file:`typo3conf/system/additional.php`:

..  literalinclude:: _codesnippets/_additional.php
    :caption: config/system/additional.php

See the available options below:

..  _password-generator-options:

Available password generator options
====================================

The default password generator supports the following options:

..  confval-menu::
    :display: table
    :type:
    :Default:

    ..  confval:: length
        :name: password-generator-length
        :type: integer
        :Default: 12

        Defines the length of the generated password.

    ..  confval:: upperCaseCharacters
        :name: password-generator-upperCaseCharacters
        :type: boolean
        :Default: true

        Whether uppercase characters should be used.

    ..  confval:: lowerCaseCharacters
        :name: password-generator-lowerCaseCharacters
        :type: boolean
        :Default: true

        Whether lowercase characters should be used.

    ..  confval:: digitCharacters
        :name: password-generator-digitCharacters
        :type: boolean
        :Default: true

        Whether digits should be used.

    ..  confval:: specialCharacters
        :name: password-generator-specialCharacters
        :type: boolean
        :Default: true

        Whether special characters should be used.

..  _password-generator-custom:

Custom password generators
==========================

A custom password generator can be used by implementing
:php:`TYPO3\CMS\Core\PasswordPolicy\Generator\PasswordGeneratorInterface`
and referencing the class in the policy configuration:

..  literalinclude:: _codesnippets/_customGeneratorPolicyRegistration.php
    :caption: config/system/additional.php

The generator options are passed to the configured generator class.
