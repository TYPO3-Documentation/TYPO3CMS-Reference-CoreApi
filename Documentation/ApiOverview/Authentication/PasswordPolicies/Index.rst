..  include:: /Includes.rst.txt

..  index:: Password policies
..  _password-policies:

=================
Password policies
=================


..  toctree::
    :caption: Subpages
    :glob:
    :titlesonly:

    */Index

..  contents:: Sections

TYPO3 includes a password policy validator which can be used to validate
passwords against configurable password policies.

TYPO3 ships with three preconfigured policies:

*   `default` Used for backend and frontend users
*   `installTool` Used for Install Tool passwords
*   `secretToken` Used for secret token fields (e.g. webhooks, reactions)

Each policy contains both a `generator` and a `validators` section. The
generator is responsible for creating passwords, while validators enforce
password requirements. They are configured independently within the same
policy.

A password policy can also define `Password generators <https://docs.typo3.org/permalink/t3coreapi:password-generator>`_
and `Password policy validators <https://docs.typo3.org/permalink/t3coreapi:password-policies-validators>`_.

The `default` password policy ensures that passwords meet the
following requirements:

*   At least 8 characters
*   At least one number
*   At least one upper case character
*   At least one special character
*   It must be different than current password (if available)

Password policies can be configured individually for both frontend and backend
context. It is also possible to extend a password policy with custom validation
requirements.

Password policies apply to:

*   Creating a backend user during installation (`installTool`)
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

    use TYPO3\CMS\Core\PasswordPolicy\Generator\PasswordGenerator;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['simple'] = [
        'validators' => [
            CorePasswordValidator::class => [
                'options' => [
                    'minimumLength' => 6,
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


..  _password-policies-disable:

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
