.. include:: ../../../Includes.txt


.. _access-password-reset:

============================
Password Reset Functionality
============================

It is possible for TYPO3 Backend users to reset their password if using the
default TYPO3 login mechanism.

To show the reset link, the following criteria needs to be matched:

*  The user has a password entered previously (used to indicate that no third-party login was used)
*  The user has a valid email added to their user record
*  The user is neither deleted nor disabled
*  The email address is only used once among all Backend users of the instance

Once the user has entered their email address, an email is sent out with a link to set a new password, which needs to have a least eight characters.
The link is valid for 2 hours, and a token is added to the link.
If the password was provided correctly, it is updated for the user, and they can log in.

Notes on security
=================

*  When having multiple users with the same email address, no reset functionality is provided.
*  No information disclosure is built-in, so if the email address is not in the system, it is not disclosed to the outside.
*  Rate limiting is activated for allowing three emails to be sent within 30 minutes per email address.
*  Tokens are stored in the database but hashed again, just like the password.
*  When a user has logged in successfully (e.g., because they remembered the password), the token is removed from the database, effectively invalidating all existing email links.

Global Configuration
====================

The feature is active by default and can be deactivated entirely via the
system-wide configuration option:

:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordReset']`

Optionally it is possible to restrict this feature to non-admins only by setting the following system-wide option to "false".

:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordResetForAdmins']`

Both options are available to be configured within the :guilabel:`Maintenance Area > Settings`
module or in the :guilabel:`Install Tool` but can be set manually via :file:`typo3conf/LocalConfiguration.php` or :file:`typo3conf/AdditionalConfiguration.php`.

Reset password for user
=======================

Administrators can reset a user's password. This is especially useful for security purposes, so an administrator does not need to send a password over the wire in plaintext (e.g. email) to a user.

The administrator can use the CLI command:

.. code-block:: bash

   ./typo3/sysext/core/bin/typo3 backend:resetpassword https://www.example.com/typo3/ editor@example.com

where usage is described like this:

.. code-block:: bash

   backend:resetpassword <backendurl> <email>


.. note::

   The backend URL is necessary to generate the correct links to the TYPO3 instance
   from CLI context.

