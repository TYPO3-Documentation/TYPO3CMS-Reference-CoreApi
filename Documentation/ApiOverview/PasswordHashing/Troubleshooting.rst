.. include:: /Includes.rst.txt
.. index:: 
   Password hashing
   Troubleshooting
   pair: Password; Troubleshooting
.. _password-hashing_troubleshooting:

===============
Troubleshooting
===============

.. versionadded:: 9
   Starting with TYPO3 v9 argon2i is the standard hashing mechanism

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
backend login is performed before the install tool has executed silent
upgarde wizards.


Solutions
---------

Recommended: Fix the server side
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is highly recommended to run PHP 7.2 with argon2i support.
Install a PHP build that supports this or make the project hoster support
PHP 7.2 or above with argon2i. Usually, the argon library is just not installed
and PHP is compiled without argon2i support. There is little reason to have a
PHP 7.2 build without argon support.


Disable argon2i support in the install tool
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Call the standalone install tool at example.com/typo3/install.php and log in
once. This should detect
that argon2i is not available and will configure a different default
hash mechanism. A backend login should be possible afterwards.

If that won't do, you can change the hash mechanism in :guilabel:`Admin Tools >
Settings > Configuration Presets > Password hashing presets`. This
might be necessary if, for example, you moved your system to a different
server where argon2i isn't available. Create a new user that uses the
working algorithm.


.. index:: File; typo3conf/LocalConfiguration.php

Manually disable argon2i in the LocalConfiguration.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This may be nessesary if access to the install tool is not possible.
This can happen when the first installation was done on a system with argon2i
and the installation was then copied to a target system that doesn't support
this encryption type.

Add or edit the following in your :file:`typo3conf/LocalConfiguration.php`.

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

If this doesn't work then check file :file:`typo3conf/AdditionalConfiguration.php` which
overrides :file:`typo3conf/LocalConfiguration.php`.

