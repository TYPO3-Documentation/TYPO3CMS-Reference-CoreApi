.. include:: /Includes.rst.txt
.. index::
   Password hashing
   Troubleshooting
   pair: Password; Troubleshooting
.. _password-hashing_troubleshooting:

===============
Troubleshooting
===============

#1533818591 InvalidPasswordHashException
========================================

If the hashing mechanism used in passwords is not supported by your PHP build
Errors like the following might pop up:

.. code-block:: text

   #1533818591 TYPO3\CMS\Core\Crypto\PasswordHashing\InvalidPasswordHashException
   No implementation found that handles given hash. This happens if the
   stored hash uses a mechanism not supported by current server.


Explanation
-----------

If an instance has just been upgraded and if *argon2i* hash mechanism is
not available locally, the default backend will still try to upgrade a
given user password to *argon2i* if the install tool has not been
executed once.

This typically happens if a system has just been upgraded and a
backend login has been performed before the install tool has executed
the silent configuration upgrade.


Solutions
---------

Recommended: Fix the server side
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is highly recommended to run PHP 7.2 or above with argon2 support.
Install a PHP build that supports this or make the project hoster support
PHP with argon2. Usually, the argon2 library is just not installed
and PHP is compiled without argon2 support. There is little reason to have a
PHP build without argon support.


Disable argon2 support in the install tool
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Call the standalone install tool at :samp:`example.org/typo3/install.php` and log in
once. This should detect
that argon2 is not available and will configure a different default
hash mechanism. A backend login should be possible afterwards.

If that won't do, you can change the hash mechanism in :guilabel:`System >
Settings > Configuration Presets > Password hashing presets`. This
might be necessary if, for example, you moved your system to a different
server where argon2 isn't available. Create a new user that uses the
working algorithm.


.. index:: File; config/system/settings.php

Manually disable argon2 in the :file:`config/system/settings.php`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This may be necessary if access to the install tool is not possible.
This can happen when the first installation was done on a system with argon2
and the installation was then copied to a target system that doesn't support
this encryption type.

Add or edit the following in your :file:`config/system/settings.php`.

.. code-block:: php

   <?php
   return [
      'BE' => [
         // ...
         // This pseudo password enables you to load the standalone install
         // tool to be able to generate a new hash value. Change the password
         // at once!
         'installToolPassword' => '$2y$12$AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
         'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
            'options' => [],
         ],
      ],
      'FE' => [
         // ...
         'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
            'options' => [],
         ],
      ],
      // ...
   ];

If this doesn't work then check file :file:`config/system/additional.php` which
overrides :file:`config/system/settings.php`.
