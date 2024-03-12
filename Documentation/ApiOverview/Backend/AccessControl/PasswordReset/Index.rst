..  include:: /Includes.rst.txt
..  index:: pair: Backend; Password reset
..  _access-password-reset:

============================
Password reset functionality
============================

TYPO3 backend users can reset their password if they use the default TYPO3 login
mechanism.

To display the reset link on the backend login page, the following criteria must
be met:

*   The user has a password entered previously (indicating that no third-party
    login has been used).
*   The user has a valid email address added to their user record.
*   The user is neither deleted nor disabled.
*   The email address is used only once for all backend users of the instance.

Once the user has entered their email address, an email is sent with a link that
allows to set a new password, which must consist of at least eight characters.
The link is valid for 2 hours and a token is added to the link. If the password
is entered correctly, it will be updated for the user and they can log in.

Notes on security
=================

*   When having multiple users with the same email address, no reset
    functionality is provided.
*   No information disclosure is built-in, so if the email address is not in the
    system, it is not disclosed to the outside.
*   Rate limiting is enabled so that three emails can be sent per email address
    within 30 minutes.
*   Tokens are stored in the database but hashed again just like the password.
*   When a user has logged in successfully (for example, because they remembered
    the password), the token is removed from the database, effectively
    invalidating all existing email links.

.. index:: Backend; passwordReset
.. index:: Backend; passwordResetForAdmins

Global configuration
====================

The feature is enabled by default and can be deactivated entirely via the
system-wide configuration option:

..  code-block:: php
    :caption: typo3conf/AdditionalConfiguration.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordReset'] = false;

Optionally, it is possible to restrict this feature to non-admins only by setting
the following system-wide option to :php:`false`.

..  code-block:: php
    :caption: typo3conf/AdditionalConfiguration.php

    $GLOBALS['TYPO3_CONF_VARS']['BE']['passwordResetForAdmins'] = false;

Both options are available to be configured within the :guilabel:`Admin Tools > Settings`
module or in the :guilabel:`Install Tool` but can be set manually via :file:`typo3conf/LocalConfiguration.php` or :file:`typo3conf/AdditionalConfiguration.php`.

Reset password for user
=======================

Administrators can reset a user's password. This is useful primarily for
security reasons, so that an administrator does not have to send a password over
to a user in plain text (for example, by email).

The administrator can use the :ref:`CLI command <symfony-console-commands>`:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 backend:resetpassword https://example.com/typo3/ editor@example.com

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 backend:resetpassword https://example.com/typo3/ editor@example.com

where usage is described like this:

..  code-block:: bash

    backend:resetpassword <backend_url> <email_address>


..  note::
    The backend URL is necessary to generate the correct links to the TYPO3
    instance from CLI context.

